@php

$isInCart = Auth::check() 
    ? auth()->user()->panierItems()->where('article_id', $article->id)->exists()
    : (Session::has('cart.items') && collect(Session::get('cart.items'))->contains('article_id', $article->id));


$quantity = 0;
if ($isInCart) {
    if (Auth::check()) {
        $quantity = auth()->user()->panierItems()->where('article_id', $article->id)->first()->quantity;
    } else {
        $cartItem = collect(Session::get('cart.items'))->firstWhere('article_id', $article->id);
        $quantity = $cartItem['quantity'] ?? 0;
    }
}
@endphp

<div class="cart-btn-wrapper position-relative d-inline-block">
    <button class="btn btn-icon futu-btn add-to-cart" 
            data-article-id="{{ $article->id }}"
            data-bs-toggle="modal" 
            data-bs-target="#quantityModal{{ $article->id }}">
        <i class="fas {{ $isInCart ? 'fa-cart-arrow-down' : 'fa-cart-plus' }}"></i>
    </button>
    
    @if($isInCart)
        <span class="start-100 position-absolute translate-middle item-quantity">
            {{ $quantity }}
            <span class="visually-hidden">articles dans le panier</span>
        </span>
    @endif
</div>

<style>


.item-quantity{
    top:7px;
}


.add-to-cart i {
    font-size: 1.25rem;
    transition: transform 0.2s;
}



.cart-btn-wrapper .cart-badge {
    font-size: 0.65rem;
    padding: 0.65em 1.1em;
    min-width: 20px;
    min-height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    top:8px !important;
    left: 46px !important;
    
}

.cart-badge:hover {
    transform: translate(-50%, -50%) scale(1.2);
}
</style>