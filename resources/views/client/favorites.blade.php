@extends('layouts.app')

@section('content')
<div class="favorites-page">

    <div class="favorites-hero py-5">
        <div class="container text-center d-flex justify-content-between align-items-center">
            <h1 class="display-4 fw-bold mb-3">Vos Favoris</h1>
            
                <div class="futur-btn btn  btn-danger">
                    <i class="fas fa-heart"></i>
                    <span>{{ $totalFavorites }} articles</span>
                
            </div>
        </div>
    </div>


    <div class="container py-5">
        @if($favorites->isEmpty())
            <div class="empty-favorites text-center mb-3">
                <div class="empty-icon mb-4">
                    <i class="fas fa-heart-broken"></i>
                </div>
                <h3>Votre liste de favoris est vide</h3>
                <p class="text-muted mb-4">Explorez notre collection et ajoutez vos articles préférés</p>
                <a href="{{ route('products') }}" class="btn futur-btn btn-primary">
                    <i class="fas fa-store me-2"></i> Voir les articles
                </a>
            </div>
        @else
            <div class="row g-4">
                @foreach($favorites as $favorite)
                    
                      
                            @include('partials.product', [
                                'article' => $favorite->article , 'id' => '2'
                            ])
                            
                           @include('modals.client.quick-view',['article' => $favorite->article]) 
                    
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $favorites->links() }}
            </div>
        @endif
    </div>
</div>
@endsection


<style>








.empty-icon {
    font-size: 3rem;
    color: var(--bs-danger);
    opacity: 1;
}

/* Animation pour la suppression */
@keyframes fadeOut {
    to { opacity: 0; height: 0; padding: 0; margin: 0; transform: scale(0); }
}

.favorite-removing {
    animation: fadeOut 0.5s ease forwards;
}
</style>


