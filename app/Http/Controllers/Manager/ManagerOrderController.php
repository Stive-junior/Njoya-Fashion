<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items'])->paginate(10);
        return view('manager.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('manager.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            ]);

            $order->update(['status' => $request->status]);

            DB::commit();
            return redirect()->route('manager.orders.index')->with('success', 'Statut de la commande mis à jour');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la mise à jour');
        }
    }
}
    
