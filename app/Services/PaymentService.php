<?php
namespace App\Services;

use App\Models\Order;
use App\Models\Payement_methods;
use App\Models\PaymentMethod;

class PaymentService
{
    public function initiatePayment(Order $order, $phone, $methodId)
    {
        $method = Payement_methods::find($methodId);
        
      
        
        try {
            $reference = 'PAY-' . strtoupper(uniqid());
            
            // Envoyer la demande de paiement à l'API
            // $apiResponse = MobileMoneyApi::requestPayment(...);
            
            return [
                'success' => true,
                'reference' => $reference,
                'message' => 'Une demande de paiement a été envoyée à votre numéro'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Échec de l\'initiation du paiement'
            ];
        }
    }

    public function verifyPayment($reference)
    {
        // Vérification avec l'API de paiement
        // Ceci est une simulation
        
        sleep(2); // Simule le temps de vérification
        
        // 70% de chance de succès pour la démo
        if (rand(0, 100) > 30) {
            return [
                'success' => true,
                'message' => 'Paiement vérifié avec succès'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Paiement non reçu ou échoué'
        ];
    }
}