<?php

namespace App\Http\Controllers\Client;

use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\Panier;
use App\Services\PaymentService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{

    public function processPayment(Request $request)
{
    

    $validated = $request->validate([
            'payment_method' => 'required|exists:payment_methods,id',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^6[0-9]{8}$/',
            'partial_amount' => 'sometimes|numeric'
        ]);

        Log::info('Données validées:', $validated);


    try {
        $user = Auth::user();
        $cart = Panier::where('user_id', $user->id)->firstOrFail();

 
        $order = Order::create([
            'user_id'            => $user->id,
            'payment_reference' => 'you',
            'total_amount'       => $cart->getTotal(),
            'partial_amount'     => $request->partial_amount,
            'status'             => 'pending',
            'payment_method_id'  => $request->payment_method,
            'shipping_address'   => json_encode([
                'street' => $request->street,
                'city'   => $request->city,
                'phone'  => $request->phone
            ]),
        ]);



        foreach ($cart->items as $item) {
            $order->items()->create([
                'article_id' => $item->article_id,
                'quantity'   => $item->quantity,
                'unit_price' => $item->article->base_price
            ]);
        }

       
        $paymentService = new PaymentService();
        $paymentResponse = $paymentService->initiatePayment(
            $order,
            $request->phone,
            $request->payment_method
        );

        if (!$paymentResponse['success']) {
            return response()->json([
                'success' => false,
                'message' => $paymentResponse['message'] ?? 'Échec du paiement.'
            ], 400);
        }

        return response()->json([
            'success'           => true,
            'payment_reference' => $paymentResponse['reference'],
            'order_id'          => $order->id
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('Erreur de validation', ['errors' => $e->errors()]);
        return response()->json([
            'success' => false,
            'message' => 'Validation error',
            'errors' => $e->errors()
        ], 422);

    } catch (\Exception $e) {
        Log::error('Erreur processPayment', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json([
            'success' => false,
            'message' => 'Server error'
        ], 500);
    }
}



    public function verifyPayment(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'reference' => 'required|string'
        ]);

        $paymentService = new PaymentService();
        $verification = $paymentService->verifyPayment($request->reference);

        if ($verification['success']) {
            Order::find($request->order_id)->markAsPaid($request->reference);
            
        
            $this->sendPaymentConfirmation($request->order_id);
            
            return response()->json(['success' => true]);
        }

        return response()->json([
            'success' => false,
            'message' => $verification['message']
        ], 400);
    }

    protected function sendPaymentConfirmation($orderId)
{
    $order = Order::with(['user', 'paymentMethod', 'items.article'])->findOrFail($orderId);
    
 
    $this->sendConfirmationEmail($order);
    

    $this->sendConfirmationSms($order);
    
  
    Log::info('Confirmation de paiement envoyée', [
        'order_id' => $order->id,
        'user_id' => $order->user->id,
        'email' => $order->user->email,
        'phone' => $order->shipping_address['phone']
    ]);
}

protected function sendConfirmationEmail(Order $order)
{
    try {
        Mail::to($order->user->email)
            ->send(new OrderConfirmation($order));
            
    } catch (\Exception $e) {
        Log::error('Échec envoi email confirmation', [
            'order_id' => $order->id,
            'error' => $e->getMessage()
        ]);
    }
}

protected function sendConfirmationSms(Order $order)
{
    $message = "Merci pour votre commande #{$order->id} de "
             . number_format($order->total_amount, 0, ',', ' ') 
             . " FCFA. Suivi: ".route('orders.show', $order->id);
    
    try {
        SmsService::send(
            $order->shipping_address['phone'],
            $message
        );
        
    } catch (\Exception $e) {
        Log::error('Échec envoi SMS confirmation', [
            'order_id' => $order->id,
            'error' => $e->getMessage()
        ]);
    }
}


}