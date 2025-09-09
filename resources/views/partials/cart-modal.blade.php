@php

$averageRating = $article->favorites->avg('rating') ?? 2;
$timeAgo = $article->created_at->diffForHumans();


$cartItem = isset($cartData['items']) ? collect($cartData['items'])->firstWhere('article_id', $article->id) : null;
$isInCart = !is_null($cartItem);
$quantity = $isInCart ? $cartItem['quantity'] : 1;
$itemId = $isInCart ? $cartItem['id'] : null;


$selectedVariants = [
    'sizes' => $isInCart ? ($cartItem['variants']['sizes'] ?? null) : null,
    'colors' => $isInCart ? ($cartItem['variants']['colors'] ?? null) : null,
    'materials' => $isInCart ? ($cartItem['variants']['materials'] ?? null) : null
];

$variants = [
    'sizes' => $article->variants->pluck('sizes')->flatten()->unique()->filter()->values()->toArray(),
    'colors' => $article->variants->pluck('colors')->flatten()->unique()->filter()->values()->toArray(),
    'materials' => $article->variants->pluck('materials')->flatten()->unique()->filter()->values()->toArray()
];
@endphp

<div class="modal fade futuristic-modal" id="quantityModal{{ $article->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-or">
            <div class="modal-header border-bottom-or">
                <h5 class="modal-title text-or">{{ $article->name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row g-4">

                    <div class="col-12 col-md-6">
                        <!-- Carrousel d'images -->
                        <div id="modalCarousel{{ $article->id }}" class="carousel slide product-carousel mb-4" data-bs-ride="carousel">
                            <div class="carousel-inner ratio ratio-1x1 overflow-hidden rounded">
                                @forelse($article->images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image->url) }}" class="d-block w-100 img-cover" alt="{{ $article->name }}">
                                    </div>
                                @empty
                                    <div class="carousel-item active">
                                        <img src="{{ asset('images/image.png') }}" class="d-block w-100 img-cover" alt="Image par défaut">
                                    </div>
                                @endforelse
                            </div>

                            @if($article->images->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#modalCarousel{{ $article->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#modalCarousel{{ $article->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                </button>
                            @endif
                        </div>



<div class="variant-selector mb-4">
    @foreach(['sizes' => 'Taille', 'colors' => 'Couleur', 'materials' => 'Matière'] as $type => $label)
        @if(!empty($variants[$type]))
            <div class="mb-5 d-flex">
                <label class="text-or me-2">{{ $label }} :</label>
                <div class="d-flex flex-wrap gap-3">
                    @foreach($variants[$type] as $option)
                        @php $isSelected = $selectedVariants[$type] === $option; @endphp

                        <div class="stive position-relative d-inline-block">
                            @if($type === 'colors')
                                <div class="color-option {{ $isSelected ? 'active' : '' }}" 
                                     style="background-color: <?= $option ?>"
                                     data-type="{{ $type }}"
                                     data-value="{{ $option }}"
                                     title="{{ $option }}">
                                </div>
                            @else
                                <button type="button" 
                                        class="btn btn-outline-or variant-option {{ $isSelected ? 'active' : '' }}"
                                        data-type="{{ $type }}"
                                        data-value="{{ $option }}">
                                    {{ $option }}
                                </button>
                            @endif

                         
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach
</div>


                        <input type="hidden" id="selectedVariants{{ $article->id }}" name="selected_variants" 
                               value="{{ json_encode($selectedVariants) }}">
                    </div>


                    <div class="col-12 col-md-6 d-flex flex-column ">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="text-or mb-0">{{ number_format($article->base_price, 2) }} FCFA</h4>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="star-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= round($averageRating) ? 'text-warning' : 'text-secondary' }}"></i>
                                        @endfor
                                    </div>
                                    <small class="text-white">({{ number_format($averageRating, 1) }}/5)</small>
                                </div>
                            </div>

                            <p class="text-white-50 mb-3"><small>Ajouté {{ $timeAgo }}</small></p>
                            <hr class="border-or">
                            <p class="mb-4">{{ $article->description }}</p>


                      



<input type="hidden" id="variantQuantities{{ $article->id }}" name="variant_quantities" value="">
                          
                            <div class="mb-4">
                                <label class="text-or mb-2">Quantité :</label>
                                <div class="input-group futuristic-input">
                                    <button type="button" 
                                        class="btn futur-btn quantit quantit-down" 
                                        data-article-id="{{ $article->id }}">
                                        <i class="fas fa-minus"></i>
                                    </button>

                                    <input type="number" 
                                        value="{{ $quantity }}"
                                        min="1" 
                                        max="99"
                                        class="form-control text-center quantit-input"
                                        data-article-id="{{ $article->id }}"
                                        data-initial-value="{{ $quantity }}">

                                    <button type="button" 
                                        class="btn futur-btn quantit quantit-up" 
                                        data-article-id="{{ $article->id }}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                           <div class="selected-variants-display mb-4 p-3 bg-dark rounded">
                                    <h6 class="text-or mb-3 no d-none">Aucune sélection </h6>
                                    <div class="selected-variants-grid">
                                       
                                    </div>
                                </div>

                        <!-- Total et actions -->
                        <div class="d-flex justify-content-between align-items-center border-top-or pt-3">
                            @if($isInCart)
                                <button type="button" 
                        data-bs-dismiss="modal"
                        class="btn btn-outline-danger align-items-center hover-effect delete-item-btn"
                        data-item-id="{{ $itemId }}"
                        data-route="{{ route('client.cart.remove', $itemId) }}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                            @else
                                <div></div> 
                            @endif

                            <div class="text-end">
                                <span class="d-block text-white-50">Total :</span>
                                <strong class="text-or fs-5 totalArticle" data-base-price="{{ $article->base_price }}">
                                    {{ number_format($article->base_price * $quantity, 2) }} FCFA
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-4">
                    <div class="col-12">
                        <label class="text-or mb-2">Message personnalisé (optionnel)</label>
                        <textarea class="form-control text-white custom-message" rows="3" 
                                  placeholder="Ajoutez des instructions spéciales pour cet article..."></textarea>
                    </div>
                </div>
            </div>
            

            <div class="modal-footer border-top-or">
                @if($isInCart)
                    <button type="button" 
                        class="btn btn-orange w-100 update-cart-btn"
                        data-article-id="{{ $article->id }}"
                        data-original="Mettre à jour le panier"
                        data-item-id="{{ $itemId }}">
                        <i class="fas fa-sync-alt me-2"></i> Mettre à jour le panier
                    </button>
                @else
                    <button type="button" 
                        class="btn btn-orange w-100 add-to-cart-btn"
                        data-original="Ajouter au panier"
                        data-article-id="{{ $article->id }}">
                        <i class="fas fa-cart-plus me-2"></i> Ajouter au panier
                    </button>
                @endif
            </div>

            <!-- Total du panier -->
            <div class="modal-footer border-top-or d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="fas fa-shopping-cart me-2 text-or"></i>
                    <h5 class="mb-0">Total Panier :</h5>
                </div>
                <div>
                    <h5 class="mb-0 futuristic-input cart-total{{$article->id}}"  
                        data-total-price="{{ $cartData['total'] }}">
                        {{ number_format($cartData['total'], 2) }} FCFA
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>

<style>

    .border-or {
        border-color: var(--or-metallise) !important;
    }
    
    .text-or {
        color: var(--or-metallise);
    }
    

   
    .product-carousel {
        border: 1px solid var(--or-metallise);
        border-radius: 8px;
        overflow: hidden;
    }
    
    .carousel-control-prev, 
    .carousel-control-next {
        background-color: rgba(0, 0, 0, 0.3);
        width: 40px;
        height: 40px;
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
    }
    
  
    .variant-selector .text-or {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.75rem;
        display: block;
    }
    
   
    .variant-option:hover {
        background-color: rgba(255, 107, 0, 0.1);
    }
    
    .variant-option.active {
        background-color: var(--or-metallise);
        color: #121212;
        font-weight: 600;
    }
    
    .color-option {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .color-option:hover, 
    .color-option.active {
        transform: scale(1.1);
    }
    
    .color-option.active {
        border-color: #FFF;
        box-shadow: 0 0 0 2px var(--or-metallise);
    }
    

.variant-quantity-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background-color: var(--or-metallise);
    color: #121212;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    z-index: 111;
    font-size: 0.65rem;
    font-weight: bold;
    border: 2px solid #121212;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0 2px rgba(0,0,0,0.3);
}

    .selected-variants-display {
        border: 1px solid rgba(212, 175, 55, 0.3);
        display: block;
    }
    
    .selected-variants-grid {
        display: grid;
        gap: 0.75rem;
    }
    
    .variant-display {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
    }
    
    .variant-label {
        color: var(--or-metallise);
        font-weight: 500;
    }
    

    
    .variant-quantity {
        background: var(--or-metallise);
        color: #121212;
        border-radius: 4px;
        padding: 0 0.5rem;
        font-size: 0.8rem;
        font-weight: bold;
        margin-left: auto;
    }
    


    
  
    .custom-message {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid var(--or-metallise);
        color: white;
        resize: none;
    }
    
    .custom-message:focus {
        background: rgba(0, 0, 0, 0.4);
        border-color: var(--or-metallise);
        box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
    }

    .custom-message::placeholder{
        color:rgb(159, 159, 159);
    }
    

    @media (max-width: 768px) {
        
        .variant-selector .btn,
        .variant-selector .color-option {
            min-width: auto;
            border-radius: 12px;
        }
        
        .color-option {
            width: 30px;
            height: 30px;
        }
        
        .selected-variants-display {
            font-size: 14px;
        }
        
       

        .variant-selector{
            display: flex;
  justify-content: space-between;
        }
    }


    /* Pour l'overlay de SweetAlert2 */
.swal2-modal-overlay {
    z-index: 99999 !important;
}

.swal2-container-override {
    z-index: 100000 !important;
}



/* Animation pour le bouton */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.add-to-cart-btn, .update-cart-btn {
    transition: all 0.3s ease;
}

.add-to-cart-btn:hover, .update-cart-btn:hover {
    animation: pulse 1.5s infinite;
}


.variant-display,
.color-variant-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 10px;
    background-color:rgb(210, 210, 210);
    border: 1px solid var(--bs-dark);
    border-radius: 8px;
    margin-bottom: 8px;
    flex-wrap: wrap;
}

.variant-display .variant-label {
    font-weight: 600;
    margin-right: 4px;
    color: #333;

}

.variant-value {
    font-weight: 500;
    color: #555;
}

 .variant-quantity {
    background-color: #e9ecef;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 0.9em;
    color: #333;
}

.remove-variant-btn {
    margin-left: auto;
    padding: 2px 4px;
}

.color-variants-group {
    margin-top: 10px;
}

.color-variants-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 6px;
}

.color-variant-item {
    position: relative;
    flex-direction: row;
}

.color-preview {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 1px solid var(--or-metallise);
    display: inline-block;
}

@media (max-width: 600px) {
    

    .remove-variant-btn {
        margin-left: 0;
    }
}



</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
  
    document.querySelectorAll('.quantit-input').forEach(input => {
        const articleId = input.dataset.articleId;
        const initialValue = parseInt(input.dataset.initialValue);
        let currentValue = initialValue;
        
        input.value = currentValue;
     
           
           
        });
    });
    
  
</script>