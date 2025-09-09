@php

$averageRating = $article->favorites->avg('rating') ?? 2; 
            $timeAgo = $article->created_at->diffForHumans();


            $isInCart = Auth::check() 
                    ? auth()->user()->panierItems()->where('article_id', $article->id)->exists()
                    : array_key_exists($article->id, Session::get('cart.items', []));
                
            $isFavorite = Auth::check() 
                    ? auth()->user()->favorites->contains('article_id', $article->id)
                    : false;




        @endphp


<div class="modal fade futuristic-modal" id="articleModal{{ $article->id }}" tabindex="1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- En-tête du modal -->
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">{{ $article->name }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

           
            <div class="modal-body">
                <div class="row g-4">
                
                    <div class="col-12 col-lg-6">
                        @include('partials.product-image', ['article' => $article])
                    </div>

            
                    <div class="col-12 col-lg-6">
                        <h4 class="mb-3 ">{{ $article->base_price }} FCFA</h4>
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= round($averageRating) ? 'text-warning' : 'text-secondary' }}"></i>
                                @endfor
                            </div>
                            <small class="text-white">({{ number_format($averageRating, 1) }}/5)</small>
                        </div>
                        <p class="mb-0">Ajouté {{ $timeAgo }}</p>
                        <hr>
                        <p class="mb-4">{{ $article->description }}</p>




                        <div class="d-flex gap-2 justify-content-around">
@include('partials.boutonAdd', ['article' => $article])
                        

@if(Auth::check())
                            <button class="btn btn-icon futu-btn add-to-favorite"  title="{{ $isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris' }}" data-article-id="{{ $article->id }}" data-bs-dismiss="modal">
                                <i class=" {{ $isFavorite ? 'like' : '' }} fas fa-heart fa-lg text-hover-danger"></i>
                            </button>
                            @endif
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .futuristic-modal{
        color: var(--blanc-casse) !important;
    }
</style>