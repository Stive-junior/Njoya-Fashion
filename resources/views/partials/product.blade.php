@php
        $user = Auth::user();
            $averageRating = $article->favorites->avg('rating') ?? 2; 
            $timeAgo = $article->created_at->diffForHumans();


            $isInCart = Auth::check() 
                    ? auth()->user()->panierItems()->where('article_id', $article->id)->exists()
                    : array_key_exists($article->id, Session::get('cart.items', []));
                
            $isFavorite = Auth::check() 
                    ? auth()->user()->favorites->contains('article_id', $article->id)
                    : false;

    if (isset($id)) {
    $carousel = "carousel-" . $article->id . "-" . $id;
} else {
    $carousel = "carousel-" . $article->id;
}


        @endphp
       
        <div class="col-12 col-md-6 col-lg-4 favorite-card">
                    <div class="card h-100 shadow-sm">
                       
                        
                        <!-- Carrousel d'images -->
                        <div id="{{ $carousel }}" class="carousel slide product-carousel">
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
                                <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carousel }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#{{ $carousel }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>

                                <!-- Indicateurs -->
                        <div class="carousel-indicators">
                            @foreach($article->images as $index => $image)
                                <button type="button" 
                                        data-bs-target="#{{ $carousel }}" 
                                        data-bs-slide-to="{{ $index }}" 
                                        class="{{ $index === 0 ? 'active' : '' }}"
                                        aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                            
                        </div>
                            @endif
                        </div>

                        <!-- Corps de la carte -->
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
        