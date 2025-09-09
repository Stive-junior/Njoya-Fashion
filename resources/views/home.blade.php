

@extends('layouts.app')

@section('content')

 <div class="animated-icons">
        @foreach (['star', 'heart', 'circle', 'square', 'tshirt', 'hat-cowboy', 'socks', 'shoe-prints', 'glasses', 'ring', 'handbag', 'scarf', 'belt', 'watch', 'glove', 'umbrella', 'sunglasses', 'wallet', 'backpack', 'cap', 'coat', 'dress', 'jeans', 'shorts'] as $icon)
            <i class="fas fa-{{ $icon }}"></i>
        @endforeach
    </div>

<?php

use Illuminate\Support\Facades\Auth;

/** @var \App\Models\User|null $user */
$user = Auth::user();

$profilePicture = null;

if ($user && $user->profil) {
    $profilePicture = $user->profil->url;
}
?>


@auth
<section class="hero-section bg-or py-5 mx-5" style="padding-bottom: 10px !important; height:50rem;" data-scroll>
    <div class="container text-center">
        <div class="row d-flex align-items-center">

    <div class="welcome-avatar col-md-6">
                <img src="{{  $profilePicture ? asset('storage/' . $profilePicture) : asset('images/default-avatar.png')  }}" 
                     alt="{{ Auth::user()->name }}" 
                     class="rounded-circle img"
                   >
            </div>

        <div class="welcome-content col-md-6">
            <h1 class="display-4 fw-bold">Bienvenue, {{ Auth::user()->name }}!</h1>
            
            @php
                $gender = Auth::user()->sexe ?? null;
                $greeting = "Découvrez nos dernières collections";
                if ($gender === 'M') {
                    $greeting = "Explorez notre sélection masculine tendance";
                } elseif ($gender === 'F') {
                    $greeting = "Découvrez nos nouveautés féminines élégantes";
                }
            @endphp
            <p class="lead">{{ $greeting }}</p>
            <div class="mt-4">
                <a href="#Nouveau" class="btn btn-primary futur-btn me-2">Voir les nouveautés</a>
                @if($recommendedProducts->count() > 0)
                    <a href="#recommendations" class="btn btn-primary futur-btn">Vos recommandations</a>
                @endif
            </div>
        </div>
        </div>
    </div>
</section>
@endauth


<section class="hero-section py-5  my-5 " style="height: 40rem;" data-scroll>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 text-white" data-scroll>
                <h1 class="display-4 fw-bold mb-3 section-title">Njoya Boutique</h1>
                <h3 class="mb-4" >Élégance Redéfinie</h3>
                <p class="lead mb-4">"{{ $featuredProduct->description ?? 'Découvrez des pièces uniques pour un style inoubliable' }}"</p>
                @if($featuredProduct)
                <div data-scroll>
                    <a href="{{ route('products') }}" class="btn  btn-dark futur-btn px-4 mb-3">
                        <i class="fas fa-eye me-2"></i> Voir ce produit
                    </a>
                </div>
                @endif
            </div>
            <div class="col-lg-6" data-scroll>
                @include('partials.product-image', [
                    'article' => $featuredProduct ?? App\Models\Article::inRandomOrder()->first(),
                    'class' => 'featured-product-image'
                ])
            </div>
        </div>
    </div>
</section>

     <div id="Nouveau" class="mb-5"></div>
<div id="nouveautes" class="container hero-section py-5">
    <div class=" d-flex align-items-center  justify-content-between " data-scroll>
        <h1 class=" section-title display-4">Nos Nouveautés</h1>
        <a href="{{ route('products') }}" class="btn btn-dark futur-btn">Voir tout</a>
    </div>

    <div class="row g-4" id="articlesContainer">
        @if($newProducts->isEmpty())
            <div class="col-12 text-center py-1">
                <div class="empty-state">
                    <i class="fas fa-box-open fa-4x mb-3 text-warning"></i>
                    <h4 class="mb-3">Aucun produit trouvé</h4>
                    <p class="">Essayez de modifier vos critères de recherche</p>
                    <a href="{{ route('products') }}" class="btn btn-primary futur-btn mt-3">
                        Voir tous les produits
                    </a>
                </div>
            </div>
        @else
            @foreach($newProducts as $article)
                @php
                    $user = Auth::user();
                    $averageRating = $article->favorites->avg('rating') ?? 2;
                    $timeAgo = $article->created_at->diffForHumans();
                    
                    $isInCart = Auth::check() 
                        ? auth()->user()->panierItems()->where('article_id', $article->id)->exists()
                        : (Session::has('cart.items') && collect(Session::get('cart.items'))->contains('article_id', $article->id));
                    
                    $isFavorite = Auth::check() 
                        ? auth()->user()->favorites->contains('article_id', $article->id)
                        : false;
                @endphp
                
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                       
                        
                        
                        <div id="productCarousel{{ $article->id }}" class="carousel slide product-carousel">
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
                            
                            @if($article->images->count() > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel{{ $article->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel{{ $article->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                          
                        <div class="carousel-indicators">
                            @foreach($article->images as $index => $image)
                                <button type="button" 
                                        data-bs-target="#carousel{{ $article->id }}" 
                                        data-bs-slide-to="{{ $index }}" 
                                        class="{{ $index === 0 ? 'active' : '' }}"
                                        aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                            
                        </div>
                            @endif
                        </div>

               
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $article->name }}</h5>
                                <div>
                                    
                                        <div class="badge">{{ $article->base_price }} FCFA</div>
                                 
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="star-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= round($averageRating) ? 'text-warning' : 'text-secondary' }}"></i>
                                    @endfor
                                    <small class="text-muted">({{ number_format($averageRating, 1) }})</small>
                                </div>
                                <small class="text-muted">{{ $timeAgo }}</small>
                            </div>

                            <p class="card-text text-truncate-3">{{ Str::limit($article->description, 1500) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">
                                    <i class="fas fa-folder"></i> {{ $article->category->parent->name }}
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-store"></i> {{ $article->category->parent->parent->name ?? 'Boutique' }}
                                </small>
                            </div>

                            <div class="d-flex justify-content-around align-items-center border-top pt-3">
                                <button class="btn btn-icon futu-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-dismiss="modal"  data-bs-backdrop="static" data-bs-keyboard="false"
                                        data-bs-target="#articleModal{{ $article->id }}">
                                    <i class="fas fa-eye fa-lg"></i>
                                </button>
                                
                                @include('partials.boutonAdd', ['article' => $article])
                                
                                @if(Auth::check())
                                    <button class="btn btn-icon futu-btn add-to-favorite"  title="{{ $isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris' }}" data-article-id="{{ $article->id }}">
                                       <i class=" {{ $isFavorite ? 'like' : '' }} fas fa-heart fa-lg text-hover-danger"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @include('partials.cart-modal', ['article' => $article])
                </div>
                
                @include('modals.client.quick-view', ['article' => $article])
                
            @endforeach
        @endif
    </div>

   
                </div>



@auth
@if($recommendedProducts->count() > 0)
<section id="recommendations" class="container py-5">
    <div class="section-header d-flex justify-content-between align-items-center mb-5" data-scroll>
        <h2 class="section-title">Recommandations pour vous</h2>
        <a href="{{ route('articles.recommended') }}" class="btn futur-btn btn-dark">Voir tout</a>
    </div>
    <div class="row">
        @foreach($recommendedProducts as $product)
        <div class="col-md-6 col-lg-3 mb-4" data-scroll>
            @include('partials.product-card', ['article' => $product])
        </div>
        @endforeach
    </div>
</section>
@endif
@endauth

     <div id="Avis" class="mb-5"></div>
<section class="hero-section py-5 text-white">
    <div class="container">
        <h1 class="section-title mb-5 text-center">Avis Clients</h1>
        <div class="row">
           
@foreach (['Nana T.', 'Steve P.', 'Junior L.'] as $user)
                    <div class="col-md-4" data-scroll>
                        <div class="card hover-effect">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="{{ asset('images/image.jpg') }}" alt="{{ $user }}" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                                    <h4 class="card-title">{{ $user }}</h4>
                                </div>
                                <p class="text-dark">"Très satisfaite de mon achat, produit de qualité et livraison rapide !"</p>
                                <div class="rating text-start">
                                    @for ($i = 0; $i < 5; $i++)
                                        <i  class="fas fa-star text-black-50"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                @auth
                <div class="d-flex justify-content-center align-items-center mt-3">
                <a  href="{{ route('products') }}" class="btn btn-primary futur-btn">Soyez le premier à donner votre avis <i class="fas fa-comment-alt fa-2x"></i></a>
                </div>
                @endauth
            </div>
           
        </div>
    </div>
</section>

     <div id="Galerie" class="mb-5"></div>
<section class="hero-section container py-5">
    <div class="section-header d-flex justify-content-between align-items-center mb-5" data-scroll>
        <h1 class="section-title display-4">Notre Galerie</h1>
        @if($galleryProducts->count() > 0)
        <a href="{{ route('products') }}" class="btn btn-dark futur-btn">Voir toute la galerie</a>
        @endif
    </div>
    <div class="row g-3">
        @forelse($galleryProducts as $product)
        <div class="col-6 col-md-4 col-lg-3" data-scroll>
            @include('partials.gallery', ['article' => $product])
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <i class="fas fa-box-open fa-3x mb-3 text-muted"></i>
            <p class="text-muted">Aucun article pour le moment</p>
        </div>
        @endforelse
    </div>
</section>

     <div id="Livraison" class="mb-5"></div>
@include('partials.delivery-section')

     <div id="Contact" class="mb-5"></div>
@include('partials.contact-section')




<style>





.img{
width: 35rem;
  aspect-ratio: 1 / 1;
  height: 35rem;
}

</style>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/ScrollTrigger.min.js"></script>
  
@if($showSyncPrompt)

<script>
    
function generateItemsList(items, articles, articleImages) {
    return items.map(item => {
        const article = articles[item.article_id];
        const imageUrl = articleImages[item.article_id] || '/images/image.png';

        const variantHTML = renderVariants(item.variants || {}, item.quantity);
        const customMessage = item.custom_message 
            ? `<div class="mt-2 bg-dark  rounded"><strong>Message :</strong> ${item.custom_message}</div>` 
            : '';

        return `
            <div class="cart-item col-md-12 p-2 border-bottom d-flex justify-content-between align-items-start flex-wrap">
                <div class="d-flex col-md-8">
                    <div class="item-image me-3">
                        <img src="${imageUrl}" alt="${article.name}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                        <span class="item-quantity top-0">${item.quantity}</span>
                    </div>
                    <div class="item-details">
                        <h5 class="mb-1">${article.name}</h5>
                        <div class="item-price small">${article.base_price} FCFA × ${item.quantity}</div>
                        ${variantHTML}
                        ${customMessage}
                    </div>
                </div>
                <div class="item-total text-end fw-bold">
                    ${item.quantity * article.base_price} FCFA
                </div>
            </div>
        `;
    }).join('');
}


function renderVariants(variants, quantity) {
    if (!variants || Object.keys(variants).length === 0) return '';

    let html = '<ul class="list-unstyled mt-2 mb-0 small">';

    if (Array.isArray(variants.colors)) {
        html += `<li class="d-flex align-items-center mb-2">
                    <strong class="mb-2"></strong>`;
        variants.colors.forEach(color => {
            html += `
                <div class="d-flex align-items-center me-2">
                    <span class="d-inline-block rounded-circle me-1" 
                          style="width: 14px; height: 14px; background-color: ${color}; border: 1px solid #000"></span>
                </div>`;
        });
        html += `</li>`;
    } else if (variants.colors) {
        html += `
            <li class="d-flex align-items-center">
                <strong class="me-2"></strong>
                <span class="d-inline-block rounded-circle" 
                      style="width: 14px; height: 14px; background-color: ${variants.colors}; border: 1px solid #000"></span>
            </li>`;
    }

    if (variants.sizes) {
        html += `<li><strong></strong> ${variants.sizes}</li>`;
    }


    html += '</ul>';
    return html;
}


async function showSyncModal(isNewUser, cartItems, articles, cartTotal, currentCartCount) {
    const articleImages = <?= json_encode(
        collect($articles)->mapWithKeys(function ($article) {
            $imageUrl = (!empty($article->images) && count($article->images) > 0)
                ? asset('storage/' . $article->images[0]->url)
                : asset('images/image.png');
            return [$article->id => $imageUrl];
        })
    ) ?>;

    const itemsList = generateItemsList(cartItems, articles, articleImages);
    const hasExistingCart = currentCartCount > 0;


    const showModal = async () => {
        let replaceExisting = false;
        let shouldContinue = false;
        let finalDecision = null;

    
        const handleReplaceCheckbox = (e) => {
            replaceExisting = e.target.checked;
        };

        const { isConfirmed, isDenied, isDismissed } = await Swal.fire({
            icon: 'info',
            width: '40rem',
            padding: '1.5rem',
            backdrop: true,
            title: isNewUser ? 'Bienvenue Chez Nous!' : 'Synchronisation du panier',
            color: 'var(--primary-dark)',
            html: `
                <div class="text-start">
                    <p>${isNewUser 
                        ? 'Nous avons détecté un panier non enregistré :' 
                        : 'Votre panier visiteur contient :'}</p>

                    <div class="mb-3 bg-dark cart-items text-white" style="border-radius:15px; max-height: 300px; overflow-y: auto;">
                        ${itemsList}
                    </div>

                    <p class="fw-bold border-top pt-2">Total : ${cartTotal.toFixed(2)} FCFA</p>

                    ${hasExistingCart ? `
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="replaceExisting">
                        <label class="form-check-label" for="replaceExisting">
                            Remplacer mon panier actuel <a href="{{ route('cart') }}">(${currentCartCount} articles)</a>
                        </label>
                    </div>` : ''}

                    <p>Que souhaitez-vous faire ?</p>
                </div>
            `,
            showDenyButton: true,
            showCancelButton: true,
confirmButtonText: '<i class="fas fa-credit-card me-2"></i>Synchroniser et payer',
denyButtonText: '<i class="fas fa-sync-alt me-2"></i>Synchroniser seulement',
cancelButtonText: '<i class="fas fa-times-circle me-2"></i>Annuler',
            confirmButtonAriaLabel: 'Synchroniser et payer',
            denyButtonAriaLabel: 'Synchroniser seulement',
            cancelButtonAriaLabel: 'Annuler',

            focusConfirm: false,
            background: 'var(--blanc-casse)',
            customClass: {
                confirmButton: 'btn btn-success me-2',
                denyButton: 'btn btn-primary me-2',
                cancelButton: 'btn btn-secondary'
            },
            buttonsStyling: false,
            allowOutsideClick: false,
            didOpen: () => {
                const checkbox = document.getElementById('replaceExisting');
                if (checkbox) {
                    checkbox.addEventListener('change', handleReplaceCheckbox);
                }
            },
            willClose: () => {
                const checkbox = document.getElementById('replaceExisting');
                if (checkbox) {
                    checkbox.removeEventListener('change', handleReplaceCheckbox);
                }
            }
        });

        if (isDismissed) {
         
            try {
                await fetch('{{ route("cart.clearSession") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                
                await Swal.fire({
                    icon: 'info',
                    title: 'Annulé',
                    html: `<p class="text-center">Votre panier visiteur a été supprimé.</p>`,
                    background: 'var(--blanc-casse)',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-success'
                    },
                    allowOutsideClick: false
                });
                
                window.location.reload();
            } catch (error) {
                console.error('Error during cleanup:', error);
                window.location.reload();
            }
        } else if (isConfirmed || isDenied) {
            if (replaceExisting && hasExistingCart) {
                const { isConfirmed: replaceConfirmed } = await Swal.fire({
                    icon: 'warning',
                    title: 'Attention',
                    html: `
                        <div class="text-start">
                            <p>Vous êtes sur le point de remplacer votre panier actuel.</p>
                            <p class="fw-bold">Votre panier actuel contient ${currentCartCount} article(s).</p>
                            <p>Souhaitez-vous continuer ?</p>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Oui, remplacer',
                    cancelButtonText: 'Non, annuler',
                    background: 'var(--blanc-casse)',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    },
                    allowOutsideClick: false
                });

                if (!replaceConfirmed) {
 
                    return showModal();
                }
            }

            await showSyncProgress();
            await performRealSync(isConfirmed, replaceExisting);
        }
    };

  
    await showModal();
}


async function showSyncProgress() {
    return new Promise((resolve) => {
        Swal.fire({
            title: 'Traitement en cours',
            html: `
                <div class="text-center">
                    <div class="spinner-border text-primary mb-3" role="status"></div>
                    <p>Synchronisation du panier...</p>
                    <div class="swal2-progress-container progress mt-3" style="height: 10px;">
                        <div id="syncProgress" class="swal2-progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
            `,
            showConfirmButton: false,
            allowOutsideClick: false,
            willOpen: () => {

                let progress = 0;
                const bar = document.getElementById('syncProgress');

                const interval = setInterval(() => {
                    if (progress < 100) {
                        progress += 20;
                        if (bar) bar.style.width = `${progress}%`;
                    } else {
                        clearInterval(interval);
                        resolve();
                    }
                }, 200);
            }
        });
    });
}


async function performRealSync(proceedToCheckout, replaceExisting) {
    try {
       

        const response = await fetch('{{ route("cart.sync") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                replace_existing: replaceExisting,
                proceed_to_checkout: proceedToCheckout
            })
        });

        updateProgress(100);
        
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Erreur serveur');
        }

        const data = await response.json();
        updateProgress(100);

        await Swal.close();
        
        if (data.redirect) {

            updateProgress(1000);

            const paye = proceedToCheckout ? 'Passer la commande' : 'Voir le panier';

            await Swal.fire({
                icon: 'success',
                title: 'Succès',
                allowOutsideClick: false,
                text: data.message || 'Panier synchronisé avec succès',
                confirmButtonText: paye,
                willClose: () => {
                    window.location.href = data.redirect;
                }
            });


        } else {
            await Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: data.message || 'Panier synchronisé avec succès',
                confirmButtonText: 'Payer',
                willClose: () => {
                    window.location.reload();
                }
            });
        }
    } catch (error) {
        updateProgress(100);
        await Swal.close();
        handleSyncError(error);
    }
}

function updateProgress(percent) {
    const progressBar = document.getElementById('syncProgress');
    if (progressBar) {
        progressBar.style.width = `${percent}%`;
    }
}

function handleSyncError(error) {
    let errorMessage = 'Une erreur est survenue lors de la synchronisation';
    
    if (error.message) {
        errorMessage = error.message;
    } else if (error.statusText) {
        errorMessage = `${error.status} - ${error.statusText}`;
    }
    
    Swal.fire({
        icon: 'error',
        title: 'Erreur',
        text: errorMessage,
        confirmButtonText: 'OK'
        
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const sessionCartItems = <?= json_encode($sessionCart['items'] ?? []) ?>;
    const isNewUser = <?= json_encode($isNewUser ?? false) ?>;
    const articles = <?= json_encode($articles->keyBy('id')->toArray()) ?>;
    const cartTotal = <?= $sessionTotal ?>;
    const currentCartCount = <?= isset($cartData['items']) ? count($cartData['items']) : 0 ?>;
    const show = <?= $showSyncPrompt ?>

    if (sessionCartItems && sessionCartItems.length > 0 && show) {
        showSyncModal(
            isNewUser,
            sessionCartItems,
            articles,
            cartTotal,
            currentCartCount
        );
    }
});




</script>

@endif

@endsection
