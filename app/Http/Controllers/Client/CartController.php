<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\{Article, Categories, Panier, Panier_items};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, DB, Log, Session};
use Illuminate\Support\Str;

class CartController extends Controller
{

     /** @var \App\Models\User $user */
    public $user;

       public function __construct()
    {
        $this->middleware('auth')->only(['syncCart']);
        $this->user = Auth::user();
    }

    public function clearSession()
    {
        Session::forget('cart');
        return response()->json(['success' => true]);
    }

    public function index()
    {
        $cart = $this->getCart();
        return view('client.cart', [
            'cartData' => $this->getCartData(),
            'cart' => $cart,
            'categories' => $this->getCategories(),
            'recommendedArticles' => $this->getRecommendedArticles($cart),
            'cartCount' => $this->getCartCount($cart)
        ]);
    }


    /**
     * Add an article to the cart.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $articleId
     * @return \Illuminate\Http\JsonResponse
     */public function add(Request $request, $articleId)
    {
        $validated = $this->validateCartItem($request);
        $article = Article::findOrFail($articleId);

        DB::transaction(function () use ($article, $validated) {
            $cart = $this->getCart();
            
            $variants = [
                'sizes' => $validated['variants']['sizes'] ? json_decode($validated['variants']['sizes'], true) : null,
                'colors' => $validated['variants']['colors'] ? json_decode($validated['variants']['colors'], true) : [],
                'materials' => $validated['variants']['materials'] ? json_decode($validated['variants']['materials'], true) : null
            ];

            $variantQuantities = [
                'sizes' => $validated['variant_quantities']['sizes'] ? json_decode($validated['variant_quantities']['sizes'], true) : [],
                'colors' => $validated['variant_quantities']['colors'] ? json_decode($validated['variant_quantities']['colors'], true) : [],
                'materials' => $validated['variant_quantities']['materials'] ? json_decode($validated['variant_quantities']['materials'], true) : []
            ];

            if (Auth::check()) {
                $this->addToUserCart($cart, $article, $validated['quantity'], $variants, $variantQuantities, $validated['custom_message'] ?? null);
            } else {
                $this->addToSessionCart($cart, $article, $validated['quantity'], $variants, $variantQuantities, $validated['custom_message'] ?? null);
            }
        });

        return $this->cartResponse('Article ajouté au panier');
    }



public function updateQuantity(Request $request, $itemId)
{
    $validated = $request->validate([
        'quantity' => 'required|integer|min:1|max:99',
        'variant_quantities' => 'nullable|array'
    ]);

    try {
        $cartUpdated = DB::transaction(function () use ($itemId, $validated) {
            $cart = $this->getCart();
            $hasChanged = false;
            
            if (Auth::check()) {
                $item = $cart->items()->findOrFail($itemId);
                
            
                if ($item->quantity != $validated['quantity'] || 
                    json_encode($item->variant_quantities ?? []) !== json_encode($validated['variant_quantities'] ?? [])) {
                    
                    $item->update([
                        'quantity' => $validated['quantity'],
                        'variant_quantities' => $validated['variant_quantities'] ?? $item->variant_quantities
                    ]);
                    $hasChanged = true;
                }
            } else {
                $items = collect($cart->items)->map(function ($item) use ($itemId, $validated, &$hasChanged) {
                    if (($item['id'] ?? null) == $itemId) {

                        if ($item['quantity'] != $validated['quantity'] || 
                            json_encode($item['variant_quantities'] ?? []) !== json_encode($validated['variant_quantities'] ?? [])) {
                            
                            $hasChanged = true;
                            return [
                                ...$item,
                                'quantity' => $validated['quantity'],
                                'variant_quantities' => $validated['variant_quantities'] ?? $item['variant_quantities'] ?? null
                            ];
                        }
                    }
                    return $item;
                });

                if ($hasChanged) {
                    $cart->items = $items->toArray();
                    Session::put('cart', (array) $cart);
                }
            }
            
            return $hasChanged;
        });

        return $this->cartResponse(
            $cartUpdated 
                ? 'Quantité mise à jour avec succès' 
                : 'Aucune modification nécessaire'
        );
    } catch (\Exception $e) {
        return $this->errorResponse('Échec de la mise à jour de la quantité', 400);
    }
}




public function update(Request $request, $itemId)
{
    try {
        DB::transaction(function () use ($request, $itemId) {
          
            $cart = $this->getCart();
         
          
            if ((int)$request->quantity === 0) {
                return $this->remove($itemId);
            }
            
   
                
                $validated = $this->validateCartItem($request);
                
                $variants = [
                    'sizes' => $validated['variants']['sizes'] ? json_decode($validated['variants']['sizes'], true) : null,
                    'colors' => $validated['variants']['colors'] ? json_decode($validated['variants']['colors'], true) : [],
                    'materials' => $validated['variants']['materials'] ? json_decode($validated['variants']['materials'], true) : null
                ];

                $variantQuantities = [
                    'sizes' => $validated['variant_quantities']['sizes'] ? json_decode($validated['variant_quantities']['sizes'], true) : [],
                    'colors' => $validated['variant_quantities']['colors'] ? json_decode($validated['variant_quantities']['colors'], true) : [],
                    'materials' => $validated['variant_quantities']['materials'] ? json_decode($validated['variant_quantities']['materials'], true) : []
                ];

                if (Auth::check()) {
                    $this->updateUserCartItem(
                        $cart, 
                        $itemId, 
                        $validated['quantity'],
                        $variants,
                        $variantQuantities,
                        $validated['custom_message'] ?? null
                    );
                } else {
                    $this->updateSessionCartItem(
                        $cart,
                        $itemId,
                        $validated['quantity'],
                        $variants,
                        $variantQuantities,
                        $validated['custom_message'] ?? null
                    );
                }
         
        });

        DB::rollBack();

        return $this->cartResponse('Quantité mise à jour avec succès');
    } catch (\Exception $e) {
        return $this->errorResponse($e->getMessage());
    }
}

public function updateItemDetails(Request $request, $itemId)
{
    $validated = $request->validate([

        'custom_message' => 'nullable|string|max:5000',
        
    ]);

    try {
        DB::transaction(function () use ($itemId, $validated) {
            $cart = $this->getCart();
            

          

            if (Auth::check()) {
                $item = $cart->items()->findOrFail($itemId);
                $item->update([
                    'custom_message' => $validated['custom_message'] ?? $item->custom_message,
                ]);
            } else {
                $items = collect($cart->items)->map(function ($item) use ($itemId, $validated) {
                    if (($item['id'] ?? null) == $itemId) {
                        return [
                            ...$item,
                            'custom_message' => $validated['custom_message'] ?? $item['custom_message'] ?? null
                        ];
                    }
                    return $item;
                });

                $cart->items = $items->toArray();
                Session::put('cart', (array) $cart);
            }
        });

        return $this->cartResponse('Détails de l\'article mis à jour avec succès');
    } catch (\Exception $e) {
        return $this->errorResponse('Échec de la mise à jour des détails: ' . $e->getMessage());
    }
}

    public function remove($itemId)
    {
        try {
            DB::transaction(function () use ($itemId) {
                $cart = $this->getCart();
                
                if (Auth::check()) {
                    $cart->items()->where('id', $itemId)->delete();
                } else {
                    $this->removeFromSessionCart($cart, $itemId);
                }
            });

            return $this->cartResponse("Article retiré du panier");
        } catch (\Exception $e) {
            return $this->errorResponse('Échec de la suppression');
        }
    }

    public function syncCart()
    {
        if (!auth()->check()) {
            return $this->errorResponse('Utilisateur non authentifié', 401, route('login'));
        }

        try {
            DB::transaction(function () {
                /** @var \App\Models\User $user */
                $user = auth()->user();
                $sessionCart = session('cart', ['items' => []]);
                $userCart = $user->panier()->firstOrCreate([]);

                if (request()->boolean('replace_existing')) {
                    $userCart->items()->delete();
                }

                foreach ($sessionCart['items'] as $item) {
                    $this->syncCartItem($userCart, $item);
                }

                Session::forget('cart');
            });

            return response()->json([
                'success' => true,
                'message' => 'Panier synchronisé avec succès',
                'redirect' => request()->boolean('proceed_to_checkout') 
                    ? route('checkout') 
                    : route('cart')
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 500, null, $e->getMessage());
        }
    }

 private function validateCartItem(Request $request)
    {
        return $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
            'variants' => 'nullable|array',
            'variants.sizes' => 'nullable|json',
            'variants.colors' => 'nullable|json',
            'variants.materials' => 'nullable|json',
            'variant_quantities' => 'nullable|array',
            'variant_quantities.sizes' => 'nullable|json',
            'variant_quantities.colors' => 'nullable|json',
            'variant_quantities.materials' => 'nullable|json',
            'custom_message' => 'nullable|string|max:5000',
            'update' => 'nullable|boolean'
        ]);
    }

 private function addToUserCart($cart, $article, $quantity, $variants, $variantQuantities, $customMessage)
    {
     
        foreach ($variants as $key => $value) {
            if (empty($value)) {
                unset($variants[$key]);
            }
        }

        foreach ($variantQuantities as $key => $value) {
            if (empty($value)) {
                unset($variantQuantities[$key]);
            }
        }

        $existingItem = $cart->items()
            ->where('article_id', $article->id)
            ->whereJsonContains('variants', $variants)
            ->first();

        if ($existingItem) {
           
            $mergedQuantities = array_merge_recursive($existingItem->variant_quantities ?? [], $variantQuantities);
            
            $existingItem->update([
                'quantity' => $existingItem->quantity + $quantity,
                'variant_quantities' => $mergedQuantities,
                'custom_message' => $customMessage ?? $existingItem->custom_message
            ]);
        } else {
            $cart->items()->create([
                'article_id' => $article->id,
                'quantity' => $quantity,
                'price' => $article->base_price,
                'variants' => $variants, // Format: {"Sizes":["38","39"],"Materials":["Cuir"]}
                'variant_quantities' => $variantQuantities,
                'custom_message' => $customMessage
            ]);
        }

        $cart->touch();
    }

    private function addToSessionCart($cart, $article, $quantity, $variants, $variantQuantities, $customMessage)
    {
      
        foreach ($variants as $key => $value) {
            if (empty($value)) {
                unset($variants[$key]);
            }
        }

        foreach ($variantQuantities as $key => $value) {
            if (empty($value)) {
                unset($variantQuantities[$key]);
            }
        }

        $items = collect($cart->items);
        $existingIndex = $items->search(function ($item) use ($article, $variants) {
            return $item['article_id'] == $article->id && 
                   json_encode($item['variants'] ?? []) === json_encode($variants);
        });

        if ($existingIndex !== false) {
            $existing = $items[$existingIndex];
            $mergedQuantities = array_merge_recursive($existing['variant_quantities'] ?? [], $variantQuantities);
            
            $items[$existingIndex] = [
                ...$existing,
                'quantity' => $existing['quantity'] + $quantity,
                'variant_quantities' => $mergedQuantities,
                'custom_message' => $customMessage ?? $existing['custom_message']
            ];
        } else {
            $items->push([
                'id' => uniqid('item_', true),
                'article_id' => $article->id,
                'quantity' => $quantity,
                'price' => $article->base_price,
                'variants' => $variants, 
                'custom_message' => $customMessage ?? null,
                'variant_quantities' => $variantQuantities
            ]);
        }
        
        $cart->items = $items->toArray();
        Session::put('cart', (array) $cart);
    }





    private function removeFromSessionCart($cart, $itemId)
    {
        
            $items = collect($cart->items);
            $filteredItems = $items->reject(function ($item) use ($itemId) {
                return isset($item['id']) && (string)$item['id'] === (string)$itemId;
            })->values()->toArray();

            $cart->items = $filteredItems;
            Session::put('cart', (array)$cart);

   }



     private function updateUserCartItem($cart, $itemId, $quantity, $variants, $variantQuantities, $customMessage)
    {
        $item = $cart->items()->findOrFail($itemId);
        
        $item->update([
            'quantity' => $quantity,
            'variants' => $variants,
            'custom_message' => $customMessage ?? $item->custom_message,
            'variant_quantities' => $variantQuantities
        ]);

        $cart->touch();
    }

    private function updateSessionCartItem($cart, $itemId, $quantity, $variants, $variantQuantities, $customMessage)
    {
        $items = collect($cart->items)->map(function ($item) use ($itemId, $quantity, $variants, $variantQuantities, $customMessage) {
            if (($item['id'] ?? null) === $itemId) {
                return [
                    ...$item,
                    'quantity' => $quantity,
                    'variants' => $variants,
                    'custom_message' => $customMessage ?? $item['custom_message'] ?? null,
                    'variant_quantities' => $variantQuantities
                ];
            }
            return $item;
        });

        $cart->items = $items->toArray();
        Session::put('cart', (array) $cart);
    }


private function syncCartItem($userCart, $item)
{

$variants = array_merge([
    'sizes' => null,
    'colors' => [],
    'materials' => null
], $item['variants'] ?? []);

$variantQuantities = array_merge([
    'sizes' => [],
    'colors' => [],
    'materials' => []
], $item['variant_quantities'] ?? []);


    $existing = $userCart->items()
        ->where('article_id', $item['article_id'])
        ->first();

    if ($existing) {

       $mergedVariants = [
    'sizes' => $variants['sizes'] 
        ?? $existing->variants['sizes'] 
        ?? null,

    'colors' => !empty($existing->variants['colors']) || !empty($variants['colors'])
        ? array_values(array_unique(array_merge(
            $existing->variants['colors'] ?? [],
            $variants['colors'] ?? []
        )))
        : null,

    'materials' => $variants['materials'] 
        ?? $existing->variants['materials'] 
        ?? null,
];

  
        $mergedQuantities = [
            'sizes' => $this->mergeQuantities($existing->variant_quantities['sizes'] ?? [], $variantQuantities['sizes']),
            'colors' => $this->mergeQuantities($existing->variant_quantities['colors'] ?? [], $variantQuantities['colors']),
            'materials' => $this->mergeQuantities($existing->variant_quantities['materials'] ?? [], $variantQuantities['materials'])
        ];

   
        $existing->update([
            'quantity' => $existing->quantity + $item['quantity'],
            'variants' => $mergedVariants,
            'variant_quantities' => $mergedQuantities,
            'custom_message' => $item['custom_message'] ?? $existing->custom_message
        ]);
    } else {
     
        $userCart->items()->create([
            'article_id' => $item['article_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'variants' => $variants,
            'variant_quantities' => $variantQuantities,
            'custom_message' => $item['custom_message'] ?? null
        ]);
    }
}

private function mergeQuantities($existingQuantities, $newQuantities)
{
    $result = $existingQuantities;
    
    foreach ($newQuantities as $key => $value) {
        $result[$key] = ($result[$key] ?? 0) + $value;
    }
    
    return $result;
}



    public function getCart()
    {
        return Auth::check() ? $this->getUserCart() : $this->getSessionCart();
    }

     private function getUserCart()
    {
        $this->user = Auth::user();

        return $this->user->panier()->firstOrCreate([], [
            'session_id' => Session::getId(),
            'expires_at' => now()->addDays(3)
        ]);
    }



    private function getSessionCart()
    {

        $cart = Session::get('cart', $this->newSessionCart());
        
        if (!isset($cart['expires_at']) || now()->gt($cart['expires_at'])) {
            $cart = $this->newSessionCart();
            Session::put('cart', $cart);
        }

        return (object) $cart;
    }

    private function newSessionCart()
    {
        return [
            'id' => Str::uuid(),
            'session_id' => Session::getId(),
            'expires_at' => now()->addDays(3)->toDateTimeString(),
            'items' => []
        ];
    }

    private function cartResponse($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'cart' => $this->getCartData()
        ]);
    }

    private function errorResponse($message, $status = 500, $redirect = null, $error = null)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'redirect' => $redirect,
            'error' => $error
        ], $status);
    }

    public function getCartData()
    {
        $cart = $this->getCart();
        $cartCount = $this->getCartCount($cart);
        $cartTotal = $this->getCartTotal($cart);

        $items = Auth::check() 
            ? $this->formatUserCartItems($cart)
            : $this->formatSessionCartItems($cart);

        return [
            'success' => true,
            'count' => $cartCount,
            'total' => $cartTotal,
            'items' => $items
        ];
    }

    private function formatUserCartItems($cart)
    {
        return $cart->items->map(function($item) {
            return [
                'id' => $item->id,
                'article_id' => $item->article_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'variants' => $item->variants,
                'custom_message' => $item->custom_message,
                'variant_quantities' => $item->variant_quantities,
                'article' => [
                    'name' => $item->article->name,
                    'images' => $item->article->images->pluck('url')
                ]
            ];
        })->toArray();
    }

    private function formatSessionCartItems($cart)
    {
        return collect($cart->items)->map(function($item) {
            $article = Article::find($item['article_id']);
            return [
                'id' => $item['id'],
                'article_id' => $item['article_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'variants' => $item['variants'] ?? null,
                'custom_message' => $item['custom_message'] ?? null,
                'variant_quantities' => $item['variant_quantities'] ?? null,
                'article' => [
                    'name' => $article->name,
                    'images' => $article->images->pluck('url')
                ]
            ];
        })->toArray();
    }

    private function getCartCount($cart)
    {
        return Auth::check() 
            ? $cart->items->count() 
            : count($cart->items);
    }

   
public function getCartTotal($cart)
{
    if (Auth::check() && $cart && !session('cart')) {
        $cart->load('items.article');
        return $cart->items->sum(fn($item) => $item->quantity * $item->article->base_price);
    } else {
      
        $items = is_object($cart) && isset($cart->items) ? $cart->items : ($cart['items'] ?? []);

        return collect($items)->sum(function ($item) {
            $price = is_array($item) ? $item['price'] : $item->price;
            $quantity = is_array($item) ? $item['quantity'] : $item->quantity;
            return $quantity * $price;
        });
    }
}

    private function getCategories()
    {
        return Categories::with(['children' => fn($q) => $q->where('status', 1)->orderBy('order')])
            ->whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('order')
            ->get();
    }

    private function getRecommendedArticles($cart)
    {
        $articleIds = Auth::check()
            ? $cart->items->pluck('article_id')
            : collect($cart->items)->pluck('article_id');

        return Article::with(['category', 'images'])
            ->whereHas('category', fn($q) => $q->whereIn('id', $articleIds))
            ->whereNotIn('id', $articleIds)
            ->inRandomOrder()
            ->limit(10)
            ->get();
    }
}