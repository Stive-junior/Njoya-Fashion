@extends('layouts.app')

@section('content')
<div class="container">
   
    <div class="subcategory-sticky bg-dark justify-content-between align-items-center">
        <h5 class="mx-2">{{ $category->name }} Pour {{ $category->parent->name }}</h5>
        <div class="d-flex justify-content-around flex-wrap" style="gap: 10px;">
            <div class="subcategory-item {{ !request()->subcategory ? 'active' : '' }}" data-subcategory="">
                <i class="fas fa-list"></i> Toutes
            </div>
            @foreach($subcategories as $subcategory)
                <a href="{{ request()->fullUrlWithQuery(['subcategory' => $subcategory->id]) }}"  class="subcategory-item {{ request()->subcategory == $subcategory->id ? 'active' : '' }}" 
                     >
                    <i class="fas fa-folder"></i> {{ $subcategory->name }}
</a>
            @endforeach
        </div>
    </div>

<div class="row g-4" id="articlesContainer">

    @if($articles->isEmpty())
        <div class="col-12 text-center py-5 no-articles">
            <div class="empty-state-animation">
                <i class="fas fa-box-open fa-4x mb-3"></i>
                <h4 class="text-white">Aucun article disponible</h4>
                <p class="text-whited">Revenez plus tard ou explorez nos autres catégories</p>

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
                    : array_key_exists($article->id, Session::get('cart.items', []));
                
            $isFavorite = Auth::check() 
                    ? auth()->user()->favorites->contains('article_id', $article->id)
                    : false;




        @endphp
        
        <div class="col-12 col-md-6 col-lg-4" data-subcategory="{{ $article->subcategory_id }}">
            <div class="card h-100 shadow-sm">
            
                <div id="carousel{{ $article->id }}" class="carousel slide product-carousel">
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
                      
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $article->id }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $article->id }}" data-bs-slide="next">
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
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">{{ $article->name }}</h5>
                        <div class="badge">{{ $article->base_price }} FCFA</div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="star-rating">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= round($averageRating) ? 'text-warning' : 'text-secondary' }}"></i>
                            @endfor
                            <small class="text-muted">({{ number_format($averageRating, 1) }})</small>
                        </div>
                        <small class="text-muted">{{ $timeAgo }}</small>
                    </div>

                    <p class="card-text text-truncate-3">{{ Str::limit($article->description, 1500) }}</p>

                   <div class="d-flex justify-content-around align-items-center border-top pt-3">
   
    <button class="btn btn-icon futu-btn" data-bs-toggle="modal" data-bs-target="#articleModal{{ $article->id }}">
        <i class="fas fa-expand-arrows-alt fa-lg "></i>
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
        @include('modals.client.quick-view',['article' => $article])
        


    @endforeach
      @endif
</div>
  
    <div class="d-flex justify-content-center mt-5">
        {{ $articles->links() }}
    </div>
</div>



<style>




.futur-btn {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.futur-btn::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300%;
    height: 300%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.2), transparent);
    transform: translate(-50%, -50%) scale(0);
    transition: transform 0.5s ease;
    border-radius: 50%;
}

.futur-btn:hover::before {
    transform: translate(-50%, -50%) scale(1);
}

.futur-btn:hover {
    border-color: var(--or-metallise);
    box-shadow: 0 0 15px rgba(212, 175, 55, 0.4);
    transform: translateY(-3px);
}

</style>



@endsection