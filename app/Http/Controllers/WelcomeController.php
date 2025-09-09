<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Client\CartController;
use App\Models\Article;
use App\Models\Categories;
use App\Models\Favorites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WelcomeController extends Controller
{

    public function index(CartController $cartDat){

         $categories = Categories::with(['children' => function($query) {
            $query->where('status', 1)->orderBy('order');
        }])
        ->whereNull('parent_id')
        ->where('status', 1)
        ->orderBy('order')
        ->get();



   
    $featuredProduct = Article::with(['images', 'favorites'])
        ->orderByDesc('created_at')
        ->first();


    $newProducts = Article::with(['images', 'category'])
        ->orderByDesc('created_at')
        ->take(8)
        ->get();


  
    $recommendedProducts = collect();
    if (auth()->check()) {
        $userGender = auth()->user()->sexe;
        if ($userGender) {
            $recommendedProducts = Article::whereHas('category', function($query) use ($userGender) {
                $query->where('name', 'like', $userGender === 'M' ? '%Homme%' : '%Femme%');
            })
            ->inRandomOrder()
            ->take(4)
            ->get();
        }
    }

    

    $galleryProducts = Article::with(['images'])
        ->inRandomOrder()
        ->take(12)
        ->get();

        $cartData = $cartDat->getCartData();
        $cart = $cartDat->getCart();


    
    $showSyncPrompt = false;
    $sessionCart = session('cart');
    $user = auth()->user();
    $isNewUser = false;
    
    if (Auth::user() && $sessionCart && !empty($sessionCart['items'])) {
        $userCreationDate = $user->created_at;
        $isNewUser = $userCreationDate->diffInHours(now()) < 24; // Utilisateur créé il y a moins de 24h
        
        $showSyncPrompt = true;
    }

    if($showSyncPrompt){
    $sessionTotal = $cartDat->getCartTotal($sessionCart);
    }else{
        $sessionTotal = 0;
    }
    $articles  = Article::all();

    return view('home', compact(
        'featuredProduct',
        'newProducts',
        'recommendedProducts',
        'galleryProducts',
        'categories',
        'cartData',
        'showSyncPrompt',
        'sessionCart',
        'isNewUser',
        'articles',
        'sessionTotal'
    ));
}

   
}