@extends('layouts.app')

@section('content')
<div class="container py-3 py-lg-5">
    <h1 class="text-center mb-4 mb-lg-5 futuristic-title">Votre Panier</h1>

    @if(count($cart->items) > 0)
    <div class="cart-container bg-dark rounded-3 p-3 p-lg-4">
       
        <div class="row fw-bold border-bottom pb-2 mb-3 d-none d-md-flex">
            <div class="col-md-5">Article</div>
            <div class="col-md-2 text-center">Prix unitaire</div>
            <div class="col-md-3 text-center">Quantité</div>
            <div class="col-md-2 text-end">Total</div>
        </div>

        @foreach($cart->items as $item)
           @php
            
    $isConnected = Auth::check();

    // Si connecté, c’est un objet Eloquent, sinon un tableau
    $article = $isConnected 
        ? $item->article 
        : App\Models\Article::find($item['article_id']);

    if (!$article) {
        $this->removeInvalidItem($item);
        continue;
    }

    $itemId = $isConnected ? $item->id : $item['id'];
    $quantity = $isConnected ? $item->quantity : $item['quantity'];
    $variants = $isConnected ? $item->variants : ($item['variants'] ?? []);
    $customMessage = $isConnected ? $item->custom_message : ($item['custom_message'] ?? null);



            @endphp

           <div class="row align-items-center border-bottom pb-3 mb-3" data-item-id="{{ $itemId }}">
               
                <div class="col-12 col-md-5 mb-3 mb-md-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="carousel-thumbnail product-carousel">
                            <div class="carousel-inner ratio ratio-1x1">
                                @if($article->images->isEmpty())
                                    <div class="carousel-item active">
                                        <img src="{{ asset('images/image.png') }}" 
                                             class="d-block w-100 img-cover" 
                                             alt="{{ $article->name }}">
                                    </div>
                                @else
                                    @foreach($article->images as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $image->url) }}" 
                                                 class="d-block w-100 img-cover" 
                                                 alt="{{ $article->name }}">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="mb-1">{{ $article->name }}</h5>
                            <small class="text-success">{{ $article->category->parent->parent->name }}</small>
                         
                            <div class="d-md-none mt-2">
                                <span class="fw-bold">{{ number_format($article->base_price, 2) }} FCFA</span>
                            </div>
                        </div>
                    </div>
                </div>

              
                <div class="col-md-2 d-none d-md-block text-center">
                    {{ number_format($article->base_price, 2) }} FCFA
                </div>

                
             
                <div class="col-12 col-md-3 mb-3 mb-md-0">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2">
                        <div class="input-group futuristic-input" style="max-width: 180px;">
                            <button type="button" 
                                    class="btn btn-primary quantity-btn quantity-down py-2"
                                    data-item-id="{{ $itemId }}">−</button>
                            <input type="number" 
                                   value="{{ $quantity }}"
                                   min="1" 
                                   max="99"
                                   class="form-control text-center quantity-input py-2"
                                   data-item-id="{{ $itemId }}">
                            <button type="button" 
                                    class="btn btn-primary quantity-btn quantity-up py-2"
                                    data-item-id="{{ $itemId }}">+</button>
                        </div>
                    </div>
                </div>

           
                <div class="col-12 col-md-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-or item-total fw-bold" 
                              data-item-id="{{ $itemId }}"
                              data-price="{{ $article->base_price }}">
                            {{ number_format($quantity * $article->base_price, 2) }} FCFA
                        </span>
                        <button type="button" 
                                class="btn btn-outline-danger btn-sm delete-item-btn"
                                data-item-id="{{ $itemId }}"
                                data-route="{{ route('client.cart.remove', $itemId) }}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            

           @include('partials.cart_item', [
    'variants' => $variants,
    'customMessage' => $customMessage,
    'editable' => true,
    'itemId' => $itemId,
    'articleId' => $isConnected ? $item->article_id : $item['article_id']
])

           </div>

  @include('partials.edit-message', ['customMessage' => $customMessage])
  @include('partials.edit', [' variants' => $variants, 'articleId' => $isConnected ? $item->article_id : $item['article_id'], 'itemId' => $itemId, 'editable' => true])

         
        @endforeach


   

        <div class="row mt-4">
            <div class="col-12 col-md-8 offset-md-4">
                <div class="d-flex justify-content-between futuristic-total p-3 bg-dark-2 rounded">
                    <h4 class="mb-0">Total :</h4>
                    <h4 class="mb-0 text-or cart-total">
                        {{ number_format($cartData['total'], 2) }} FCFA
                    </h4> 
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="d-flex flex-column flex-md-row gap-3 justify-content-end">
                    <a href="{{ route('home') }}" class="btn futur-btn">
                        <i class="fas fa-arrow-left me-2"></i>Continuer mes achats
                    </a>
                    @auth
                        <a href="{{ route('checkout') }}" class="btn btn-primary futur-btn">
                            Passer la commande <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    @else
                        <button class="btn btn-primary futur-btn" data-bs-toggle="modal" data-bs-target="#authModal">
                            <i class="fas fa-lock me-2"></i>Commander
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>

   </div>
    @else

    <div class="text-center py-5">
            <i class="fas fa-shopping-cart bounce fa-4x text-or mb-4"></i>
            <h3 class="text-white mb-3">Votre panier est vide</h3>
            <p class="text-white-50 mb-4">Parcourez nos articles et trouvez ce qui vous plaît !</p>
            <a href="{{ route('products') }}" class="btn btn-dark futur-btn">
                <i class="fas fa-store me-2"></i> Voir les articles
            </a>
        </div>
    @endif

   




@if(!Auth::check())


<div class="modal fade" id="authModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content futuristic-auth-modal">

            <div class="modal-container">
                <div class="modal-header">
                    <div class="holographic-badge">
                        <svg viewBox="0 0 100 100" class="holographic-border">
                            <path d="M10,10 L90,10 L90,90 L10,90 Z" class="border-path"></path>
                        </svg>
                        <i class="fas fa-fingerprint biometric-icon"></i>
                    </div>
                    <h2 class="modal-title">Accès Sécurisé Requis</h2>
                    <p class="modal-subtitle">Authentification nécessaire pour finaliser votre transaction</p>
                </div>
                
                <div class="modal-body">
            <div class="cyber-divider">
                <span class="divider-line"></span>
                <span class="divider-text">CHOISISSEZ VOTRE MÉTHODE</span>
                <span class="divider-line"></span>
            </div>
            
            <div class="auth-options">
                <a href="{{ route('login') }}" class="auth-option login-option">
                    <div class="option-content">
                        <div class="hexagon-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <h3>Connexion</h3>
                        <p>Accédez à votre espace personnel</p>
                    </div>
                    <div class="hover-effect"></div>
                </a>
                
                <a href="{{ route('register') }}" class="auth-option register-option">
                    <div class="option-content">
                        <div class="hexagon-icon">
                            <i class="fas fa-user-astronaut"></i>
                        </div>
                        <h3>Inscription</h3>
                        <p>Créez votre compte en 30 secondes</p>
                    </div>
                    <div class="hover-effect"></div>
                </a>
            </div>
            
            
        </div>
        
        <div class="modal-footer">
                    <button type="button" class="close-modal-btn" data-bs-dismiss="modal">
                        <span>Continuer sans compte</span>
                        <div class="close-icon">
                            <div class="close-line"></div>
                            <div class="close-line"></div>
                        </div>
                    </button>
                </div>
       </div>
        </div>
    </div>
</div>



<style>

.modal-container {
 

    background: linear-gradient(145deg, #1a1a2e, #16213e);
    border: 1px solid rgba(212, 175, 55, 0.3);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5),
                0 0 0 1px rgba(212, 175, 55, 0.1),
                0 0 30px rgba(212, 175, 55, 0.1);
    max-width: 1200px;
   
    transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
}

.futuristic-auth-modal.active .modal-container {
    transform: scale(1) translateY(0);
}


.modal-header {
    padding: 2rem 2rem 1.5rem;
    text-align: center;
    position: relative;
}

.holographic-badge {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.holographic-border {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    animation: rotateBorder 8s linear infinite;
}

.border-path {
    fill: none;
    stroke: url(#holographicGradient);
    stroke-width: 2;
    stroke-dasharray: 300;
    stroke-dashoffset: 300;
    animation: dash 3s linear forwards infinite;
}

.biometric-icon {
    font-size: 2.5rem;
    color: #D4AF37;
    position: relative;
    z-index: 2;
}



.modal-subtitle {
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.95rem;
    margin-bottom: 0;
}

/* Body Styles */
.modal-body {
    padding: 0 2rem 1.5rem;
}

.cyber-divider {
    display: flex;
    align-items: center;
    margin: 1.5rem 0;
}

.divider-line {
    flex: 1;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.5), transparent);
}

.divider-text {
    padding: 0 1rem;
    color: rgba(212, 175, 55, 0.8);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.auth-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.auth-option {
    position: relative;
    padding: 1.5rem 1rem;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    text-align: center;
    color: #fff;
    text-decoration: none;
    overflow: hidden;
    transition: all 0.3s ease;
    z-index: 1;
}

.auth-option:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.login-option:hover {
    border-color: rgba(66, 165, 245, 0.5);
}

.register-option:hover {
    border-color: rgba(102, 187, 106, 0.5);
}

.hover-effect {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: -1;
}

.auth-option:hover .hover-effect {
    opacity: 1;
}

.login-option .hover-effect {
    background: linear-gradient(135deg, rgba(66, 165, 245, 0.1), transparent);
}

.register-option .hover-effect {
    background: linear-gradient(135deg, rgba(102, 187, 106, 0.1), transparent);
}

.hexagon-icon {
    width: 50px;
    height: 50px;
    margin: 0 auto 1rem;
    background: rgba(255, 255, 255, 0.1);
    clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.auth-option:hover .hexagon-icon {
    transform: rotate(15deg);
    background: rgba(212, 175, 55, 0.2);
}

.login-option .hexagon-icon {
    color: #42a5f5;
}

.register-option .hexagon-icon {
    color: #66bb6a;
}

.auth-option h3 {
    font-size: 1.1rem;
    margin-bottom: 0.3rem;
}

.auth-option p {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 0;
}


.modal-footer {
    padding: 1.5rem 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    display: flex;
    justify-content: center;
}

.close-modal-btn {
    background: none;
    border: none;
    color: rgba(255, 255, 255, 0.7);
    font-size: 0.9rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    padding: 0.5rem;
}

.close-modal-btn:hover {
    color: #fff;
}

.close-icon {
    width: 16px;
    height: 16px;
    position: relative;
}

.close-line {
    position: absolute;
    width: 100%;
    height: 2px;
    background: currentColor;
    top: 50%;
    left: 0;
}

.close-line:first-child {
    transform: rotate(45deg);
}

.close-line:last-child {
    transform: rotate(-45deg);
}


@keyframes rotateBorder {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes dash {
    to { stroke-dashoffset: 0; }
}


svg {
    position: absolute;
    width: 0;
    height: 0;
}


@media (max-width: 576px) {

    
    .modal-header {
        padding: 1.5rem 1.5rem 1rem;
    }
    
    .modal-body {
        padding: 0 1.5rem 1rem;
    }
    
    .modal-footer {
        padding: 1rem 1.5rem;
    }
    
    .holographic-badge {
        width: 60px;
        height: 60px;
        margin-bottom: 1rem;
    }
    
    .biometric-icon {
        font-size: 2rem;
    }
    
    .modal-title {
        font-size: 1.5rem;
    }
}
</style>

<svg width="0" height="0">
    <defs>
        <linearGradient id="holographicGradient" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#D4AF37" />
            <stop offset="25%" stop-color="#F4E5C2" />
            <stop offset="50%" stop-color="#D4AF37" />
            <stop offset="75%" stop-color="#F4E5C2" />
            <stop offset="100%" stop-color="#D4AF37" />
        </linearGradient>
    </defs>
</svg>

@endif


</div>

<style>

    .carousel-thumbnail {
    width: 150px;
    height: 150% !important;
   
    border-radius: 8px;
}




/* Styles pour tablettes */
@media (min-width: 768px) {
    .carousel-thumbnail {
        width: 100px;
        height: 100px;
    }
}


.quantity-btn {
    padding: 0.25rem 0.5rem;
}


/* Cart total */
.futuristic-total {
    padding: 1rem;
    background: rgba(0,0,0,0.2);
    border-radius: 8px;
}

/* Articles recommandés */
.card {
    transition: transform 0.3s ease;
}
.card:hover {
    transform: translateY(-5px);
}


/* Panier vide */
.empty-cart {
    padding: 3rem 0;
}
.empty-cart-icon {
    color: var(--or-metallise);
}
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection