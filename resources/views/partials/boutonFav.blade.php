@if(Auth::check())
                            <button class="btn btn-icon futu-btn add-to-favorite"  title="{{ $isFavorite ? 'Retirer des favoris' : 'Ajouter aux favoris' }}" data-article-id="{{ $id }}">
                                <i class=" {{ $isFavorite ? 'like' : '' }} fas fa-heart fa-lg text-hover-danger"></i>
                            </button>
@endif