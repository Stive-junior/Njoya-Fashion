@extends('layouts.app')

@section('content')

<div class="futuristic-checkout">
    <div class="checkout-progress-indicator">
        <div class="progress-steps">
            <div class="step" data-step="1">
                <div class="step-circle">1</div>
                <div class="step-label">Panier</div>
            </div>
            <div class="step" data-step="2">
                <div class="step-circle">2</div>
                <div class="step-label">Informations</div>
            </div>
            <div class="step" data-step="3">
                <div class="step-circle">3</div>
                <div class="step-label">Méthode</div>
            </div>
            <div class="step" data-step="4">
                <div class="step-circle">4</div>
                <div class="step-label">Paiement</div>
            </div>
            <div class="step" data-step="5">
                <div class="step-circle">5</div>
                <div class="step-label">Confirmation</div>
            </div>
            <div class="progress-bar">
                <div class="progress-fill"></div>
            </div>
        </div>
    </div>

    <div class="checkout-container">
        <!-- Step 1 - Cart Review -->
        <div class="checkout-step active" id="step-1">
            <div class="step-header">
                <h2><i class="fas fa-shopping-cart"></i> Votre Panier</h2>
                <p>Vérifiez les articles avant de continuer</p>
            </div>
            
            <div class="cart-items">
                @foreach($cart->items as $item)
                <div class="cart-item col-md-12 justify-content-between">
                    <div class="d-flex col-md-5">
                        <div class="item-image">
                            <img src="{{ asset('storage/'.$item->article->images->first()->url) ?? asset('images/image.png') }}" 
                                alt="{{ $item->article->name }}">
                            <span class="item-quantity">{{ $item->quantity }}</span>
                        </div>
                        <div class="item-details">
                            <h3>{{ $item->article->name }}</h3>
                            <p class="item-category">{{ $item->article->category->name }}</p>
                            <div class="item-price">{{ $item->article->base_price }} FCFA × {{ $item->quantity }}</div>
                        </div>
                    </div>
                    <div class="item-total text-end">
                        {{ $item->quantity * $item->article->base_price }} FCFA
                    </div>
                    
                    @php     
                    $isConnected = Auth::check();         
                    $itemId = $isConnected ? $item->id : $item['id'];
                    $quantity = $isConnected ? $item->quantity : $item['quantity'];
                    $variants = $isConnected ? $item->variants : ($item['variants'] ?? []);
                    $customMessage = $isConnected ? $item->custom_message : ($item['custom_message'] ?? null);
                    @endphp
                </div>
                    @include('partials.cart_item', [
                        'variants' => $variants,
                        'customMessage' => $customMessage,
                        'editable' => false,
                        'itemId' => $itemId,
                        'articleId' => $isConnected ? $item->article_id : $item['article_id']
                    ])
                
                @endforeach
            </div>
            
            <div class="cart-summary">
                <div class="summary-row">
                    <span>Sous-total</span>
                    <span>{{ $cartTotal }} FCFA</span>
                </div>
                <div class="summary-row">
                    <span>Livraison</span>
                    <span class="shipping-cost">0 FCFA</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span class="grand-total">{{ $cartTotal }} FCFA</span>
                </div>
            </div>
            
            <div class="step-actions">
                <a class="btn btn-secondary" href="{{ route('cart') }}">
                    <i class="fas fa-arrow-left"></i> Retour au panier
                </a>
                <button class="btn btn-primary next-step" data-next="2">
                    Continuer <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Step 2 - Customer Information -->
        <div class="checkout-step" id="step-2">
            <div class="step-header">
                <h2><i class="fas fa-user-circle"></i> Vos Informations</h2>
                <p>Nous avons besoin de quelques détails pour finaliser votre commande</p>
            </div>
            
            <form id="customer-info-form">
                @csrf
                
                <div class="user-info-card">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="user-details">
                        <h3>{{ Auth::user()->name }}</h3>
                        <p>{{ Auth::user()->email }}</p>
                    </div>
                </div>
                
                <div class="d-flex justify-space-between align-items-center">
                    <div class="form-section align-items-start">
                        <div class="section-title">
                            <i class="fas fa-phone"></i> Numéro de Téléphone
                        </div>
                        <div class="form-group">
                            <input type="tel" id="phone-number" name="phone" 
                                   class="futuristic-input" 
                                   value="{{ old('phone', Auth::user()->number) }}"
                                   pattern="6[0-9]{8}"
                                   required>
                            <small class="form-hint">Format: 6XX XXX XXX</small>
                            <div class="error-message" id="phone-error"></div>
                        </div>
                    </div>
                    
                    <div class="form-section align-items-start">
                        <div class="section-title">
                            <i class="fas fa-truck"></i> Adresse de Livraison
                        </div>
                        
                        @if(Auth::user()->adresses->count() > 0)
                        <div class="saved-addresses">
                            <div class="form-group">
                                <select class="futuristic-input" id="saved-address">
                                    <option value="">Sélectionner une adresse</option>
                                    @foreach(Auth::user()->adresses as $address)
                                    <option value="{{ $address->id }}" 
                                            data-street="{{ $address->street }}"
                                            data-city="{{ $address->city }}"
                                            data-country="{{ $address->country }}">
                                        {{ $address->street }}, {{ $address->city }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="form-hint">Choisir une adresse enregistrée</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="or-divider">
                    <span>OU</span>
                </div>
                
                <div class="address-form" id="manual-address-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="futuristic-label" for="city">Ville</label>
                            <input type="text" id="city" name="city" 
                                   class="futuristic-input" required>
                            <div class="error-message" id="city-error"></div>
                        </div>

                        <div class="form-group">
                            <label class="futuristic-label" for="street">Rue</label>
                            <input type="text" id="street" name="street" 
                                   class="futuristic-input" required>
                            <div class="error-message" id="street-error"></div>
                        </div>
                        
                        <div class="form-group">
                            <label class="futuristic-label" for="postal_code"><i class="text-warning fas fa-map-marker-alt"></i> Précision</label>
                            <input type="text" id="postal_code" name="postal_code" 
                                   class="futuristic-input" placeholder="Où précisément ?">
                        </div>
                    </div>
                    
                    @if(Auth::check())
                    <div class="form-check">
                        <input type="checkbox" id="save-address" name="save_address" 
                               class="futuristic-checkbox">
                        <label for="save-address">Enregistrer cette adresse</label>
                    </div>
                    @endif
                </div>
                
                <div class="step-actions">
                    <button type="button" class="btn btn-secondary prev-step" data-prev="1">
                        <i class="fas fa-arrow-left"></i> Retour
                    </button>
                    <button type="button" class="btn btn-primary next-step" data-next="3">
                        Continuer <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Step 3 - Payment Method Selection -->
        <div class="checkout-step" id="step-3">
            <div class="step-header">
                <h2><i class="fas fa-credit-card"></i> Méthode de Paiement</h2>
                <p>Choisissez votre méthode de paiement préférée</p>
            </div>
            
            <div class="payment-methods">
                @foreach($paymentMethods as $method)
                <label class="payment-method-card" data-method="{{ $method->id }}" for="method-{{ $method->id }}">
                    <input type="radio" name="payment_method" id="method-{{ $method->id }}" value="{{ $method->id }}" hidden>

                    <div class="method-content">
                        <div class="method-logo">
                            <img src="{{ asset('storage/'.$method->logo) ?? asset('images/image.png') }}" class="bg-white"
                                 alt="{{ $method->name }}">
                        </div>
                        <div class="method-info">
                            <h5>{{ $method->name }}</h5>
                            <div class="method-number">{{ $method->numero }}</div>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
            
            <!-- Ajout du toggle pour le paiement partiel -->
            <div id="partial-payment-container" class="hidden mt-4">
                <div class="form-check">
                    <input type="checkbox" id="partial-payment" class="futuristic-checkbox">
                    <label for="partial-payment">
                        Payer une partie maintenant et le reste à la livraison
                    </label>
                </div>
                
                <div class="partial-amount hidden mt-2">
                    <label for="partial-amount">Montant à payer maintenant</label>
                    <input type="number" id="partial-amount" class="futuristic-input" 
                           min="{{ $cartTotal * 0.5 }}" max="{{ $cartTotal }}" 
                           value="{{ $cartTotal * 0.5 }}">
                    <small>Minimum {{ $cartTotal * 0.5 }} FCFA, maximum {{ $cartTotal }} FCFA</small>
                </div>
            </div>
            
            <div class="step-actions">
                <button class="btn btn-secondary prev-step" data-prev="2">
                    <i class="fas fa-arrow-left"></i> Retour
                </button>
                <button class="btn btn-primary next-step" data-next="4">
                    Continuer <i class="fas fa-arrow-right"></i>
                </button>
            </div>
        </div>

        <!-- Step 4 - Payment Details -->
        <div class="checkout-step" id="step-4">
            <div class="step-header">
                <h2><i class="fas fa-money-bill-wave"></i> Détails du Paiement</h2>
                <p>Confirmez les détails avant de procéder au paiement</p>
            </div>
            
            <div class="payment-summary-card">
                <div class="payment-method-display">
                    <img id="selected-method-logo" src="" alt="Méthode de paiement">
                    <h4 id="selected-method-name"></h4>
                </div>
                
                <div class="payment-details">
                    <div class="detail-row">
                        <span>Numéro du compte:</span>
                        <span id="payment-account-number" class="highlight"></span>
                    </div>
                    <div class="detail-row">
                        <span>Montant total:</span>
                        <span class="amount">{{ $cartTotal }} FCFA</span>
                    </div>
                    <div class="detail-row partial-payment-row hidden">
                        <span>Montant à payer maintenant:</span>
                        <span id="partial-amount-display" class="amount"></span>
                    </div>
                    <div class="detail-row partial-payment-row hidden">
                        <span>Reste à payer à la livraison:</span>
                        <span id="remaining-amount" class="amount"></span>
                    </div>
                </div>
                
                <div class="payment-instructions">
                    <h5>Instructions:</h5>
                    <p id="payment-instructions-text"></p>
                </div>
                
                <div class="payment-confirmation">
                    <div class="form-check">
                        <input type="checkbox" id="confirm-payment" class="futuristic-checkbox">
                        <label for="confirm-payment">
                            J'ai effectué le paiement selon les instructions ci-dessus
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="step-actions">
                <button class="btn btn-secondary prev-step" data-prev="3">
                    <i class="fas fa-arrow-left"></i> Retour
                </button>
                <button class="btn btn-primary" id="proceed-to-confirmation">
                    Confirmer le Paiement <i class="fas fa-check-circle"></i>
                </button>
            </div>
        </div>

        <!-- Step 5 - Payment Processing -->
        <div class="checkout-step" id="step-5">
            <div class="payment-processing-container">
                <div class="processing-animation">
                    <div class="loader">
                        <div class="hourglass"></div>
                    </div>
                    <h3>Validation de votre paiement</h3>
                    <p>Veuillez patienter pendant que nous vérifions votre paiement</p>
                    
                    <div class="countdown-timer">
                        <span id="countdown-minutes">05</span>:<span id="countdown-seconds">00</span>
                    </div>
                    
                    <div class="payment-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Ne quittez pas cette page pendant le traitement</span>
                    </div>

                    <div class="step-actions">
                <button class="btn btn-danger prev-step" id="cancel-payment-btn">
                    <i class="fas fa-times"></i> Annuler et modifier
                </button>
            </div>

                </div>
                
                <div class="payment-feedback hidden">
                    <div class="feedback-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3>Paiement Reçu!</h3>
                    <p class="feedback-message">Votre commande est maintenant en cours de préparation</p>
                    
                    <div class="order-summary">
                        <div class="summary-item">
                            <span>Référence:</span>
                            <span id="payment-reference"></span>
                        </div>
                        <div class="summary-item">
                            <span>Montant reçu:</span>
                            <span id="received-amount"></span>
                        </div>
                    </div>
                    
                    <div class="next-actions">
                        <a href="{{ route('orders.show', '') }}" class="btn btn-primary" id="view-order-btn">
                            <i class="fas fa-shopping-bag"></i> Voir ma commande
                        </a>
                        <button class="btn btn-secondary" id="modify-order-btn">
                            <i class="fas fa-edit"></i> Modifier la commande
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-home"></i> Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalTitle">Erreur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="errorModalBody">
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>


<style>

    

                    .futuristic-checkout {
                        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
                        color: #fff;
                        min-height: 100vh;
                        padding: 2rem 0;
                    }

                    .checkout-progress-indicator {
                        position: relative;
                        max-width: 800px;
                        margin: 0 auto 3rem;
                        padding: 0 1rem;
                    }

                    .progress-steps {
                        display: flex;
                        justify-content: space-between;
                        position: relative;
                    }

                    .progress-ba {
                        position: absolute;
                        top: 19px;
                        left: 8px;
                        right: 29px;
                        height: 4px;
                        background: rgba(255, 255, 255, 0.1);
                        z-index: 1;
                        border-radius: 2px;
                    }

                    .progress-fill {
                        height: 100%;
                        width: 0%;
                        background: linear-gradient(90deg, #00d2ff, #3a7bd5);
                        border-radius: 2px;
                        transition: width 0.5s ease;
                    }

                    .step {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        position: relative;
                        z-index: 2;
                        opacity: 1;
                        transition: all 0.3s ease;
                    }

                    .step.active {
                        opacity: 1;
                    }

                    .step-circle {
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                        background: linear-gradient(135deg,var(--or),var(--or));
                        color: var(--bs-dark);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-weight: bold;
                        margin-bottom: 8px;
                        border: 2px solid rgba(255, 255, 255, 0.2);
                        transition: all 0.3s ease;
                    }

                    .step.active .step-circle {
                        background: linear-gradient(135deg, #00d2ff, #3a7bd5);
                        border-color: #3a7bd5;
                        color: #fff;
                        box-shadow: 0 0 15px rgba(58, 123, 213, 0.5);
                    }

                    .step-label {
                        color: rgba(255, 255, 255, 0.7);
                        font-size: 0.9rem;
                        text-align: center;
                    }

                    .step.active .step-label {
                        color: #fff;
                        font-weight: 500;
                    }

                    .checkout-container {
                        max-width: 1000px;
                        margin: 0 auto;
                        padding: 0 1rem;
                    }

                    .checkout-step {
                        display: none;
                        animation: fadeIn 0.5s ease;
                    }

                    .checkout-step.active {
                        display: block;
                    }

                    .step-header {
                        margin-bottom: 2rem;
                        text-align: center;
                    }

                    .step-header h2 {
                        font-size: 2rem;
                        margin-bottom: 0.5rem;
                        color: #fff;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 0.5rem;
                    }

                    .step-header p {
                        color: rgba(255, 255, 255, 0.7);
                        font-size: 1.1rem;
                    }

                    .cart-items {
                        background: rgba(255, 255, 255, 0.05);
                        border-radius: 12px;
                        padding: 1rem;
                        margin-bottom: 1.5rem;
                        border: 1px solid rgba(255, 255, 255, 0.1);
                    }

                    .cart-item {
                        display: flex;
                        flex-direction: row;
                        align-items: center;
                        padding: 1rem 0;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                    }

                    .cart-item:last-child {
                        border-bottom: none;
                    }

                    .item-image {
                        position: relative;
                        width: 80px;
                        height: 80px;
                        margin-right: 1.5rem;
                        flex-shrink: 0;
                    }

                    .item-image img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        border-radius: 8px;
                        border: none !important;
                    }

                    .item-quantity {
                        position: absolute;
                        top: -8px;
                        right: -8px;
                        width: 28px;
                        height: 28px;
                        background: linear-gradient(135deg, #00d2ff, #3a7bd5);
                        color: white;
                        border-radius: 50%;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-size: 0.8rem;
                        font-weight: bold;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
                    }

                    .item-details {
                        flex-grow: 1;
                    }

                    .item-details h3 {
                        font-size: 1.1rem;
                        margin-bottom: 0.3rem;
                        color: #fff;
                    }

                    .item-category {
                        font-size: 0.85rem;
                        color: rgba(255, 255, 255, 0.6);
                        margin-bottom: 0.5rem;
                    }

                    .item-price {
                        font-size: 0.9rem;
                        color: rgba(255, 255, 255, 0.8);
                    }

                    .item-total {
                        font-weight: bold;
                        color: var(--bs-warning);
                        font-size: 1.1rem;
                        min-width: 100px;
                        text-align: right;
                    }

                    .cart-summary {
                        background: rgba(255, 255, 255, 0.05);
                        border-radius: 12px;
                        padding: 1.5rem;
                        margin-bottom: 2rem;
                        border: 1px solid rgba(255, 255, 255, 0.1);
                    }

                    .summary-row {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 0.8rem;
                        color: rgba(255, 255, 255, 0.8);
                    }

                    .summary-row.total {
                        font-size: 1.2rem;
                        font-weight: bold;
                        color: #fff;
                        margin-top: 1rem;
                        padding-top: 1rem;
                        border-top: 1px solid rgba(255, 255, 255, 0.1);
                    }

                    .grand-total {
                        color: #00d2ff;
                    }

                    .step-actions {
                        display: flex;
                        justify-content: space-between;
                        margin-top: 2rem;
                    }

                    .futuristic-checkout .btn {
                        padding: 0.8rem 1.5rem;
                        border-radius: 8px;
                        font-weight: 600;
                        display: inline-flex;
                        align-items: center;
                        gap: 0.5rem;
                        transition: all 0.3s ease;
                        border: none;
                        cursor: pointer;
                    }

                    .btn-secondary {
                        background: rgba(255, 255, 255, 0.1);
                        color: #fff;
                    }

                    .btn-secondary:hover {
                        background: rgba(255, 255, 255, 0.2);
                    }

                    .btn-primary {
                        background: linear-gradient(135deg, #00d2ff, #3a7bd5);
                        color: #fff;
                        box-shadow: 0 4px 15px rgba(0, 210, 255, 0.3);
                    }

                    .btn-primary:hover {
                        background: linear-gradient(135deg, #00c4f0, #2a6bcc);
                        box-shadow: 0 6px 20px rgba(0, 210, 255, 0.4);
                        transform: translateY(-2px);
                    }

                    .futuristic-input {
                        width: 100%;
                        padding: 0.8rem 1rem;
                        border-radius: 8px;
                        border: 1px solid rgba(255, 255, 255, 0.2);
                        background: rgba(255, 255, 255, 0.05);
                        color: #fff;
                        font-size: 1rem;
                        transition: all 0.3s ease;
                    }

                    .futuristic-input:focus {
                        outline: none;
                        border-color: #3a7bd5;
                        background: rgba(255, 255, 255, 0.1);
                        box-shadow: 0 0 0 3px rgba(58, 123, 213, 0.3);
                    }

                    .futuristic-select {
                        width: 100%;
                        padding: 0.8rem 1rem;
                        border-radius: 8px;
                        border: 1px solid rgba(255, 255, 255, 0.2);
                        background: rgba(255, 255, 255, 0.05) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23ffffff' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") no-repeat;
                        background-position: right 1rem center;
                        background-size: 16px;
                        color: #fff;
                        font-size: 1rem;
                        appearance: none;
                        transition: all 0.3s ease;
                    }

                    .futuristic-select:focus {
                        outline: none;
                        border-color: #3a7bd5;
                        background-color: rgba(255, 255, 255, 0.1);
                        box-shadow: 0 0 0 3px rgba(58, 123, 213, 0.3);
                    }

                    .form-group {
                        margin-bottom: 1.5rem;
                    }

                    .form-group label {
                        display: block;
                        margin-bottom: 0.5rem;
                        color: rgba(255, 255, 255, 0.8);
                        font-size: 0.95rem;
                    }

                    .form-row {
                        display: flex;
                        gap: 1.5rem;
                        margin-bottom: 1.5rem;
                    }

                    .form-row .form-group {
                        flex: 1;
                        margin-bottom: 0;
                    }

                    .user-info-card {
                        display: flex;
                        align-items: center;
                        background: rgba(255, 255, 255, 0.05);
                        border-radius: 12px;
                        padding: 1.5rem;
                        margin-bottom: 2rem;
                        border: 1px solid rgba(255, 255, 255, 0.1);
                    }

                    .user-avatar {
                        width: 60px;
                        height: 60px;
                        border-radius: 50%;
                        background: linear-gradient(135deg, #00d2ff, #3a7bd5);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin-right: 1.5rem;
                        font-size: 1.5rem;
                        color: #fff;
                    }

                    .user-details h3 {
                        font-size: 1.2rem;
                        margin-bottom: 0.3rem;
                        color: #fff;
                    }

                    .user-details p {
                        color: rgba(255, 255, 255, 0.7);
                        font-size: 0.95rem;
                    }

                    .section-title {
                        display: flex;
                        align-items: center;
                        gap: 0.5rem;
                        color: #00d2ff;
                        font-size: 1.1rem;
                        margin: 2rem 0 1.5rem;
                        padding-bottom: 0.5rem;
                        border-bottom: 1px solid rgba(0, 210, 255, 0.2);
                    }

                    .saved-addresses {
                        margin-bottom: 1.5rem;
                    }

                    .or-divider {
                        display: flex;
                        align-items: center;
                        margin: 1.5rem 0;
                        color: rgba(255, 255, 255, 0.5);
                    }

                    .or-divider::before,
                    .or-divider::after {
                        content: "";
                        flex: 1;
                        height: 1px;
                        background: rgba(255, 255, 255, 0.1);
                        margin: 0 1rem;
                    }

                    .futuristic-checkbox {
                        position: relative;
                        appearance: none;
                        width: 20px;
                        height: 20px;
                        border: 1px solid rgba(255, 255, 255, 0.3);
                        border-radius: 4px;
                        background: rgba(255, 255, 255, 0.05);
                        cursor: pointer;
                        transition: all 0.2s ease;
                        margin-right: 0.5rem;
                        vertical-align: middle;
                    }

                    .futuristic-checkbox:checked {
                        background: linear-gradient(135deg, #00d2ff, #3a7bd5);
                        border-color: #3a7bd5;
                    }

                    .futuristic-checkbox:checked::after {
                        content: "✓";
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        color: #fff;
                        font-size: 0.8rem;
                    }

                    .form-check {
                        display: flex;
                        align-items: center;
                        margin-bottom: 1.5rem;
                    }

                    .form-check label {
                        margin-bottom: 0;
                        cursor: pointer;
                    }

                    .payment-methods {
                        display: flex;
                        flex-direction: row;
                        flex-wrap: wrap;
                        gap: 0.7rem;
                        margin-bottom: 2rem;
                    }

                    .payment-method-card {
                        display: flex;
                        align-items: center;
                        background: rgba(255, 255, 255, 0.05);
                        border-radius: 12px;
                        padding: 1.2rem;
                        border: 1px solid rgba(255, 255, 255, 0.1);
                        cursor: pointer;
                        transition: all 0.3s ease;
                        position: relative;
                    }

                    .payment-method-card:hover {
                        background: rgba(255, 255, 255, 0.1);
                        border-color: rgba(255, 255, 255, 0.2);
                        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.3);
                    }

                    .payment-method-card.selected {
                        box-shadow: 0 0 10px 4px var(--bs-success);
                        border-color: var(--bs-success);
                    }



                    .method-info {
                        flex-grow: 1;
                    }

                    .method-info h3 {
                        font-size: 1.1rem;
                        margin-bottom: 0.2rem;
                        color: #fff;
                    }

                    .method-info p {
                        font-size: 0.85rem;
                        color: rgba(255, 255, 255, 0.7);
                    }

                    .payment-form-container {
                        margin-top: 2rem;
                    }

                    .partial-payment-option {
                        background: rgba(0, 210, 255, 0.05);
                        border-radius: 8px;
                        padding: 1rem;
                        margin-bottom: 1.5rem;
                        border: 1px solid rgba(0, 210, 255, 0.1);
                    }

                    .partial-amount {
                        margin-top: 1rem;
                        padding-top: 1rem;
                        border-top: 1px solid rgba(255, 255, 255, 0.1);
                    }

                    .partial-amount small {
                        display: block;
                        margin-top: 0.5rem;
                        font-size: 0.8rem;
                        color: rgba(255, 255, 255, 0.5);
                    }

                    .payment-security {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 0.5rem;
                        color: rgba(255, 255, 255, 0.7);
                        font-size: 0.9rem;
                        margin-top: 1.5rem;
                    }

                    .payment-security i {
                        color: #00d2ff;
                    }

                    .payment-processing {
                        text-align: center;
                        padding: 3rem 0;
                    }

                    .loader {
                        display: flex;
                        justify-content: center;
                        gap: 0.5rem;
                        margin-bottom: 2rem;
                    }

                    .circle {
                        width: 15px;
                        height: 15px;
                        border-radius: 50%;
                        background: linear-gradient(135deg, #00d2ff, #3a7bd5);
                        animation: bounce 1.5s infinite ease-in-out;
                    }

                    .circle:nth-child(2) {
                        animation-delay: 0.2s;
                    }

                    .circle:nth-child(3) {
                        animation-delay: 0.4s;
                    }

                    .payment-status {
                        max-width: 500px;
                        margin: 0 auto;
                    }

                    .status-icon {
                        font-size: 5rem;
                        margin-bottom: 1.5rem;
                        color: #00d2ff;
                    }

                    .status-icon.success {
                        color: #4CAF50;
                    }

                    .status-message {
                        font-size: 1.1rem;
                        color: rgba(255, 255, 255, 0.8);
                        margin-bottom: 2rem;
                    }

                    .order-summary {
                        background: rgba(255, 255, 255, 0.05);
                        border-radius: 12px;
                        padding: 1.5rem;
                        margin-bottom: 2rem;
                        border: 1px solid rgba(255, 255, 255, 0.1);
                        text-align: left;
                    }

                    .summary-item {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 0.8rem;
                        color: rgba(255, 255, 255, 0.8);
                    }

                    .summary-item:last-child {
                        margin-bottom: 0;
                    }

                    .order-number, .amount-paid, .payment-method {
                        color: #fff;
                        font-weight: 500;
                    }

                    .next-steps {
                        text-align: left;
                        margin-top: 2rem;
                    }

                    .next-steps h4 {
                        font-size: 1.2rem;
                        margin-bottom: 1rem;
                        color: #fff;
                    }

                    .next-steps ul {
                        list-style: none;
                        padding: 0;
                    }

                    .next-steps li {
                        margin-bottom: 0.8rem;
                        display: flex;
                        align-items: center;
                        gap: 0.8rem;
                        color: rgba(255, 255, 255, 0.8);
                    }

                    .next-steps li i {
                        color: #00d2ff;
                    }

                    .hidden {
                        display: none !important;
                    }

                    .futuristic-modal {
                        position: fixed;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        background: var(--bs-dark);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        z-index: 1000;
                        opacity: 0;
                        visibility: hidden;
                        transition: all 0.3s ease;
                    }

                    .futuristic-modal.active {
                        opacity: 1;
                        visibility: visible;
                    }

                    .modal-content {
                        background: linear-gradient(135deg, var(--bs-dark), #203a43);
                        border-radius: 16px;
                        width: 90%;
                        max-width: 500px;
                        border: 1px solid rgba(255, 255, 255, 0.1);
                        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
                        overflow: hidden;
                        transform: translateY(20px);
                        transition: all 0.3s ease;
                    }

                    .futuristic-modal.active .modal-content {
                        transform: translateY(0);
                    }

                    .modal-header {
                        padding: 1.5rem;
                        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                        position: relative;
                    }

                    .modal-header h3 {
                        margin: 0;
                        color: #fff;
                        font-size: 1.3rem;
                    }

                    .close {
                        position: absolute;
                        top: 1.5rem;
                        right: 1.5rem;
                        background: none;
                        border: none;
                        color: rgba(255, 255, 255, 0.6);
                        font-size: 1.5rem;
                        cursor: pointer;
                        transition: all 0.2s ease;
                    }

                    .close:hover {
                        color: #fff;
                    }

                    .modal-body {
                        padding: 1.5rem;
                        color: rgba(255, 255, 255, 0.8);
                    }

                    .modal-footer {
                        padding: 1.5rem;
                        border-top: 1px solid rgba(255, 255, 255, 0.1);
                        display: flex;
                        justify-content: flex-end;
                        gap: 1rem;
                    }

                    .sync-options {
                        margin-top: 1.5rem;
                    }

                    .sync-option {
                        margin-bottom: 1rem;
                    }

                    .sync-option input {
                        position: absolute;
                        opacity: 0;
                    }

                    .sync-option label {
                        display: flex;
                        align-items: center;
                        padding: 1rem;
                        background: rgba(255, 255, 255, 0.05);
                        border-radius: 8px;
                        border: 1px solid rgba(255, 255, 255, 0.1);
                        cursor: pointer;
                        transition: all 0.3s ease;
                    }

                    .sync-option input:checked + label {
                        background: rgba(0, 210, 255, 0.1);
                        border-color: rgba(0, 210, 255, 0.3);
                    }

                    .option-icon {
                        width: 40px;
                        height: 40px;
                        border-radius: 50%;
                        background: rgba(0, 210, 255, 0.1);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        margin-right: 1rem;
                        color: #00d2ff;
                        font-size: 1.2rem;
                    }

                    .option-content h4 {
                        font-size: 1rem;
                        margin-bottom: 0.2rem;
                        color: #fff;
                    }

                    .option-content p {
                        font-size: 0.85rem;
                        color: rgba(255, 255, 255, 0.7);
                        margin: 0;
                    }

                    /* Animations */
                    @keyframes fadeIn {
                        from { opacity: 0; transform: translateY(10px); }
                        to { opacity: 1; transform: translateY(0); }
                    }

                    @keyframes bounce {
                        0%, 100% { transform: translateY(0); }
                        50% { transform: translateY(-15px); }
                    }


                    @media (max-width: 768px) {
                        .step-circle {
                            width: 35px;
                            height: 35px;
                        }
                        
                        .step-label {
                            font-size: 0.8rem;
                        }
                        
                        .form-row {
                            flex-direction: inherit;
                            gap: 1rem;
                        }
                        
                        .cart-item {
                            flex-wrap: wrap;
                        }
                        
                        .item-details, .item-total {
                            width: 100%;
                            margin-top: 0.5rem;
                        }
                        
                        .item-total {
                            text-align: left;
                        }

                        .payment-methods{
                            flex-direction: column;
                        }
                        
                      
                        
                        
                    }

                    @media (max-width: 480px) {
                        .step-header h2 {
                            font-size: 1.5rem;
                        }
                        
                        .step-header p {
                            font-size: 1rem;
                        }
                        
                        .item-image {
                            width: 60px;
                            height: 60px;
                            margin-right: 1rem;
                        }
                        
                        .user-avatar {
                            width: 50px;
                            height: 50px;
                            font-size: 1.2rem;
                            margin-right: 1rem;
                        }
                        
                        .user-details h3 {
                            font-size: 1.1rem;
                        }
                    }
</style>

<script>

    document.addEventListener('DOMContentLoaded', function() {

     //   localStorage.removeItem('currentCheckoutStep');
    // Variables globales pour gérer l'état du paiement
    const steps = document.querySelectorAll('.checkout-step');
    const stepIndicators = document.querySelectorAll('.step');
    const progressFill = document.querySelector('.progress-fill');
    let currentStep = localStorage.getItem('currentCheckoutStep') || 1;
    let paymentProcessing = false;
    let paymentInitialized = false;
    let paymentVerificationInterval;
    let countdownInterval;
    let orderId = null;
    let paymentReference = null;

    // Initialisation
    initCheckout();

    function initCheckout() {
        // Restaurer l'étape courante
        goToStep(parseInt(currentStep));

        // Initialiser les écouteurs d'événements
        initStepNavigation();
        initPaymentMethodSelection();
        initPaymentConfirmation();
        initPartialPaymentToggle();
        initAddressSelection();
        initCancelButton();

        // Mettre à jour le mode sombre
        updateDarkMode();
    }

    function initStepNavigation() {
        // Navigation avant/arrière
        document.querySelectorAll('.next-step').forEach(btn => {
            btn.addEventListener('click', function() {
                const nextStep = parseInt(this.dataset.next);
                if (validateCurrentStep(currentStep)) {
                    goToStep(nextStep);
                }
            });
        });

        document.querySelectorAll('.prev-step').forEach(btn => {
            btn.addEventListener('click', function() {
                if (paymentProcessing) {
                    showError('Paiement en cours', 'Vous ne pouvez pas revenir en arrière pendant le traitement. Utilisez le bouton "Annuler" si besoin.');
                    return;
                }
                
                const prevStep = parseInt(this.dataset.prev);
                goToStep(prevStep);
                
                // Si on revient de l'étape de paiement, annuler le processus
                if (currentStep === 5) {
                    cancelPaymentProcess();
                }
            });
        });
    }

    function initPaymentMethodSelection() {
        // Sélection de la méthode de paiement
        document.querySelectorAll('.payment-method-card').forEach(card => {
            card.addEventListener('click', function() {
                const methodId = this.dataset.method;
                selectPaymentMethod(methodId);

                // Afficher le choix du paiement partiel
                document.getElementById('partial-payment-container').classList.remove('hidden');
            });
        });

        // Sélectionner la première méthode par défaut
        if (!document.querySelector('.payment-method-card.selected')) {
            const firstMethod = document.querySelector('.payment-method-card');
            if (firstMethod) {
                selectPaymentMethod(firstMethod.dataset.method);
            }
        }
    }

    function initPaymentConfirmation() {
        // Confirmation du paiement
        document.getElementById('proceed-to-confirmation')?.addEventListener('click', function() {
            if (!document.getElementById('confirm-payment').checked) {
                showError('Confirmation requise', 'Veuillez confirmer que vous avez effectué le paiement');
                return;
            }

            processPayment();
        });
    }

    function initPartialPaymentToggle() {
        const partialToggle = document.getElementById('partial-payment');
        if (!partialToggle) return;

        partialToggle.addEventListener('change', function() {
            const totalAmount = parseFloat(<?= $cartTotal ?>);
            const partialFields = document.querySelectorAll('.partial-payment-row, .partial-amount');
            
            if (this.checked) {
                partialFields.forEach(field => field.classList.remove('hidden'));
                const partialAmountInput = document.getElementById('partial-amount');
                partialAmountInput.value = (totalAmount * 0.5).toFixed(2);
                partialAmountInput.min = (totalAmount * 0.3).toFixed(2);
                partialAmountInput.max = (totalAmount * 0.9).toFixed(2);
                updatePartialAmounts(partialAmountInput.value);
            } else {
                partialFields.forEach(field => field.classList.add('hidden'));
                updatePartialAmounts(totalAmount);
            }
        });

        const partialAmountInput = document.getElementById('partial-amount');
        if (partialAmountInput) {
            partialAmountInput.addEventListener('input', function() {
                const totalAmount = parseFloat(<?= $cartTotal ?>);
                let amount = parseFloat(this.value) || 0;
                
                // Valider les limites
                if (amount < totalAmount * 0.3) {
                    amount = totalAmount * 0.3;
                    this.value = amount.toFixed(2);
                } else if (amount > totalAmount * 0.9) {
                    amount = totalAmount * 0.9;
                    this.value = amount.toFixed(2);
                }
                
                updatePartialAmounts(amount);
            });
        }
    }

    function initAddressSelection() {
        const savedAddress = document.getElementById('saved-address');
        if (!savedAddress) return;

        savedAddress.addEventListener('change', function() {
            if (this.value) {
                const selectedOption = this.options[this.selectedIndex];
                document.getElementById('street').value = selectedOption.dataset.street || '';
                document.getElementById('city').value = selectedOption.dataset.city || '';
            }
        });
    }

    function initCancelButton() {
        document.getElementById('cancel-payment-btn')?.addEventListener('click', function() {
            returnToModification();
        });
    }

    function returnToModification() {
        if (paymentProcessing) {
            cancelPaymentProcess();
        }
        
        goToStep(3);
        paymentProcessing = false;
        paymentInitialized = false;
    }

    function cancelPaymentProcess() {
        clearIntervals();
        
        if (orderId) {
            fetch(`/api/cancel-payment/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                }
            }).catch(error => console.error('Erreur d\'annulation:', error));
        }
    }

    function selectPaymentMethod(methodId) {
        document.querySelectorAll('.payment-method-card').forEach(card => {
            card.classList.remove('selected');
        });

        const selectedCard = document.querySelector(`.payment-method-card[data-method="${methodId}"]`);
        if (!selectedCard) return;

        selectedCard.classList.add('selected');

        // Mettre à jour l'affichage des détails
        const methodName = selectedCard.querySelector('h5')?.textContent || '';
        const methodNumber = selectedCard.querySelector('.method-number')?.textContent || '';
        const methodLogo = selectedCard.querySelector('img')?.src || '';

        document.getElementById('selected-method-name').textContent = methodName;
        document.getElementById('selected-method-logo').src = methodLogo;
        document.getElementById('payment-account-number').textContent = methodNumber;
    }

    function updatePartialAmounts(partialAmount) {
        const totalAmount = parseFloat(<?= $cartTotal ?>);
        const remainingAmount = totalAmount - partialAmount;

        document.getElementById('partial-amount-display').textContent = 
            `${partialAmount.toFixed(2)} FCFA`;
        document.getElementById('remaining-amount').textContent = 
            `${remainingAmount.toFixed(2)} FCFA`;
    }

    function validateCurrentStep(step) {
        switch(step) {
            case 1: return validateCart();
            case 2: return validateCustomerInfo();
            case 3: return validatePaymentMethod();
            default: return true;
        }
    }

    function validateCart() {
        const cartItems = document.querySelectorAll('.cart-item');
        if (cartItems.length === 0) {
            showError('Panier vide', 'Votre panier est vide, veuillez ajouter des articles');
            return false;
        }
        return true;
    }

    function validateCustomerInfo() {
        const phoneInput = document.getElementById('phone-number');
        const streetInput = document.getElementById('street');
        const cityInput = document.getElementById('city');
        const savedAddress = document.getElementById('saved-address');

        // Validation du téléphone
        if (phoneInput && !phoneInput.value.match(/^6[0-9]{8}$/)) {
            showError('Numéro invalide', 'Veuillez entrer un numéro de téléphone valide (format: 6XX XXX XXX)');
            return false;
        }

        // Validation de l'adresse
        if ((!savedAddress || savedAddress.value === "") && (!streetInput?.value.trim() || !cityInput?.value.trim())) {
            showError('Adresse requise', 'Veuillez sélectionner ou saisir une adresse de livraison complète');
            return false;
        }

        return true;
    }

    function validatePaymentMethod() {
        if (!document.querySelector('.payment-method-card.selected')) {
            showError('Sélection requise', 'Veuillez choisir une méthode de paiement');
            return false;
        }

        // Validation du paiement partiel
        const partialToggle = document.getElementById('partial-payment');
        if (partialToggle?.checked) {
            const partialAmount = parseFloat(document.getElementById('partial-amount').value);
            const totalAmount = parseFloat(<?= $cartTotal ?>);
            
            if (isNaN(partialAmount)) {
                showError('Montant invalide', 'Veuillez entrer un montant valide pour le paiement partiel');
                return false;
            }
            
            if (partialAmount < totalAmount * 0.3 || partialAmount > totalAmount * 0.9) {
                showError('Montant incorrect', `Le paiement partiel doit être entre ${totalAmount * 0.3} et ${totalAmount * 0.9} FCFA`);
                return false;
            }
        }

        return true;
    }

    function goToStep(stepNumber) {
        // Masquer toutes les étapes
        steps.forEach(step => {
            step.classList.remove('active');
            step.style.display = 'none';
        });

        // Afficher l'étape courante
        const currentStepElement = document.getElementById(`step-${stepNumber}`);
        if (currentStepElement) {
            currentStepElement.classList.add('active');
            currentStepElement.style.display = 'block';
        }

        // Mettre à jour les indicateurs de progression
        stepIndicators.forEach(step => {
            const stepValue = parseInt(step.dataset.step);
            step.classList.toggle('active', stepValue <= stepNumber);
            step.classList.toggle('completed', stepValue < stepNumber);
        });

        // Mettre à jour la barre de progression
        if (progressFill) {
            const progressPercentage = ((stepNumber - 1) / (steps.length - 1)) * 100;
            progressFill.style.width = `${progressPercentage}%`;
        }

        currentStep = stepNumber;
        localStorage.setItem('currentCheckoutStep', currentStep);

        // Scroll vers le haut
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Initialisations spécifiques aux étapes
        if (stepNumber === 4) initPaymentDetailsStep();
        if (stepNumber === 5) startPaymentProcessing();
    }

    function initPaymentDetailsStep() {
        const totalAmount = parseFloat(<?= $cartTotal ?>);
        document.querySelector('.payment-details .amount').textContent = `${totalAmount.toFixed(2)} FCFA`;
        document.getElementById('confirm-payment').checked = false;

        // Réinitialiser le paiement partiel
        const partialToggle = document.getElementById('partial-payment');
        if (partialToggle) {
            partialToggle.checked = false;
            partialToggle.dispatchEvent(new Event('change'));
        }

        // Sélectionner la méthode courante
        const selectedMethod = document.querySelector('.payment-method-card.selected');
        if (selectedMethod) selectPaymentMethod(selectedMethod.dataset.method);
    }

    function processPayment() {
        paymentProcessing = true;
        paymentInitialized = true;
        
        goToStep(5);
        startCountdown(5 * 60);

        // Préparer les données
        const paymentData = {
            method_id: document.querySelector('.payment-method-card.selected').dataset.method,
            amount: <?= $cartTotal ?>,
            partial_payment: document.getElementById('partial-payment').checked,
            partial_amount: document.getElementById('partial-payment').checked 
                ? parseFloat(document.getElementById('partial-amount').value)
                : null,
            phone: document.getElementById('phone-number').value,
            address_id: document.getElementById('saved-address')?.value || null,
            street: document.getElementById('street').value,
            city: document.getElementById('city').value,
            postal_code: document.getElementById('postal_code').value,
            save_address: document.getElementById('save-address')?.checked || false,
            _token: '<?= csrf_token() ?>'
        };

        fetch('/api/process-payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(paymentData)
        })
        .then(response => {
            if (!response.ok) throw new Error('Erreur réseau');
            return response.json();
        })
        .then(data => {
            if (data.success) {
                orderId = data.order_id;
                paymentReference = data.reference;
                verifyPaymentStatus();
            } else {
                showPaymentError(data.message || 'Erreur lors du traitement du paiement');
            }
        })
        .catch(error => {
            showPaymentError('Erreur de connexion: ' + error.message);
        });
    }

    function verifyPaymentStatus() {
        paymentVerificationInterval = setInterval(() => {
            if (!orderId) {
                clearInterval(paymentVerificationInterval);
                return;
            }

            fetch(`/api/check-payment/${orderId}`)
            .then(response => {
                if (!response.ok) throw new Error('Erreur de vérification');
                return response.json();
            })
            .then(data => {
                if (data.status === 'completed') {
                    clearIntervals();
                    showPaymentSuccess(data);
                } else if (data.status === 'failed') {
                    clearIntervals();
                    showPaymentError(data.message || 'Paiement échoué');
                }
            })
            .catch(error => console.error('Erreur de vérification:', error));
        }, 10000);
    }

    function clearIntervals() {
        clearInterval(paymentVerificationInterval);
        clearInterval(countdownInterval);
    }

    function startCountdown(seconds) {
        let remaining = seconds;
        updateCountdownDisplay(remaining);

        countdownInterval = setInterval(() => {
            remaining--;
            updateCountdownDisplay(remaining);

            if (remaining <= 0) {
                clearInterval(countdownInterval);
                if (!document.querySelector('.payment-feedback.success')) {
                    showPaymentTimeout();
                }
            }
        }, 1000);
    }

    function updateCountdownDisplay(seconds) {
        const mins = Math.floor(seconds / 60).toString().padStart(2, '0');
        const secs = (seconds % 60).toString().padStart(2, '0');
        
        document.getElementById('countdown-minutes').textContent = mins;
        document.getElementById('countdown-seconds').textContent = secs;
    }

    function showPaymentSuccess(data) {
        paymentProcessing = false;
        
        document.querySelector('.processing-animation').classList.add('hidden');
        const feedbackEl = document.querySelector('.payment-feedback');
        feedbackEl.classList.remove('hidden');
        feedbackEl.classList.add('success');

        document.getElementById('payment-reference').textContent = paymentReference;
        document.getElementById('received-amount').textContent = 
            `${(data.partial_amount || data.amount).toFixed(2)} FCFA`;

        // Mettre à jour le bouton "Voir ma commande"
        const viewOrderBtn = document.getElementById('view-order-btn');
        if (viewOrderBtn && orderId) {
            viewOrderBtn.href = `/orders/${orderId}`;
        }

        // Ajouter le bouton de modification
        const modifyBtn = document.createElement('button');
        modifyBtn.className = 'btn btn-secondary';
        modifyBtn.innerHTML = '<i class="fas fa-edit"></i> Modifier la commande';
        modifyBtn.addEventListener('click', returnToModification);
        
        const actionsEl = feedbackEl.querySelector('.next-actions');
        if (actionsEl) actionsEl.prepend(modifyBtn);

        localStorage.removeItem('currentCheckoutStep');
    }

    function showPaymentError(message) {
        paymentProcessing = false;
        
        document.querySelector('.processing-animation').classList.add('hidden');
        const feedbackEl = document.querySelector('.payment-feedback');
        feedbackEl.classList.remove('hidden');
        feedbackEl.classList.add('error');

        feedbackEl.querySelector('.feedback-icon').innerHTML = '<i class="fas fa-times-circle"></i>';
        feedbackEl.querySelector('h3').textContent = 'Erreur de Paiement';
        feedbackEl.querySelector('.feedback-message').textContent = message;

        // Ajouter le bouton de réessai
        const retryBtn = document.createElement('button');
        retryBtn.className = 'btn btn-primary';
        retryBtn.innerHTML = '<i class="fas fa-sync-alt"></i> Réessayer';
        retryBtn.addEventListener('click', returnToModification);
        
        const actionsEl = feedbackEl.querySelector('.next-actions');
        if (actionsEl) actionsEl.prepend(retryBtn);
    }

    function showPaymentTimeout() {
        showPaymentError('Temps écoulé - Nous n\'avons pas reçu confirmation de votre paiement');
    }

    function showError(title, message) {
        const modal = new bootstrap.Modal(document.getElementById('errorModal'));
        document.getElementById('errorModalTitle').textContent = title;
        document.getElementById('errorModalBody').textContent = message;
        modal.show();
    }

    function updateDarkMode() {
        const isDark = document.body.classList.contains('dark-mode');
        document.querySelectorAll('.checkout-container, .payment-method-card, .payment-summary-card')
            .forEach(el => el.classList.toggle('dark-mode', isDark));
    }

    // Observer les changements de mode sombre
    new MutationObserver(updateDarkMode).observe(document.body, {
        attributes: true,
        attributeFilter: ['class']
    });
});


</script>

@endsection