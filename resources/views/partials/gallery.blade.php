<div class="gallery-item position-relative overflow-hidden rounded-3">
    <a href="{{ route('products') }}" class="d-block">
        @include('partials.product-image', ['article' => $article,'id' => '1'])

        <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3">
            <h5 class="text-white text mb-4">{{ $article->name }}</h5>
          
        </div>
    </a>
</div>

<style>
.gallery-item {
  
    transition: all 0.3s ease;
}
.gallery-item:hover {
    transform: scale(1.03);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
.gallery-item img {
    height: 100%;
    object-fit: cover;
}
.gallery-overlay {
    position: relative;
    background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 100%);
    opacity: 1;
    transition: opacity 0.3s ease;
}

.text,.price{
    opacity: 0;
}

.gallery-item:hover .text{

    opacity: 1;
    transition: opacity 0.3s ease-in-out;
}


.gallery-item:hover .price{
    opacity: 1;
    transition: opacity 0.3s ease-in;
}
</style>