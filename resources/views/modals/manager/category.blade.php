<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Sélectionnez une catégorie</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="category-browser">
                    <div class="row g-3" id="mainCategoriesContainer">
                        @foreach($mainCategories as $category)
                        <div class="col-md-4">
                            <div class="category-card card h-100 border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="fas fa-folder fa-3x text-primary mb-3"></i>
                                    <h5>{{ $category->name }}</h5>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2 select-category" 
                                            data-id="{{ $category->id }}" data-name="{{ $category->name }}" data-level="1">
                                        Sélectionner
                                    </button>
                                    @if($category->children->isNotEmpty())
                                    <button type="button" class="btn btn-sm btn-primary mt-2 view-subcategories" 
                                            data-id="{{ $category->id }}">
                                        Voir les sous-catégories
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="subcategory-browser d-none mt-4">
                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3 back-to-main">
                        <i class="fas fa-arrow-left me-1"></i> Retour aux catégories principales
                    </button>
                    <div class="row g-3" id="subcategoriesContainer"></div>
                </div>
                
                <div class="final-category-browser d-none mt-4">
                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3 back-to-sub">
                        <i class="fas fa-arrow-left me-1"></i> Retour aux sous-catégories
                    </button>
                    <div class="row g-3" id="finalCategoriesContainer"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>