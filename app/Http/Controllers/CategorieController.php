<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Http\Controllers\Client\CartController;

class CategorieController extends Controller
{

/** @var \App\Models\Panier|null $cart */
public $cart;

public function showSubcategorie($id,CartController $cartController)
{
    $categories = Categories::with(['children' => function($query) {
            $query->where('status', 1)->orderBy('order');
        }])
        ->whereNull('parent_id')
        ->where('status', 1)
        ->orderBy('order')
        ->get();


    $category = Categories::findOrFail($id);
    $subcategories = $category->children;



    $articlesQuery = Article::whereIn('category_id', $subcategories->pluck('id'));


    if (request()->has('subcategory') && request()->subcategory) {
        $articlesQuery->where('category_id', request()->subcategory);
    }


    $articles = $articlesQuery->orderBy('created_at', 'desc')->paginate(12);
    

    $cart = $cartController->getCart();
    $cartData = $cartController->getCartData();

    return view('client.categories.subcategories', compact('categories','category', 'subcategories', 'articles','cart','cartData'));
}


}
