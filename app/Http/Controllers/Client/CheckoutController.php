<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\User;
use App\Models\Order;
use App\Models\Order_items;
use App\Models\Panier;
use App\Models\Panier_items;
use App\Models\Payement_methods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{

     /** @var \App\Models\User $user */
    public $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }


public function index(CartController $cartController)
{
    /** @var \App\Models\User|null $user */
    $user = Auth::user();

    // Si l'utilisateur n'est pas connecté
    if (!$user) {
        return redirect()->route('cart')->with('error', 'Veuillez vous connecter pour procéder au paiement.');
    }

    // Chargement des catégories
    $categories = Categories::with(['children' => function($query) {
        $query->where('status', 1)->orderBy('order');
    }])
    ->whereNull('parent_id')
    ->where('status', 1)
    ->orderBy('order')
    ->get();


    $cart = $cartController->getCart();
    $cartData = $cartController->getCartData();


    if (!$cart || !$cart->items || collect($cart->items)->isEmpty()) {
        return redirect()->route('cart')->with('error', 'Votre panier est vide pour procéder au paiement');
    }

    
    if (session()->has('cart')) {
        return redirect()->route('home')->with('error', 'Vous devez d\'abord synchroniser votre panier avant de passer à la caisse');
    }

    
    $paymentMethods = Payement_methods::where('is_active', true)->get();
    $cartTotal = $cartData['total'];

    return view('client.checkout', compact('cart', 'paymentMethods', 'cartTotal', 'categories'));
}


    public function store(Request $request)
    {
       
        $request->validate([
            'name' => 'required_if:create_account,1|string|max:255',
            'email' => 'required_if:create_account,1|email|unique:users,email',
            'password' => 'required_if:create_account,1|confirmed|min:8',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string|in:carte,paypal,virement',
        ]);

        DB::beginTransaction();

        try {
           
            if ($request->has('create_account') && $request->create_account == 1) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'client',
                ]);

                
                Auth::login($user);
            }



          
            $cart = $this->user->panier()->with('panier_items.article')->first();

            if (!$cart || $cart->panier_items->isEmpty()) {
                DB::rollBack();
                return redirect()->route('client.cart.index')->with('error', 'Votre panier est vide');
            }

        
            $totalAmount = $cart->panier_items->sum(function ($item) {
                return $item->quantity * $item->article->price;
            });

          
            $order = Order::create([
                'user_id' => $user->id,
                'address' => $request->address,
                'payment_method' => $request->payment_method,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            
            foreach ($cart->panier_items as $item) {
                Order_items::create([
                    'order_id' => $order->id,
                    'article_id' => $item->article_id,
                    'quantity' => $item->quantity,
                    'price' => $item->article->price,
                ]);
            }

         
            $cart->panier_items()->delete();

            DB::commit();

         
            return redirect()->route('client.orders.show', $order)->with('success', 'Commande passée avec succès !');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la commande : ' . $e->getMessage());
        }
    }


    public function syncCart(Request $request)
{
    $request->validate(['option' => 'required|in:merge,replace']);

    DB::transaction(function () use ($request) {
        $userCart = $this->user->panier()->firstOrCreate([]);
        $sessionCart = $this->getSessionCart();

        if ($request->option === 'replace') {
            $userCart->items()->delete();
        }

        foreach ($sessionCart->items as $item) {
            $existingItem = $userCart->items()
                ->where('article_id', $item['article_id'])
                ->first();

            if ($existingItem) {
                $existingItem->quantity += $item['quantity'];
                $existingItem->save();
            } else {
                $userCart->items()->create([
                    'article_id' => $item['article_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }
        }

        Session::forget('cart');
    });

    return response()->json(['success' => true]);
}

}