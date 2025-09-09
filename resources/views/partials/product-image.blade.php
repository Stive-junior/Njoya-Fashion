@php
$images = null;
$carousel = '';
$hasMultiple = false;
$hasImages = false;

if(isset($article)) {
    $images = $article->images ?? collect();
    $hasImages = $images->isNotEmpty();
    
    if ($hasImages) {
        $hasMultiple = $images->count() > 1;
    }

    $carousel = isset($id) 
        ? "carousel-{$article->id}-{$id}" 
        : "carousel-{$article->id}";
}
@endphp

<div id="{{ $carousel }}" class="carousel slide product-carousel" data-bs-ride="{{ $hasMultiple ? 'carousel' : 'false' }}" style="border-radius: 2%;">
    <div class="carousel-inner ratio ratio-1x1">
        @unless($hasImages)
            <div class="carousel-item active">
                <img src="{{ asset('images/image.png') }}" 
                     class="d-block w-100 img-cover" 
                     alt="{{ $article->name ?? 'Image par défaut' }}">
            </div>
        @else
            @foreach($images as $index => $image)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $image->url) }}" 
                         class="d-block w-100 img-cover" 
                         alt="{{ $article->name ?? 'Image produit' }}"
                         loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                </div>
            @endforeach
        @endunless
    </div>

    @if($hasMultiple && $hasImages)
        <button class="carousel-control-prev" type="button" data-bs-target="#{{ $carousel }}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#{{ $carousel }}" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>

        <div class="carousel-indicators">
            @foreach($images as $index => $image)
                <button type="button" 
                        data-bs-target="#{{ $carousel }}" 
                        data-bs-slide-to="{{ $index }}" 
                        class="{{ $index === 0 ? 'active' : '' }}"
                        aria-label="Slide {{ $index + 1 }}">
                </button>
            @endforeach
        </div>
    @endif

    @isset($article->base_price)
        <div class="price">
            <div class="badge">{{ $article->base_price }} FCFA</div>
        </div>
    @endisset
</div>

<style>
.price {
    opacity: 0;
    transition: opacity 0.3s ease-in;
}

.carousel:hover .price {
    opacity: 1;
}
</style>
