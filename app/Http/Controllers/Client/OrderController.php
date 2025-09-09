<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /** @var \App\Models\User $user */
    public $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }

    public function index()
    {
        $orders = $this->user->orders()->with('order_items.article')->paginate(10);
        return view('client.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== $this->user->id) {
            abort(403, 'Accès non autorisé');
        }

        return view('client.orders.show', compact('order'));
    }
}