@extends('layouts.app')

@section('content')


<div class="container py-5">





    <div class="row mb-4">
        <div class="col-12">



            <h1 class="text-center mb-4">{{ $pageTitle }}</h1>
        

                @if(!request()->has('search'))
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center gap-3">
                       
                        <div class="dropdown">
                            <button class="btn btn-dark futur-btn dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Catégorie
                            </button>
                            <ul class="dropdown-menu bg-white rounded-5" aria-labelledby="filterDropdown">
                                <li>
                                    <a href="{{ route('products') }}" class="dropdown-item">Toutes</a>
                                </li>
                                @foreach($categories as $category)
                                <li>
                                    <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['category' => $category->id]) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        
                     
                        <div class="dropdown">
                            <button class="btn btn-primary futur-btn dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Trier par
                            </button>
                            <ul class="dropdown-menu bg-white rounded-5" aria-labelledby="sortDropdown">
                                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Plus récents</a></li>
                                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}">Prix croissant</a></li>
                                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}">Prix décroissant</a></li>
                                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}">Plus populaires</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                @else
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                    
                            <a class="btn btn-primary futur-btn" type="button" href="{{ route('products') }}">
                                Toute
                                    </a>
                        </div>

                @endif
        </div>
    </div>

    <div class="row g-4" id="articlesContainer">
        @if($articles->isEmpty())
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
            @foreach($articles as $article)
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
                       
                        
                        <!-- Carrousel d'images -->
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


<style>
</style>



@endsection
