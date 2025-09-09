<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public static function send($phone, $message)
    {
       
        $apiUrl = config('services.sms.api_url');
        $apiKey = config('services.sms.api_key');
        $sender = config('app.name');
        
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$apiKey,
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'to' => $phone,
                'from' => $sender,
                'message' => $message,
            ]);
            
            if (!$response->successful()) {
                Log::error('Échec envoi SMS', [
                    'phone' => $phone,
                    'error' => $response->body()
                ]);
            }
            
            return $response->successful();
            
        } catch (\Exception $e) {
            Log::error('Exception SMS', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}