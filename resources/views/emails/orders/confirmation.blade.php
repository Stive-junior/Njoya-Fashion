@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
# Confirmation de commande #{{ $order->id }}

Bonjour {{ $order->user->name }},

Votre commande a été confirmée et est en cours de préparation.

**Détails de la commande:**  
@component('mail::table')
| Produit          | Quantité | Prix     |
|------------------|----------|----------|
@foreach($order->items as $item)
| {{ $item->article->name }} | {{ $item->quantity }} | {{ number_format($item->unit_price, 0, ',', ' ') }} FCFA |
@endforeach
| **Total**        |          | **{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA** |
@endcomponent

**Adresse de livraison:**  
{{ $order->shipping_address['street'] }}  
{{ $order->shipping_address['city'] }}  
{{ $order->shipping_address['postal_code'] ?? '' }}

**Méthode de paiement:**  
{{ $order->paymentMethod->name }}  
Référence: {{ $order->payment_reference }}

{{-- Button --}}
@component('mail::button', ['url' => route('orders.show', $order->id), 'color' => 'success'])
Suivre ma commande
@endcomponent

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
@endcomponent
@endslot
@endcomponent