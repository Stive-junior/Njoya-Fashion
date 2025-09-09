<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order_items;
use App\Models\Returns;
use App\Http\Requests\ProcessReturnRequest;
use Illuminate\Support\Facades\DB;

class ManagerReturnController extends Controller
{
   public function store(Request $request, Order_items $orderItem)
    {
        DB::beginTransaction();

        try {

            $return = Returns::create([
                'order_item_id' => $orderItem->id,
                'reason' => $request->reason,
                'status' => 'pending'
            ]);

            // Notification admin
            // Event(new ReturnRequested($return));

            DB::commit();
            return back()->with('success', 'Demande de retour enregistrée');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la demande');
        }
    }

    public function update(ProcessReturnRequest $request, Returns $return)
    {
        DB::beginTransaction();

        try {
            $return->update([
                'status' => $request->status,
                'refund_amount' => $request->status === 'approved' ? 
                    $return->orderItem->unit_price * $return->orderItem->quantity : 0
            ]);

            if ($request->status === 'approved') {
                // Process refund
                // Event(new RefundProcessed($return));
            }

            DB::commit();
            return back()->with('success', 'Statut du retour mis à jour');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur de traitement');
        }
    }

}
