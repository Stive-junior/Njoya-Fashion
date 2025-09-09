@extends('layouts.manager')

@section('content')
@include('layouts.navigation-manager', ['categories' => $categories])





<div class="container">



@if(isset($subCategory))
    <div class="subcategory-sticky bg-dark justify-content-between align-items-center mb-4">
        <h5 class="mx-2">{{ $subCategory->name }}</h5>
        <div class="d-flex justify-content-around flex-wrap" style="gap: 10px;">
            <a href="{{ request()->fullUrlWithQuery(['subsubcategory' => null, 'page' => null]) }}" 
               class="subcategory-item {{ !request()->has('subsubcategory') ? 'active' : '' }}">
                <i class="fas fa-list"></i> Toutes
            </a>
            @foreach($subCategory->children as $child)
                <a href="{{ request()->fullUrlWithQuery(['subsubcategory' => $child->id, 'page' => null]) }}" 
                   class="subcategory-item {{ request()->subsubcategory == $child->id ? 'active' : '' }}">
                    <i class="fas fa-folder"></i> {{ $child->name }}
                </a>
            @endforeach
        </div>
    </div>
@endif

    <div class="mb-4 mt-4">
        <h1 class="text-center mb-4">{{ $pageTitle }}</h1>

        <div class=" d-flex justify-content-between align-items-center col-md-12">
            <div class="col-md-5">
              
                @if(!request()->has('search'))
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="d-flex align-items-center gap-3">
                       
                        <div class="dropdown">
                            <button class="btn btn-dark futur-btn dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Catégorie
                            </button>
                            <ul class="dropdown-menu bg-white rounded-5" aria-labelledby="filterDropdown">
                                <li>
                                    <a href="{{ route('manager.products.index') }}" class="dropdown-item">Toutes</a>
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
                    
                            <a class="btn btn-primary futur-btn" type="button" href="{{ route('manager.products.index') }}">
                                Toute
                                    </a>
                        </div>

                @endif

            </div>

            <div class="col-md-2 text-end">
                <a href="{{ route('manager.products.create') }}" class="btn btn-primary futur-btn">
                    <i class="fas fa-plus me-2"></i> Ajouter un produit
                </a>
            </div>
        </div>
    </div>

 
    <div class="row g-4" id="articlesContainer">
        @if($articles->isEmpty())
            <div class="col-12 text-center py-1">
                <div class="empty-state">
                    <i class="fas fa-box-open fa-4x mb-3 text-warning"></i>
                    <h4 class="mb-3">Aucun produit trouvé</h4>
                    <p class="mb-3">Essayez de modifier vos critères de recherche</p>
                    <a href="{{ route('manager.products.create') }}" class="btn btn-primary futur-btn">
                        Ajouter des produits
                    </a>
                </div>
            </div>
        @else
            @foreach($articles as $article)
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
                                                data-bs-target="#productCarousel{{ $article->id }}" 
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
        <div class="badge bg-dark text-white">{{ number_format($article->base_price, 2) }} FCFA</div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="star-rating">
            @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star {{ $i <= round($article->reviews->avg('rating') ?? 2) ? 'text-warning' : 'text-secondary' }}"></i>
            @endfor
            <small class="text-muted">({{ number_format($article->reviews->avg('rating') ?? 2, 1) }})</small>
        </div>
        <small class="text-muted">{{ $article->created_at->diffForHumans() }}</small>
    </div>

    <p class="card-text text-truncate-3">{{ Str::limit($article->description, 1500) }}</p>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <small class="text-dark" style="font-size: 18px;">
            <i class="fas fa-folder"></i> {{ $article->category->parent->parent->name ?? 'Non catégorisé' }} - {{ $article->category->parent->name }} - {{ $article->category->name }}
        </small>
        <small class="text-muted">
            <i class="fas fa-shopping-bag"></i> {{ $article->orderItems->count() }}
        </small>
    </div>



    <div class="d-flex justify-content-around align-items-center border-top pt-3">
        <a href="{{ route('manager.products.edit', $article) }}" class="btn btn-icon futu-btn" title="Modifier">
            <i class="fas fa-edit fa-lg"></i>
        </a>
        
        <button class="btn btn-icon futu-btn delete-product" 
        data-article-id="{{ $article->id }}"
        data-article-name="{{ $article->name }}"
        data-route="{{ route('manager.products.destroy', $article->id) }}"
        title="Supprimer">
    <i class="fas fa-trash fa-lg text-hover-danger"></i>
</button>

        <button class="btn btn-sm btn-icon futu-btn" title="Partager l'article"
            onclick="shareProductCarousel('{{ $article }}')">
        <i class="fas fa-share-alt fa-lg"></i>
        </button>


    </div>
</div>

                    </div>
                </div>

                
            @endforeach
        @endif
    </div>


@include('partials.delete-article')


<style>

    
.subcategory-sticky {
    position: sticky;
    top: 0;
    padding: 10px;
    z-index: 1;
    display: flex;
    border-radius: 0 0 20px 20px;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.subcategory-item {
    padding: 10px 15px;
    background-color: var(--gris-anthracite);
    border: 1px solid var(--or-metallise);
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    color: var(--blanc-casse);
    text-decoration: none;
}

.subcategory-item:hover {
    background-color: var(--or-metallise);
    color: var(--noir-profond);
}

.subcategory-item.active {
    background-color: var(--or-metallise);
    color: var(--noir-profond);
    border-color: var(--or-metallise);
}

.empty-state {
    text-align: center;
    padding: 2rem;
}

.text-truncate-3 {
    display: -webkit-box;
    -webkit-text-fill-color: #dc3545;
    -webkit-box-orient: vertical;
    overflow: hidden;
}



.futu-btn:hover {
    transform: scale(1.1);
    background: rgba(255, 255, 255, 0.2);
}

.text-hover-danger:hover {
    color: #dc3545 !important;
}
</style>



@endsection