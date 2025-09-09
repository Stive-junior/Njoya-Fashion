<?php

namespace App\Http\Controllers\Manager;

use App\Exceptions\ArticleInUseException;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categories;
use App\Models\Images;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article_Variant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB,Log};
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class ManagerProductController extends Controller
{

    public function index()
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

  
    if ($category) {
        $pageTitle = "Produits - " . $category->name;
        if ($subCategory) {
            $pageTitle = $subCategory->name . " - " . $category->name;
        }
    } elseif ($subCategory) {
        $pageTitle = "Produits - " . $subCategory->parent->name . " > " . $subCategory->name;
    } elseif (request()->has('search')) {
        $pageTitle = 'Recherche: "' . request()->search . '"';
    } else {
        $pageTitle = "Gestion des produits";
    }

    return view('manager.products.index', compact(
        'categories',
        'articles',
        'pageTitle',
        'category',
        'subCategory'
    ));
}










public function store(StoreArticleRequest $request)
{
    DB::beginTransaction();

    try {
   
        $article = Article::create([
            'name' => $request->name,
            'description' => $request->description,
            'base_price' => $request->base_price,
            'category_id' => $request->category_id
        ]);

        $this->storeImages($request, $article);

     
        $this->storeVariants($request, $article);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Article créé avec succès',
            'redirect' => route('manager.products.index')
        ], 200); 

    } catch (\Exception $e) {
        DB::rollBack();
        
     
        if (isset($article)) {
            Storage::disk('public')->deleteDirectory('articles/'.$article->id);
        }

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la création: '.$e->getMessage()
        ], 500);
    }
}

    /**
     * Stocke les images de l'article
     */
    protected function storeImages($request, $article)
    {
        if (!$request->hasFile('images')) {
            return;
        }

        foreach ($request->file('images') as $image) {
            $filename = $this->generateImageFilename($article, $image);
            $path = $image->storeAs(
                'articles/'.$article->id,
                $filename,
                'public'
            );

            Images::create([
                'url' => $path,
                'article_id' => $article->id
            ]);
        }
    }

    /**
     * Génère un nom de fichier unique pour l'image
     */
    protected function generateImageFilename($article, $image)
    {
        $extension = $image->getClientOriginalExtension();
        $slug = Str::slug($article->name);
        $random = Str::random(6);

        return "{$slug}-{$random}.{$extension}";
    }

    /**
     * Stocke les variantes de l'article
     */
    protected function storeVariants($request, $article)
    {
        foreach ($request->variants as $variantData) {
            Article_Variant::create([
                'article_id' => $article->id,
                'sizes' => $variantData['sizes'],
                'colors' => $variantData['colors'],
                'materials' => $variantData['materials'] ?? null,
                'sku' => $this->generateSku($article, $variantData)
            ]);
        }
    }

    /**
     * Génère un SKU unique pour la variante
     */
    protected function generateSku($article, $variantData)
    {
        $sizeCode = substr(implode('-', $variantData['sizes']), 0, 3);
        $colorCode = substr(str_replace('#', '', $variantData['colors'][0]), 0, 3);
        $random = substr(md5(microtime()), 0, 4);

        return Str::upper(
            Str::substr($article->name, 0, 3).
            '-'.
            $sizeCode.
            $colorCode.
            '-'.
            $random
        );
    }





protected function getAllChildCategoryIds($category)
{
    $ids = [$category->id];
    
    foreach ($category->children as $child) {
        $ids = array_merge($ids, $this->getAllChildCategoryIds($child));
    }
    
    return $ids;
}



public function create()
    {
        $mainCategories = Categories::with(['children.children'])
            ->whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('order')
            ->get();

        return view('manager.products.create', compact('mainCategories'));
    }



public function edit($articleId)
    {
        $mainCategories = Categories::with(['children.children'])
            ->whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('order')
            ->get();

        $article = Article::with(['variants', 'images', 'category.parent.parent'])
            ->findOrFail($articleId);
    
        return view('manager.products.edit', compact('article', 'mainCategories'));
    }


    public function update(UpdateArticleRequest $request, Article $article)
{

    
    DB::beginTransaction();

    try {
       
        $article->update([
            'name' => $request->name,
            'description' => $request->description,
            'base_price' => $request->base_price,
            'category_id' => $request->category_id,
        ]);

        
        $this->handleImages($request, $article);

      
        $this->handleVariants($request, $article);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Article mis à jour avec succès',
            'redirect' => route('manager.products.index')
        ], 200);

    } catch (\Exception $e) {
        DB::rollBack();
        
         Log::error('Erreur mise à jour article: '.$e->getMessage(), [
            'article_id' => $article->id,
            'exception' => $e
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour: '.$e->getMessage()
        ], 500);
    }
}

 protected function handleVariants($request, $article)
    {
       
        $article->variants()->delete();
        $this->storeVariants($request, $article);
    }



    protected function handleImages($request, $article)
    {
    
    if ($request->filled('deleted_images')) {
        $imagesToDelete = $article->images()
            ->whereIn('id', $request->deleted_images)
            ->get();

        foreach ($imagesToDelete as $image) {
            Storage::disk('public')->delete($image->url);
            $image->delete();
        }
    }

      if ($request->hasFile('images')) {
            $this->storeImages($request, $article);
        }
        
    }


    public function destroy(Request $request, $articleId)
{
        $article = Article::with(['panierItems.panier.user'])
                ->findOrFail($articleId);

    DB::beginTransaction();

    try {

        if (!$request->boolean('force_delete') && $article->isInActiveCarts()) {
            $usersWithArticle = $article->usersWithArticleInCart();
            
              if ($usersWithArticle->isNotEmpty()) {
            DB::commit();
            return $this->buildArticleInUseResponse($usersWithArticle);
        }
    }
      
        $this->deleteArticleCompletely($article, $request->boolean('force_delete'));
        
        DB::commit();

        return $this->buildSuccessResponse(
            message: 'Article supprimé avec succès',
            redirect: route('manager.products.index')
        );

    } catch (\Throwable $e) {
        DB::rollBack();
        $this->logDeletionError($e, $article);
        return $this->buildErrorResponse($e);
    }
}

private function deleteArticleCompletely(Article $article, bool $forceDelete): void
{
 
    $this->deleteDependentRecords($article, [
        'reviews',
        'favorites',
        'orderItems',
        'images',
        'variants'
    ]);

  
    if ($forceDelete) {
        $article->panierItems()->chunkById(200, function ($items) {
            $items->each->delete();
        });
    }

    $article->delete();
}

private function deleteDependentRecords(Article $article, array $relations): void
{
    foreach ($relations as $relation) {
        try {
            if ($relation === 'images') {
                $this->deleteArticleImages($article);
            } else {
                $article->$relation()->delete();
            }
        } catch (\Exception $e) {
            Log::error("Échec suppression $relation", [
                'article_id' => $article->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}

private function deleteArticleImages(Article $article): void
{
    $directory = 'articles/'.$article->id;
    $storage = Storage::disk('public');


    $article->images->each(function($image) use ($storage) {
        try {
            if ($storage->exists($image->url)) {
                $storage->delete($image->url);
            }
            $image->delete();
        } catch (\Exception $e) {
            Log::error("Échec suppression image", [
                'image_id' => $image->id,
                'error' => $e->getMessage()
            ]);
        }
    });

  
    try {
        if ($storage->exists($directory) && empty($storage->allFiles($directory))) {
            $storage->deleteDirectory($directory);
        }
    } catch (\Exception $e) {
        Log::error("Échec suppression dossier", [
            'directory' => $directory,
            'error' => $e->getMessage()
        ]);
    }
}




private function buildSuccessResponse(string $message, string $redirect): JsonResponse
{
    return response()->json([
        'success' => true,
        'message' => $message,
        'redirect' => $redirect,
        'timestamp' => now()->toDateTimeString()
    ]);
}


private function buildArticleInUseResponse(Collection $users): JsonResponse
{
    $stats = [
        'total' => $users->count(),
        'online' => $users->where('is_online', true)->count(),
        'offline' => $users->where('is_online', false)->count()
    ];

    return response()->json([
        'success' => false,
        'in_cart' => true,
        'users' => $users,
        'stats' => $stats,
        'sample_users' => $users->take(5)->values(),
        'message' => sprintf(
            'Article présent dans %d paniers (%d en ligne) - Suppression forcée nécessaire',
            $stats['total'],
            $stats['online']
        ),
        'actions' => [
            'force_delete_url' => request()->fullUrlWithQuery(['force_delete' => 'true'])
        ]
    ], 423);
}
  
private function logDeletionError(\Throwable $e, Article $article): void
{
    Log::channel('deletions')->error("Article deletion failed", [
        'article_id' => $article->id,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString(),
        'request_data' => request()->all(),
        'user_id' => auth()->id()
    ]);
}

private function buildErrorResponse(\Throwable $e)
{
    return response()->json([
        'success' => false,
        'message' => config('app.debug') 
            ? $e->getMessage() 
            : 'Une erreur est survenue lors de la suppression',
        'error_id' => uniqid()
    ], 500);
}



    public function getSubcategories($parentId)
    {
        $categories = Categories::where('parent_id', $parentId)
            ->where('status', 1)
            ->orderBy('order')
            ->get();
            
        return response()->json($categories);
    }
}