<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,DB};

class ProductController extends Controller
{

        /** @var \App\Models\User $user */
    public $user;
    
    /** @var \App\Models\Panier|null $cart */
public $cart;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    protected function getAllChildCategoryIds($category)
{
    $ids = [$category->id];
    
    foreach ($category->children as $child) {
        $ids = array_merge($ids, $this->getAllChildCategoryIds($child));
    }
    
    return $ids;
}


    public function index(CartController $cartController)
    {
    


$categories = Categories::with(['children.children' => function($query) {
    $query->where('status', 1)->orderBy('order');
}])
->whereNull('parent_id')
->where('status', 1)
->orderBy('order')
->get();

$category = request()->category ? Categories::find(request()->category) : null;
$subCategory = request()->subcategory ? Categories::with('parent')->find(request()->subcategory) : null;
$subSubCategory = request()->subsubcategory ? Categories::with('parent.parent')->find(request()->subsubcategory) : null;


$articlesQuery = Article::with(['category.parent.parent', 'images'])
    ->whereHas('category', function($query) {
        $query->where('status', 1);
    });



    if ($subSubCategory) {
        $articlesQuery->where('category_id', $subSubCategory->id);
    } elseif ($subCategory) {
        $articlesQuery->whereIn('category_id', $this->getAllChildCategoryIds($subCategory));
    } elseif ($category) {
        $articlesQuery->whereIn('category_id', $this->getAllChildCategoryIds($category));
    }

if ($search = request()->search) {
        $articlesQuery->where(function ($query) use ($search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
        });
    }

       
switch (request()->sort) {
        case 'price_asc':
            $articlesQuery->orderBy('base_price');
            break;
        case 'price_desc':
            $articlesQuery->orderByDesc('base_price');
            break;
        case 'popular':
            $articlesQuery->withCount('favorites')->orderByDesc('favorites_count');
            break;
        case 'newest':
        default:
            $articlesQuery->orderByDesc('created_at');
            break;
    }


        $articles = $articlesQuery->paginate(12);
        $cartData = $cartController->getCartData();



$pageTitle = "Tous nos produits";

if ($category) {
        $pageTitle = "Produits - " . $category->name;
        if ($subSubCategory) {
            $pageTitle = $subSubCategory->name . " - " . $category->name;
        }elseif($subCategory){
             $pageTitle = $subCategory->name . " - " . $category->name;
        }
} elseif ($subCategory) {
        $pageTitle = "Produits - " . $subCategory->parent->name . " > " . $subSubCategory->name;

} elseif (request()->has('search')) {

    $pageTitle = 'Résultats pour "' . request()->search . '"';
}




        return view('client.products.index', compact('categories', 'articles','cartData','pageTitle', 'category',
        'subCategory'));
    }

    public function show($id)
    {
      
        $isInCart = $this->user ? $this->user->panierItems()->where('article_id', $id)->exists() : false;
        $isFavorite = $this->user ? $this->user->favorites->contains($id) : false;
        
        return view('client.product');
    }


}