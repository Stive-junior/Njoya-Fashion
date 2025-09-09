<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Categories;
use App\Models\Favorites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(CartController $cartController)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        

$categories = Categories::with(['children.children' => function($query) {
    $query->where('status', 1)->orderBy('order');
}])
->whereNull('parent_id')
->where('status', 1)
->orderBy('order')
->get();


        $favorites = $user->favorites()
            ->with(['article' => function($query) {
                $query->with(['images', 'category']);
        
            }])
            ->whereHas('article', function($query) {
               
            })
            ->latest()
            ->paginate(12);

            $cartData = $cartController->getCartData();

        return view('client.favorites', [
            'favorites' => $favorites,
            'categories' => $categories,
            'cartData' => $cartData,
            'totalFavorites' => $user->favorites()->count(),
            
        ]);
    }

    public function add(Article $article)
    {
         /** @var \App\Models\User $user */
        $user = Auth::user();
        
        try {
            DB::beginTransaction();

            if (!$user->favorites()->where('article_id', $article->id)->exists()) {
                Favorites::create([
                    'user_id' => $user->id,
                    'article_id' => $article->id
                ]);

                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Article ajouté aux favoris',
                    'action' => 'add',
                    'favorites_count' => $user->favorites()->count()
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Article déjà dans vos favoris'
            ], 400);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue'
            ], 500);
        }
    }


    public function remove(Article $article)
    {

         /** @var \App\Models\User $user */
        $user = Auth::user();
        

        try {
            DB::beginTransaction();

            $deleted = $user->favorites()
                ->where('article_id', $article->id)
                ->delete();

            if ($deleted) {
                DB::commit();
                return response()->json([
                    'success' => true,
                    'message' => 'Article retiré des favoris',
                    'action' => 'remove',
                    'favorites_count' => $user->favorites()->count()
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Article non trouvé dans vos favoris'
            ], 404);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue'
            ], 500);
        }
    }

    public function toggle(Request $request, Article $article)
    {
         /** @var \App\Models\User $user */
        $user = Auth::user();
        

        $isFavorite = $user->favorites()->where('article_id', $article->id)->exists();
        
        if ($isFavorite) {
            return $this->remove($article);
        }
        
        return $this->add($article);
    }
}