@extends('layouts.manager')

@section('content')
@include('layouts.navigation-manager', ['categories' => $mainCategories])

<div class="container-fluid py-4 create">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0 glass-effect">
                <div class="card-header bg-gradient-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i>Création d'un nouveau produit
                    </h4>
                </div>
                <div class="card-body bg-soft-ligh">
                    <!-- Indicateur d'étapes -->
                    <ul class="nav nav-pills text-white nav-fill mb-5" id="progressSteps">
                        <li class="nav-item">
                            <a class="nav-lin active" id="step1-tab" data-bs-toggle="pill" href="#step1">
                                <i class="fas fa-info-circle me-2"></i>Informations de base
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-lin disabled" id="step2-tab" data-bs-toggle="pill" href="#step2">
                                <i class="fas fa-layer-group me-2"></i>Catégorie
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-lin disabled" id="step3-tab" data-bs-toggle="pill" href="#step3">
                                <i class="fas fa-palette me-2"></i>Variantes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-lin disabled" id="step4-tab" data-bs-toggle="pill" href="#step4">
                                <i class="fas fa-images me-2"></i>Images
                            </a>
                        </li>
                    </ul>

                    <form id="productForm" action="{{ route('manager.products.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        
                        <div class="tab-content">
                            <!-- Étape 1: Informations de base -->
                            <div class="tab-pane fade show active" id="step1">
                                <div class="row">
                                    <div class="col-md-8 mx-auto">
                                        <div class="card border-0 shadow-sm bg-blur">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="mb-0">Informations de base</h5>
                                            </div>
                                            <div class="card-body">
                                                <!-- Nom du produit -->
                                                <div class="mb-4">
                                                    <label for="name" class="form-label fw-bold">Nom du produit <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-lg" 
                                                           id="name" name="name" required
                                                           placeholder="Ex: T-shirt en coton">
                                                    <div class="invalid-feedback">Veuillez entrer un nom de produit valide.</div>
                                                </div>
                                                
                                                <!-- Prix de base -->
                                                <div class="mb-4">
                                                    <label class="form-label fw-bold">Prix de base (FCFA) <span class="text-danger">*</span></label>
                                                    <div class="input-group has-validation">
                                                        <span class="input-group-text bg-primary text-white">
                                                            <i class="fas fa-money-bill-wave"></i>
                                                        </span>
                                                        <input type="number" step="100" 
                                                               class="form-control form-control-lg price-input" 
                                                               id="base_price" name="base_price" 
                                                               min="100" max="1000000" required
                                                               placeholder="100" value="100">
                                                        <button type="button" class="btn btn-primary price-increment">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-primary price-decrement">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <div class="invalid-feedback">Le prix doit être entre 100 et 1.000.000 FCFA.</div>
                                                    </div>
                                                    <small class="text-muted" id="priceHelp">Prix actuel: <span id="priceDisplay">100</span> FCFA</small>
                                                </div>
                                                
                                                <!-- Description -->
                                                <div class="mb-4">
                                                    <label for="description" class="form-label fw-bold">Description</label>
                                                    <textarea class="form-control" 
                                                              id="description" name="description" 
                                                              rows="5" maxlength="1000"
                                                              placeholder="Décrivez le produit en détail..."></textarea>
                                                    <small class="text-muted"><span id="charCount">0</span>/1000 caractères</small>
                                                </div>
                                                
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="{{ route('manager.products.index') }}" class="btn btn-secondary btn-lg">
                                        <i class="fas fa-arrow-left me-2"></i> Annuler
                                    </a>
                                    <button type="button" class="btn btn-primary btn-lg next-step" data-next="step2">
                                        Suivant <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Étape 2: Catégorie -->
                            <div class="tab-pane fade" id="step2">
                                <div class="row">
                                    <div class="col-md-10 mx-auto">
                                        <div class="card border-0 shadow-sm bg-blur">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="mb-0">Sélection de la catégorie</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="alert alert-secondary d-flex align-items-center" style="background-color: var(--or); border:2px solid var(--or-metallise)" id="categorySelectionDisplay">
                                                        <i class="fas fa-folder-open  fs-4 me-2"></i>
                                                        <span id="categoryPath" class="fw-bold">Aucune catégorie sélectionnée</span>
                                                    </div>
                                                
                                                <div class="category-selection-steps">
                                                    
                                                    <!-- Étape 1: Catégorie principale -->
                                                    <div class="mb-5" id="mainCategoryStep">
                                                        <h5 class="fw-bold mb-4 text-bold">1. Sélectionnez une catégorie principale</h5>
                                                        <div class="row g-3">
                                                            @foreach($mainCategories as $category)
                                                            <div class="col-md-4">
                                                                <div class="category-card card h-100 border-0 shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <i class="{{ getCategoryIcon($category->name) }} fa-3x mb-3"></i>
                                                                        <h5>{{ $category->name }}</h5>
                                                                        
                                                                       @if($category->children->isNotEmpty())
                                                                        <button type="button" class="btn btn-sm btn-primary mt-2 select-main-category view-subcategories" 
                                                                                data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                                                        Select
                                                                        </button>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    
                                               
                                                    <div class="mb-5 d-none" id="subCategoryStep">
                                                    <div class="d-flex justify-content-between align-items-center">    
                                                    <h5 class="fw-bold mb-4">2. Sélectionnez une sous-catégorie</h5>
                                                        <button type="button" class="btn btn-sm btn-success mb-4 back-to-main">
                                                            <i class="fas fa-arrow-left me-1"></i> Retour aux catégories principales
                                                        </button>
                                                    </div>

                                                        <div class="row g-3" id="subCategoriesContainer"></div>
                                                    </div>
                                                    
                                                  
                                                    <div class="mb-4 d-none" id="finalCategoryStep">
                                                           <div class="d-flex justify-content-between align-items-center">  
                                                        <h5 class="fw-bold mb-4 ">3. Sélectionnez une catégorie spécifique</h5>
                                                        <button type="button" class="btn btn-sm btn-success mb-4 back-to-sub">
                                                            <i class="fas fa-arrow-left me-1"></i> Retour aux sous-catégories
                                                        </button>
                                                        </div>
                                                        <div class="row g-3" id="finalCategoriesContainer"></div>
                                                    </div>
                                                    
                                                    
                                                    <input type="hidden" name="category_id" id="selectedCategoryId" required>
                                                    <div class="invalid-feedback">Veuillez sélectionner une catégorie.</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary btn-lg prev-step" data-prev="step1">
                                        <i class="fas fa-arrow-left me-2"></i> Précédent
                                    </button>
                                    <button type="button" class="btn btn-primary btn-lg next-step" data-next="step3" id="nextToVariants" disabled>
                                        Suivant <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Étape 3: Variantes -->
                            <div class="tab-pane fade" id="step3">
                                <div class="row">
                                    <div class="col-md-10 mx-auto">
                                        <div class="card border-0 shadow-sm bg-blur">
                                            <div class="card-header text-white d-flex justify-content-between">
                                                <h5 class="mb-0">Configuration des variantes</h5>
                                                <p class="mb-0 text-bold">Catégorie: <span id="variantCategoryName"></span></p>
                                            </div>
                                            <div class="card-body">
                                                <div id="variantConfiguration">
                                                    <!-- Les options de variantes seront chargées dynamiquement ici -->
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-info-circle me-2"></i>
                                                        Veuillez d'abord sélectionner une catégorie pour configurer les variantes
                                                    </div>
                                                </div>
                                                
                                                <div id="variantsContainer" class="mt-4">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover align-middle" id="variantsTable">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th width="5%">N*</th>
                                                                    <th width="25%">Tailles</th>
                                                                    <th width="30%">Couleurs</th>
                                                                    <th width="25%">Matériaux</th>
                                                                    <th width="15%">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="5" class="text-center text-muted py-4">
                                                                        <i class="fas fa-info-circle me-2"></i>
                                                                        Aucune variante ajoutée pour le moment
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary btn-lg prev-step" data-prev="step2">
                                        <i class="fas fa-arrow-left me-2"></i> Précédent
                                    </button>
                                    <button type="button" class="btn btn-primary btn-lg next-step" data-next="step4" id="nextToImages" disabled>
                                        Suivant <i class="fas fa-arrow-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Étape 4: Images -->
                            <div class="tab-pane fade" id="step4">
                                <div class="row">
                                    <div class="col-md-8 mx-auto">
                                        <div class="card border-0 shadow-sm bg-blur">
                                            <div class="card-header bg-primary text-white">
                                                <h5 class="mb-0">Images du produit</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold">Images du produit <span class="text-danger">*</span></label>
                                                    <div class="image-upload-frame mb-3 position-relative">
                                                        <label for="images" class="upload-label w-100 h-10 cursor-pointer">
                                                            <div class="upload-icon-container d-flex flex-column align-items-center justify-content-center py-5">
                                                                <i class="fas fa-camera fa-3x mb-3 text-primary"></i>
                                                                <span class="text-muted">Glissez-déposez ou cliquez pour ajouter des photos</span>
                                                            </div>
                                                            <input type="file" id="images" name="images[]" 
                                                                   class="file-input position-absolute opacity-0" multiple accept="image/*" required>
                                                        </label>
                                                        <small class="text-danger position-absolute start-0 bottom-0 d-none" id="imageError">Veuillez ajouter au moins une image.</small>
                                                    </div>
                                                    <div class="image-preview-grid row g-2" id="imagePreview"></div>
                                                </div>
                                                
                                                <!-- Aperçu des données -->
                                                <div class="card border-primary mt-4">
                                                    <div class="card-header bg-primary text-white">
                                                        <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Aperçu du produit</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <h6>Informations de base</h6>
                                                                <ul class="list-group list-group-flush">
                                                                    <li class="list-group-item d-flex justify-content-between">
                                                                        <span>Nom:</span>
                                                                        <span id="preview-name" class="fw-bold">-</span>
                                                                    </li>
                                                                    <li class="list-group-item d-flex justify-content-between">
                                                                        <span>Prix:</span>
                                                                        <span id="preview-price" class="fw-bold">-</span>
                                                                    </li>
                                                                   
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-6">
                <h6>Catégorie & Images</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <span id="preview-category">Aucune catégorie sélectionnée</span>
                        
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Images:</span>
                        <span id="preview-image-count" class="fw-bold">0</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">ID categorie:
<span id="preview-category-id" class=" font-bold">Aucune catégorie sélectionnée</span>
                    </li>
                </ul>
            </div>
                                                        </div>
                                                        
                                                        <div class="mt-4">
                                                            <h6>Variantes</h6>
                                                            <div class="table-responsive">
                                                                <table class="table table-sm" id="preview-variants">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Tailles</th>
                                                                            <th>Couleurs</th>
                                                                            <th>Matériaux</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td colspan="3" class="text-center text-muted">Aucune variante ajoutée</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary btn-lg prev-step" data-prev="step3">
                                        <i class="fas fa-arrow-left me-2"></i> Précédent
                                    </button>
                                    <button type="submit" class="btn btn-success btn-lg" id="submitBtn">
                                        <i class="fas fa-save me-2"></i> Créer le produit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template pour les variantes -->
 
<template id="variantTemplate">
    <tr class="variant-item">
        <td class="variant-number fw-bold"></td>
        <td class="variant-sizes"></td>
        <td class="variant-colors">
            <div class="d-flex flex-wrap gap-2 align-items-center"></div>
        </td>
        <td class="variant-materials"></td>
        <td>
            <button type="button" class="btn btn-sm btn-danger remove-variant">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    </tr>
</template>

<style>
/* Variables CSS */
:root {
  --primary-color:#f8961e;
  --primary-dark:rgb(163, 130, 12);
  --primary-light: #4895ef;
  --secondary-color: #f72585;
  --success-color: #4cc9f0;
  --warning-color: #f8961e;
  --danger-color: #ef233c;
  --dark-color: #2b2d42;
  --light-color: #f8f9fa;
  --glass-opacity: 0.2;
  --blur-intensity: 12px;
}


.create .nav-item{
    background-color:rgba(25, 25, 25, 0.69) !important;
}




.category-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

#progressSteps{
    padding: 12px;
  border-radius: 12px;
  background-color: var(--light-color);

}


#progressSteps .nav-item {
    background-color: rgba(25, 25, 25, 0.69);
    margin: 0 5px;
    border-radius: 8px;
}

#progressSteps .nav-link {
    color: white;
    padding: 10px 15px;
    border-radius: 8px;
}

#progressSteps .nav-link.active {
    background-color: var(--primary-color);
    font-weight: bold;
}

#progressSteps .nav-link.disabled {
    opacity: 0.6;
    cursor: not-allowed;
}


.category-card .btn {
    transition: all 0.3s ease;
}



.variant-config-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background-color: rgba(255, 255, 255, 0.7);
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.color-picker {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
}

.color-option {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0;
    transition: all 0.3s ease;
}

.color-option.selected {
    border-color: var(--primary-color);
    transform: scale(1.1);
    font-size: 14px;
}

.color-option i {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.color-option.selected i {
    opacity: 1;
}

.custom-color-input {
    display: flex;
    align-items: center;
    margin-top: 15px;
}

.custom-color-input input[type="color"] {
    width: 40px;
    height: 40px;
    border: none;
    margin-right: 10px;
    border-radius: 50%;
    cursor: pointer;
}

.custom-color-input input[type="text"] {
    flex: 1;
    border-radius: 20px;
    padding: 8px 15px;
    border: 1px solid #dee2e6;
}

.glass-effect {
  background: rgba(255, 255, 255, 0.51);
  backdrop-filter: blur(var(--blur-intensity));
  -webkit-backdrop-filter: blur(var(--blur-intensity));
  border-radius: 16px;
  border: 1px solid rgba(195, 34, 34, 0.2);
  box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
}

.bg-blur {
  background: transparent;
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  box-shadow: 2px 5px 4px var(--bs-dark) !important;
}


.card-header {
  border-radius: 12px 12px 0 0 !important;
  background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
}

.image-upload-frame {
    border: 2px dashed #4361ee;
    border-radius: 12px;
    padding: 2rem;
    text-align: center;
    background-color: rgba(67, 97, 238, 0.05);
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.image-upload-frame.dragover {
    background-color: rgba(67, 97, 238, 0.1);
    border-color: #3a0ca3;
}

.upload-label {
    display: block;
    cursor: pointer;
}

.upload-icon-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #4361ee;
    transition: all 0.3s ease;
}

.image-upload-frame:hover .upload-icon-container {
    transform: scale(1.05);
}

.upload-icon-container i {
    margin-bottom: 1rem;
}

.upload-icon-container span {
    font-weight: 500;
}

/* Style pour l'aperçu des images */
.image-preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.image-preview-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    aspect-ratio: 1/1;
}

.image-preview-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.image-preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(239, 35, 60, 0.9);
    color: white;
    border: none;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.image-preview-item:hover .remove-image {
    opacity: 1;
}

/* Variantes */
.variant-item {
  transition: all 0.3s ease;
}

.variant-item:hover {
  background-color: rgba(67, 97, 238, 0.05);
}

.color-badge {
    display: inline-block;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 1px solid #dee2e6;
    vertical-align: middle;
    box-shadow: 0 2px 3px rgba(0,0,0,0.1);
}

/* Boutons */
.btn {
  border-radius: 10px;
  font-weight: 600;
  letter-spacing: 0.5px;
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  padding: 0.6rem 1.2rem;
  border: none;
}

.btn-lg {
  padding: 0.8rem 1.8rem;
  font-size: 1.1rem;
  border-radius: 12px;
}

.btn-primary {
  background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
  box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
}

.btn-danger {
  background: linear-gradient(135deg, var(--danger-color) 0%, #c1121f 100%);
  box-shadow: 0 4px 12px rgba(239, 35, 60, 0.3);
}

.btn-danger:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(239, 35, 60, 0.4);
}

/* Formulaires */
.form-control {
  border: 1px solid #e0e0e0;
  border-radius: 10px;
  padding: 0.75rem 1rem;
  transition: all 0.3s ease;
}

.form-control:focus {
  border-color: var(--primary-color);
  box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
}

.was-validated .form-control:invalid,
.was-validated .form-control:invalid:focus {
  border-color: #dc3545;
  box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
}

.was-validated .form-control:valid,
.was-validated .form-control:valid:focus {
  border-color: #198754;
  box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
}

/* Responsive */
@media (max-width: 992px) {
  .glass-effect {
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
  }
  
  .card-header h4 {
    font-size: 1.4rem;
  }
}

@media (max-width: 768px) {
  .image-upload-frame {
    padding: 1.5rem;
  }
  
  .variant-item .card-body {
    padding: 1rem;
  }
  
  .variant-item .row > div {
    margin-bottom: 0.5rem;
  }
}

@media (max-width: 576px) {
  .btn-lg {
    padding: 0.7rem 1.2rem;
    font-size: 1rem;
  }
  
  .form-control {
    padding: 0.6rem 0.8rem;
  }
}
</style>

<script>

    let selectedCategory = null;
let variantIndex = 0;
let selectedColors = ['#000000'];

function setupEventListeners() {

    document.querySelectorAll('.next-step').forEach(btn => {
        btn.addEventListener('click', function() {
            goToStep(this.dataset.next);
        });
    });
    
    document.querySelectorAll('.prev-step').forEach(btn => {
        btn.addEventListener('click', function() {
            const tab = new bootstrap.Tab(document.querySelector(`#${this.dataset.prev}-tab`));
            tab.show();
        });
    });
    

    document.getElementById('name').addEventListener('input', function() {
        validateFormStep(1, true);
        updatePreview();
    });
    
    document.getElementById('base_price').addEventListener('input', function() {
        validateFormStep(1, true);
        updatePreview();
    });
    

    document.getElementById('images').addEventListener('change', function() {

        updatePreview();
    });

}


function getCategoryIcon(categoryName) {
    const iconMap = {

 
    'Homme': 'fas fa-male',
    'Femme': 'fas fa-female',
    'Enfant': 'fas fa-child',
    'Durable': 'fas fa-leaf',
    'Collaborations': 'fas fa-handshake',

    'Vêtements': 'fas fa-tshirt',
    'Chaussures': 'fas fa-shoe-prints',
    'Accessoires': 'bx bx-shopping-bag',
    'Sport': 'fas fa-running',
    'Équipement outdoor': 'fas fa-mountain',
    'Lingerie': 'fas fa-tshirt',
    'Maillots de bain': 'fas fa-person-swimming',
    'Haute Couture': 'fas fa-crown', 
    'École': 'fas fa-school',

  
    'Vestes': 'fas fa-user-tie', 
    'Hauts': 'fas fa-tshirt',
    'Pantalons': 'fas fa-user', 
    'Robes': 'fas fa-person-dress', 
    'Jupes': 'fas fa-person-dress', 
    'T-shirts': 'fas fa-tshirt',
    'Chemises': 'fas fa-shirt',
    'Pulls': 'fas fa-sweater',
    'Blazers': 'fas fa-user-tie',
    'Vestes en cuir': 'fas fa-jacket',
    'Short de sport': 'fas fa-running',

    'Chaussures de ville': 'fas fa-shoe-prints',
    'Tennis': 'fas fa-person-running',
    'Sandales': 'bx bx-walk',
    'Escarpins': 'fas fa-shoe-prints', 
    'Baskets': 'fas fa-shoe-prints',
    'Bottes': 'fas fa-shoe-prints', 
    'Talons': 'fas fa-shoe-prints', 

    
    'Montres': 'fas fa-clock',
    'Parfums': 'fas fa-spray-can',
    'Ceintures': 'fas fa-grip-lines',
    'Chapeaux': 'fas fa-hat-cowboy',
    'Cravates': 'fas fa-user-tie',
    'Portefeuilles': 'fas fa-wallet',
    'Bijoux': 'fas fa-gem',
    'Sacs': 'fas fa-shopping-bag',
    'Écharpes': 'fas fa-mitten',
    'Lunettes': 'fas fa-glasses',
    'Colliers': 'fas fa-gem',
    'Bracelets': 'fas fa-gem',
    'Techwear': 'fas fa-microchip',

};
    
 
    if (iconMap[categoryName]) {
        return iconMap[categoryName];
    }
    
   
    const lowerName = categoryName.toLowerCase();
    for (const [key, value] of Object.entries(iconMap)) {
        if (lowerName.includes(key.toLowerCase())) {
            return value;
        }
    }
    
    
    return 'fas fa-tag';
}



function validateFormStep(step, silent = false) {
    switch(step) {
        case 1:
            return validateStep1(silent);
        case 2:
            return validateStep2(silent);
        case 3:
            return validateStep3(silent);
        case 4:
            return validateStep4(silent);
        default:
            return false;
    }
}

// Validation Étape 1 - Informations de base
function validateStep1(silent = false) {
    const name = document.getElementById('name').value.trim();
    const price = document.getElementById('base_price').value;
    let isValid = true;

  
    if (!name) {
        if (!silent) {
            showValidationError('name', 'Un nom de produit valide (3 caractères minimum) est requis');
        }
        isValid = false;
    } else {
        clearValidationError('name');
    }

 
    if (!price || isNaN(price) || price < 100 || price > 1000000) {
        if (!silent) {
            showValidationError('base_price', 'Veuillez entrer un prix valide entre 100 et 1.000.000 FCFA');
        }
        isValid = false;
    } else {
        clearValidationError('base_price');
    }

    return isValid;
}


function validateStep2(silent = false) {
    

    categoryId = document.getElementById('selectedCategoryId').value;
    if (!categoryId) {
        if (!silent) {
            showValidationError('selectedCategoryId', 'Veuillez sélectionner une catégorie pour votre produit');
        }
        return false;
    }
    
    clearValidationError('selectedCategoryId');
    return true;
}

function validateStep3(silent = false) {
    const variantItems = document.querySelectorAll('.variant-item');
    
    if (variantItems.length === 0) {
        if (!silent) {
            Swal.fire({
                icon: 'error',
                title: 'Variantes manquantes',
                text: 'Veuillez ajouter au moins une variante pour votre produit',
                scrollbarPadding: false
            });
        }
        return false;
    }


    let allVariantsValid = true;
    variantItems.forEach(item => {
        const sizes = item.querySelector('.variant-sizes').textContent.trim();
        const colors = item.querySelectorAll('.color-badge').length;
        
        if (!sizes || colors === 0) {
            allVariantsValid = false;
        }
    });

    if (!allVariantsValid && !silent) {
        Swal.fire({
            icon: 'error',
            title: 'Variantes incomplètes',
            text: 'Toutes les variantes doivent avoir au moins une taille et une couleur',
            scrollbarPadding: false
        });
    }

    return allVariantsValid;
}


function validateStep4(silent = false) {
    const imageCount = document.getElementById('imagePreview').children.length;
    const fileInput = document.getElementById('images');
    const files = fileInput.files;
    
    if (imageCount === 0 && (!files || files.length === 0)) {
        if (!silent) {
            showValidationError('images', 'Veuillez ajouter au moins une image pour le produit');
            document.getElementById('imageError').classList.remove('d-none');
        }
        return false;
    }
    
    clearValidationError('images');
    document.getElementById('imageError').classList.add('d-none');
    return true;
}


function showValidationError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const feedback = field.nextElementSibling?.classList?.contains('invalid-feedback') 
        ? field.nextElementSibling 
        : field.parentElement.querySelector('.invalid-feedback');
    
    if (feedback) {
        feedback.textContent = message;
    }

    Swal.fire({
                icon: 'error',
                title: fieldId + 'invalide',
                text: message,
            });


            document.getElementById(fieldId).focus();
    
    field.classList.add('is-invalid');
    field.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function clearValidationError(fieldId) {
    const field = document.getElementById(fieldId);
    field?.classList?.remove('is-invalid');
}


function goToStep(step) {
    const currentStep = parseInt(step.replace('step', ''));
    let canProceed = true;
    
   
    if (currentStep > 1) {
        canProceed = validateFormStep(currentStep - 1);
    }
    
    if (canProceed) {
        const tab = new bootstrap.Tab(document.querySelector(`#${step}-tab`));
        tab.show();
        
        if (currentStep === 2) enableStep('step3');
        if (currentStep === 3) enableStep('step4');
        
        updatePreview();
    }
}






function updateNextButtons() {
    const step1Valid = validateStep1(true);
    document.querySelector('[data-next="step2"]').disabled = !step1Valid;
    
    const step2Valid = validateStep2(true);
    document.querySelector('[data-next="step3"]').disabled = !step2Valid;
    
    const step3Valid = validateStep3(true);
    document.querySelector('[data-next="step4"]').disabled = !step3Valid;
}


document.getElementById('name').addEventListener('input', updateNextButtons);
document.getElementById('base_price').addEventListener('input', updateNextButtons);
document.getElementById('selectedCategoryId').addEventListener('change', updateNextButtons);


document.addEventListener('variantAdded', updateNextButtons);
document.addEventListener('variantRemoved', updateNextButtons);




const enableStep = (step) => {
    document.querySelector(`#${step}-tab`).classList.remove('disabled');
    updateNextButtons(); 
};


function updatePreview() {

    const name = document.getElementById('name').value.trim();
    const price = document.getElementById('base_price').value;
    const description = document.getElementById('description').value;
    

    const categoryPath = selectedCategory ? selectedCategory.path : 'Aucune catégorie sélectionnée';
    const categoryId = selectedCategory ? selectedCategory.id : 'ID introuvable';
    

    const variants = Array.from(document.querySelectorAll('.variant-item')).map(variant => {
        return {
            sizes: variant.querySelector('.variant-sizes').textContent,
            colors: Array.from(variant.querySelectorAll('.color-badge')).map(badge => badge.style.backgroundColor),
            materials: variant.querySelector('.variant-materials').textContent
        };
    });
    
 
    const imageCount = document.getElementById('imagePreview').children.length;
    

    document.getElementById('preview-name').textContent = name || '-';
    document.getElementById('preview-price').textContent = price ? `${price} FCFA` : '-';
    document.getElementById('preview-category').textContent = categoryPath;
    document.getElementById('preview-category-id').textContent = categoryId;

    

    const previewVariants = document.querySelector('#preview-variants tbody');
    previewVariants.innerHTML = '';
    
    if (variants.length === 0) {
        previewVariants.innerHTML = `
            <tr>
                <td colspan="3" class="text-center text-muted">Aucune variante ajoutée</td>
            </tr>
        `;
    } else {
        variants.forEach(variant => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${variant.sizes}</td>
                <td>
                    <div class="d-flex flex-wrap gap-2">
                        ${variant.colors.map(color => 
                            `<span class="color-badge" style="background-color:${color}"></span>`
                        ).join('')}
                    </div>
                </td>
                <td>${variant.materials}</td>
            `;
            previewVariants.appendChild(row);
        });
    }
    

    document.getElementById('preview-image-count').textContent = imageCount;
}


setupEventListeners();


document.addEventListener('DOMContentLoaded', function() {
    
    document.getElementById('selectedCategoryId').value = null;
    
     updateNextButtons();
    
  
    document.addEventListener('variantAdded', function() {
        updateNextButtons();
    });


    document.addEventListener('click', function(e) {



    if (e.target.classList.contains('select-main-category')) {
        const categoryId = e.target.dataset.id;
        const categoryName = e.target.dataset.name;
        
        if (e.target.nextElementSibling?.classList.contains('view-subcategories')) {
            showSubCategories(categoryId, categoryName);
        } else {
            selectCategory(categoryId, categoryName, categoryName);
        }
    }
    
    // Voir sous-catégories
    if (e.target.classList.contains('view-subcategories')) {
        const categoryId = e.target.dataset.id;
        const categoryName = e.target.dataset.name;
        showSubCategories(categoryId, categoryName);
    }
    

    if (e.target.classList.contains('select-sub-category')) {
        const categoryId = e.target.dataset.id;
        const categoryName = e.target.dataset.name;
        const parentPath = document.getElementById('categoryPath').textContent;
        
        if (e.target.nextElementSibling?.classList.contains('view-sub-subcategories')) {
            showSubSubCategories(categoryId, categoryName, parentPath);
        } else {
            selectCategory(categoryId, categoryName, `${parentPath} > ${categoryName}`);
        }
    }
    
    // Voir sous-sous-catégories
    if (e.target.classList.contains('view-sub-subcategories')) {
        const categoryId = e.target.dataset.id;
        const categoryName = e.target.dataset.name;
        const parentPath = document.getElementById('categoryPath').textContent;
        showSubSubCategories(categoryId, categoryName, parentPath);
    }
    
    if (e.target.classList.contains('select-final-category')) {
    const categoryId = e.target.dataset.id;
    const categoryName = e.target.dataset.name;
    const parentPath = document.getElementById('categoryPath').textContent;
    

    const pathParts = parentPath.split(' > ');
    const cleanPath = pathParts.length > 2 
        ? `${pathParts[0]} > ${pathParts[1]} > ${categoryName}`
        : `${parentPath} > ${categoryName}`;
    
    selectFinalCategory(categoryId, categoryName, cleanPath);
}
    

    if (e.target.classList.contains('back-to-main')) {
        resetToMainCategories();
    }
    

    if (e.target.classList.contains('back-to-sub')) {
        backToSubCategories();
    }
});






function showSubCategories(categoryId, categoryName) {
    const mainCategory = <?=json_encode($mainCategories)?>.find(cat => cat.id == categoryId);
    
    if (!mainCategory?.children?.length) {
        selectCategory(categoryId, categoryName, categoryName);
        return;
    }
    
    const container = document.getElementById('subCategoriesContainer');
    container.innerHTML = '';
    
    mainCategory.children.forEach(category => {
        const col = document.createElement('div');
        col.className = 'col-md-4';
        col.innerHTML = `
            <div class="category-card card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="${getCategoryIcon(category.name)} fa-3x  mb-3"></i>
                    <h5>${category.name}</h5>
                    
                    ${category.children?.length ? `
                    <button type="button" class="btn btn-sm btn-primary mt-2 view-sub-subcategories" 
                            data-id="${category.id}" data-name="${category.name}">
                        Select
                    </button>
                    ` : ''}
                </div>
            </div>
        `;
        container.appendChild(col);
    });
    
    document.getElementById('mainCategoryStep').classList.add('d-none');
    document.getElementById('subCategoryStep').classList.remove('d-none');
    document.getElementById('finalCategoryStep').classList.add('d-none');
    
    updateCategoryPath(categoryName);
}


function showSubSubCategories(categoryId, categoryName, parentPath) {
    let parentCategory = null;
 <?=json_encode($mainCategories)?>.forEach(mainCat => {
        if (!parentCategory) {
            const found = mainCat.children?.find(child => child.id == categoryId);
            if (found) parentCategory = found;
        }
    });
    
    if (!parentCategory?.children?.length) {
        selectFinalCategory(categoryId, categoryName, `${parentPath} > ${categoryName}`);
        return;
    }
    
    const container = document.getElementById('finalCategoriesContainer');
    container.innerHTML = '';
    
    parentCategory.children.forEach(category => {
        const col = document.createElement('div');
        col.className = 'col-md-4';
        col.innerHTML = `
            <div class="category-card card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="${getCategoryIcon(category.name)} fa-3x  mb-3"></i>
                    <h5>${category.name}</h5>
                    <button type="button" class="btn btn-sm btn-primary mt-2 select-final-category" 
                            data-id="${category.id}" data-name="${category.name}">
                        Select
                    </button>
                </div>
            </div>
        `;
        container.appendChild(col);
    });
    
    document.getElementById('subCategoryStep').classList.add('d-none');
    document.getElementById('finalCategoryStep').classList.remove('d-none');
    updateCategoryPath(`${parentPath} > ${categoryName}`);
}


function selectFinalCategory(id, name, path) {
    selectedCategory = { id, name, path };

    document.getElementById('selectedCategoryId').value = id;
    document.getElementById('categoryPath').textContent = path;
    document.getElementById('nextToVariants').disabled = false;
    document.getElementById('variantCategoryName').textContent = path;
    document.getElementById('selectedCategoryId').classList.remove('is-invalid');

    
    document.querySelectorAll('.select-final-category').forEach(btn => {
        btn.classList.remove('btn-success');
        btn.classList.add('btn-primary');
    btn.innerHTML = 'Select';
    });


    const clickedButton = document.querySelector(`.select-final-category[data-id="${id}"]`);
    if (clickedButton) {
        clickedButton.innerHTML = `<i class="fas fa-check me-2"></i> Selectionnée`;
        clickedButton.classList.remove('btn-primary');
        clickedButton.classList.add('btn-success');
    }

    loadVariantOptions(selectedCategory);
}



function selectCategory(id, name, path) {
    selectedCategory = { id, name, path };
    

    document.getElementById('categoryPath').textContent = path;
    document.getElementById('nextToVariants').disabled = false;
    document.getElementById('variantCategoryName').textContent = path;
    document.getElementById('selectedCategoryId').classList.remove('is-invalid');
    
   
    const level = path.split(' > ').length;
    if (level === 1) {
        document.querySelectorAll('.select-main-category').forEach(btn => {
            btn.disabled = true;
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-secondary');
        });
    } else if (level === 2) {
        document.querySelectorAll('.select-sub-category').forEach(btn => {
            btn.disabled = true;
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-secondary');
        });
    }
    
    loadVariantOptions(selectedCategory);
}

function resetToMainCategories() {
    document.getElementById('subCategoryStep').classList.add('d-none');
    document.getElementById('finalCategoryStep').classList.add('d-none');
    document.getElementById('mainCategoryStep').classList.remove('d-none');
    resetCategorySelection();
    updateNextButtons(); 
}


function backToSubCategories() {
    document.getElementById('finalCategoryStep').classList.add('d-none');
    document.getElementById('subCategoryStep').classList.remove('d-none');
    
    const currentPath = document.getElementById('categoryPath').textContent;
     document.getElementById('selectedCategoryId').value = '';
    const mainPath = currentPath.split(' > ')[0];
    updateCategoryPath(mainPath);
    
    document.querySelectorAll('.select-sub-category').forEach(btn => {
        btn.disabled = false;
        btn.classList.remove('btn-secondary');
        btn.classList.add('btn-primary');
    });
    updateNextButtons(); 
    loadVariantOptions();
}

function resetCategorySelection() {
    selectedCategory = null;
    document.getElementById('selectedCategoryId').value = '';
    document.getElementById('categoryPath').textContent = 'Aucune catégorie sélectionnée';
    document.getElementById('nextToVariants').disabled = true;
    document.getElementById('selectedCategoryId').classList.add('is-invalid');
    document.getElementById('variantCategoryName').textContent = '';
    
   
    document.querySelectorAll('.select-main-category, .select-sub-category, .select-final-category')
        .forEach(btn => {
            btn.disabled = false;
            btn.classList.remove('btn-secondary');
            btn.classList.add('btn-primary');
        });
        updateNextButtons(); 
        loadVariantOptions();
}


function updateCategoryPath(path) {
    document.getElementById('categoryPath').textContent = path;
}





function validateVariants() {
    const variantItems = document.querySelectorAll('.variant-item');
    if (variantItems.length === 0) {
        Swal.fire({
            icon: 'error',
            title: 'Variantes manquantes',
            text: 'Veuillez ajouter au moins une variante'
        });
        return false;
    }
    

    return true;
}






        function loadVariantOptions(category) {
            const variantConfig = document.getElementById('variantConfiguration');
            const categoryType = getCategoryType(category.path);
            
            let variantHtml = `
                <div class="variant-config-section">
                    <h5 class="fw-bold mb-4">Configuration des variantes (Minimum 1)</h5>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Tailles disponibles <span class="text-danger">*</span></h6>
                        <div class="row g-2" id="sizeOptions">
                            ${generateSizeOptions(categoryType)}
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Couleurs <span class="text-danger">*</span></h6>
                        <div class="color-picker mb-3">
                            ${generateColorOptions()}
                        </div>
                        <div class="custom-color-input">
                            <input type="color" id="customColor" value="#000000">
                            <input type="text" id="customColorName" class="form-control" placeholder="Nom de la couleur (optionnel)">
                            <button type="button" class="btn btn-primary ms-2" id="addCustomColor">
                                <i class="fas fa-plus"></i> Ajouter
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-4" id="materialSection">
                        <h6 class="fw-bold mb-3">Matériaux</h6>
                        <div class="row g-2" id="materialOptions">
                            ${generateMaterialOptions(categoryType)}
                        </div>
                    </div>
                    
                    <button type="button" id="addVariantBtn" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Ajouter cette variante
                    </button>
                </div>
            `;
            
            variantConfig.innerHTML = variantHtml;
            setupColorPicker();
updateNextButtons(); 
        }

function getCategoryType(categoryPath) {
    const categoryMap = {
       
        'Chemises': 'shirts', 'Pantalons': 'pants', 'Robes': 'dresses',
        'Vestes': 'jackets', 'Manteaux': 'coats', 'Costumes': 'suits',
        'Sous-vêtements': 'underwear', 'Maillots de bain': 'swimwear',
        'Sport': 'sportwear', 'Uniforme': 'uniform', 'Jogging': 'sweatpants',
        'Pulls': 'sweaters', 'T-shirts': 'tshirts', 'Shorts': 'shorts',
        'Jupes': 'skirts', 'Combinaisons': 'overalls',
        
       
        'Baskets': 'sneakers', 'Sandales': 'sandals', 'Bottes': 'boots',
        'Escarpins': 'heels', 'Chaussures de ville': 'dress_shoes',
        'Chaussures de sport': 'sport_shoes', 'Ballerines': 'flats',
        'Mocassins': 'loafers', 'Chaussons': 'slippers',
        
      
        'Montres': 'watches', 'Bijoux': 'jewelry', 'Sacs': 'bags',
        'Chapeaux': 'hats', 'Ceintures': 'belts', 'Cravates': 'ties',
        'Lunettes': 'eyewear', 'Écharpes': 'scarves', 'Gants': 'gloves',
        'Portefeuilles': 'wallets', 'Colliers': 'necklaces',
        'Bracelets': 'bracelets', 'Boucles d\'oreilles': 'earrings',
        'Bagues': 'rings', 'Chaînes': 'chains', 'Broches': 'brooches' ,'Parfums': 'perfumes',
    };

    for (const [key, value] of Object.entries(categoryMap)) {
        if (categoryPath.includes(key)) return value;
    }
    return 'other';
}


function generateSizeOptions(type) {
    const sizeDatabase = {
   
        shirts: ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'],
        tshirts: ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
        pants: ['28', '30', '32', '34', '36', '38', '40', '42', '44', '46'],
        dresses: ['XXS', 'XS', 'S', 'M', 'L', 'XL', 'XXL'],
        jackets: ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
        coats: ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
        suits: ['44', '46', '48', '50', '52', '54', '56'],
        underwear: ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
        swimwear: ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
        sweatpants: ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
        sweaters: ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
        shorts: ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
        skirts: ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
        overalls: ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
        
   
        sneakers: Array.from({length: 16}, (_, i) => (35 + i).toString()),
        sandals: Array.from({length: 13}, (_, i) => (35 + i).toString()),
        boots: Array.from({length: 12}, (_, i) => (36 + i).toString()),
        heels: Array.from({length: 13}, (_, i) => (35 + i).toString()),
        dress_shoes: Array.from({length: 11}, (_, i) => (38 + i).toString()),
        sport_shoes: Array.from({length: 11}, (_, i) => (38 + i).toString()),
        flats: Array.from({length: 11}, (_, i) => (35 + i).toString()),
        loafers: Array.from({length: 10}, (_, i) => (39 + i).toString()),
        slippers: ['XS', 'S', 'M', 'L', 'XL'],

        perfumes: ['30ml', '50ml', '75ml', '100ml', '150ml'],
        
        
     
        watches: [
            'Petit (28-32mm)', 'Moyen (34-38mm)', 'Grand (40-44mm)', 
            'Très grand (46mm+)', 'Enfant'
        ],
        hats: ['S (54-55cm)', 'M (56-57cm)', 'L (58-59cm)', 'XL (60-61cm)','XXL (62-65cm)'],
        belts: ['70cm', '75cm', '80cm', '85cm', '90cm', '95cm', '100cm', '105cm', '110cm'],
        gloves: ['XS', 'S', 'M', 'L', 'XL'],
        rings: ['44', '46', '48', '50', '52', '54', '56', '58', '60', '62', '64', '66', '68'],
        
      
        other:  ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
    };

    const sizes = sizeDatabase[type] || sizeDatabase.other;
    
    return sizes.map(size => `
        <div class="col-6 col-md-4">
            <div class="form-check">
                <input class="form-check-input size-option" type="checkbox" value="${size}" id="size-${size.replace(/\s+/g, '-').toLowerCase()}">
                <label class="form-check-label" for="size-${size.replace(/\s+/g, '-').toLowerCase()}">${size}</label>
            </div>
        </div>
    `).join('');
}

function generateColorOptions(type) {
    const colorDatabase = {
      
        base: [
            {code: '#000000', name: 'Noir'}, {code: '#FFFFFF', name: 'Blanc'},
            {code: '#C0C0C0', name: 'Argenté'}, {code: '#FFD700', name: 'Doré'},
            {code: '#808080', name: 'Gris'}, {code: '#964B00', name: 'Marron'},
            {code: '#FF0000', name: 'Rouge'}, {code: '#00FF00', name: 'Vert'},
            {code: '#0000FF', name: 'Bleu'}, {code: '#FFFF00', name: 'Jaune'},
            {code: '#FFA500', name: 'Orange'}, {code: '#800080', name: 'Violet'},
            {code: '#FFC0CB', name: 'Rose'}, {code: '#A52A2A', name: 'Brun'},
            {code: '#00FFFF', name: 'Cyan'}, {code: '#FF00FF', name: 'Magenta'}
        ],
        
    
        pastel: [
            {code: '#F8B195', name: 'Rose pastel'}, {code: '#F67280', name: 'Rouge pastel'},
            {code: '#C06C84', name: 'Mauve pastel'}, {code: '#6C5B7B', name: 'Lavande'},
            {code: '#355C7D', name: 'Bleu pastel'}, {code: '#99B898', name: 'Vert pastel'},
            {code: '#FECEAB', name: 'Pêche'}, {code: '#FF847C', name: 'Corail'},
            {code: '#E84A5F', name: 'Rose foncé'}, {code: '#2A363B', name: 'Gris ardoise'}
        ],
        
    
        neon: [
            {code: '#FF6EC7', name: 'Rose néon'}, {code: '#FF5F5F', name: 'Rouge néon'},
            {code: '#4BC0C8', name: 'Bleu néon'}, {code: '#FFA500', name: 'Orange néon'},
            {code: '#9ACD32', name: 'Vert néon'}, {code: '#FFD700', name: 'Jaune néon'},
            {code: '#9400D3', name: 'Violet néon'}, {code: '#00FA9A', name: 'Vert menthe'},
            {code: '#00BFFF', name: 'Bleu électrique'}, {code: '#FF1493', name: 'Rose fluo'}
        ],
        
  
        metallic: [
            {code: '#D4AF37', name: 'Or'}, {code: '#C0C0C0', name: 'Argent'},
            {code: '#B9B9B9', name: 'Platine'}, {code: '#E5E4E2', name: 'Titane'},
            {code: '#CD7F32', name: 'Bronze'}, {code: '#B87333', name: 'Cuivre'},
            {code: '#AAA9AD', name: 'Acier'}, {code: '#6A0DAD', name: 'Améthyste'},
            {code: '#008000', name: 'Émeraude'}, {code: '#000080', name: 'Saphir'}
        ],
        
    
        natural: [
            {code: '#F5DEB3', name: 'Beige'}, {code: '#D2B48C', name: 'Tan'},
            {code: '#A0522D', name: 'Terre de Sienne'}, {code: '#8B4513', name: 'Brun cuir'},
            {code: '#556B2F', name: 'Vert olive'}, {code: '#6B8E23', name: 'Vert kaki'},
            {code: '#708090', name: 'Gris acier'}, {code: '#778899', name: 'Gris ardoise'},
            {code: '#BDB76B', name: 'Vert kaki foncé'}, {code: '#BC8F8F', name: 'Rosé brun'}
        ],
        
    
        jewelry: [
            {code: '#FFD700', name: 'Or jaune'}, {code: '#E6E8FA', name: 'Or blanc'},
            {code: '#D4AF37', name: 'Or rose'}, {code: '#C0C0C0', name: 'Argent sterling'},
            {code: '#B9B9B9', name: 'Platine'}, {code: '#6A0DAD', name: 'Améthyste'},
            {code: '#008000', name: 'Émeraude'}, {code: '#000080', name: 'Saphir'},
            {code: '#FF0000', name: 'Rubis'}, {code: '#FFA500', name: 'Topaze'},
            {code: '#00FFFF', name: 'Aigue-marine'}, {code: '#40E0D0', name: 'Turquoise'}
        ],
        
        // Couleurs pour cuir
        leather: [
            {code: '#513B1C', name: 'Cuir brun'}, {code: '#1A1A1A', name: 'Cuir noir'},
            {code: '#C19A6B', name: 'Cuir cognac'}, {code: '#6B4423', name: 'Cuir havane'},
            {code: '#8B4513', name: 'Cuir saddle'}, {code: '#D2B48C', name: 'Cuir tan'},
            {code: '#A0522D', name: 'Cuir marron'}, {code: '#654321', name: 'Cuir foncé'},
            {code: '#F5DEB3', name: 'Cuir clair'}, {code: '#708090', name: 'Cuir gris'}
        ]
    };

    let colors = [...colorDatabase.base];
    

    if (['shirts', 'tshirts', 'dresses', 'jackets', 'coats', 'suits'].includes(type)) {
        colors.push(...colorDatabase.pastel, ...colorDatabase.natural);
    }
    else if (['sneakers', 'sandals', 'boots', 'heels', 'dress_shoes', 'flats'].includes(type)) {
        colors.push(...colorDatabase.leather, ...colorDatabase.neon);
    }
    else if (['jewelry', 'watches', 'rings', 'necklaces', 'earrings', 'bracelets'].includes(type)) {
        colors = [...colorDatabase.jewelry, ...colorDatabase.metallic];
    }
    else if (['bags', 'belts', 'wallets'].includes(type)) {
        colors.push(...colorDatabase.leather, ...colorDatabase.metallic);
    }
    else if (['sportwear', 'swimwear', 'sweatpants'].includes(type)) {
        colors.push(...colorDatabase.neon, ...colorDatabase.pastel);
    }
    

    const uniqueColors = colors.filter((color, index, self) =>
        index === self.findIndex((c) => c.code === color.code)
    );
    
    return uniqueColors.map(color => `
        <div class="color-option" 
             style="background-color: ${color.code}" 
             data-color="${color.code}" 
             data-name="${color.name}"
             title="${color.name}">
            <i class="fas fa-check"></i>
        </div>
    `).join('');
}

function generateMaterialOptions(type) {
    const materialDatabase = {
      
        clothing: [
            'Coton', 'Denim', 'Linen', 'Polyester', 'Viscose',
            'Laine', 'Soie', 'Velours', 'Wax', 'Bazin',
            'Broderie', 'Tissu traditionnel', 'Mélange coton' , 'jeans'
        ],
        

        shoes: [
            'Cuir', 'Daim', 'Toile', 'Synthétique', 'Caoutchouc',
            'Tissu technique', 'Plastique', 'Cuir verni' 
        ],
        

        accessories: [
            'Cuir', 'Métal', 'Tissu', 'Perles', 'Bois',
            'Plastique', 'Nylon', 'Polyester'
        ],
        
 
        jewelry: [
            'Or', 'Argent', 'Cuivre', 'Perles', 'Acier inoxydable',
            'Laiton', 'Bronze', 'Pierres naturelles'
        ],
        
     
        bags: [
            'Cuir', 'Toile', 'Nylon', 'Polyester', 'Paille',
            'Rotin', 'Tissu waxé'
        ]
    };

    let materials = [];
    
   
    if (['shirts', 'pants', 'dresses', 'jackets', 'tshirts', 'sweaters', 'skirts', 'tops'].includes(type)) {
        materials = materialDatabase.clothing;
    }

    else if (['sneakers', 'sandals', 'boots', 'heels', 'dress_shoes', 'sport_shoes'].includes(type)) {
        materials = materialDatabase.shoes;
    }

    else if (['jewelry', 'necklaces', 'earrings', 'bracelets'].includes(type)) {
        materials = materialDatabase.jewelry;
    }

    else if (['bags', 'school_bags'].includes(type)) {
        materials = materialDatabase.bags;
    }
   
    else {
        materials = materialDatabase.accessories;
    }

    return materials.map(material => `
        <div class="col-6 col-md-4">
            <div class="form-check">
                <input class="form-check-input material-option" type="checkbox" value="${material}" 
                       id="material-${material.toLowerCase().replace(/\s+/g, '-')}">
                <label class="form-check-label" for="material-${material.toLowerCase().replace(/\s+/g, '-')}">
                    ${material}
                </label>
            </div>
        </div>
    `).join('');
}
        
        function setupColorPicker() {
            selectedColors = ['#000000'];
            
            document.querySelectorAll('.color-option').forEach(option => {
                option.addEventListener('click', function() {
                    const color = this.dataset.color;
                    
                    if (this.classList.contains('selected')) {
                        this.classList.remove('selected');
                        selectedColors = selectedColors.filter(c => c !== color);
                    } else {
                        this.classList.add('selected');
                        if (!selectedColors.includes(color)) {
                            selectedColors.push(color);
                        }
                    }
                });
            });
            
            document.getElementById('addCustomColor').addEventListener('click', function() {
                const color = document.getElementById('customColor').value;
                const name = document.getElementById('customColorName').value || color;
                
                if (!selectedColors.includes(color)) {
                    selectedColors.push(color);
                    
                    const colorPicker = document.querySelector('.color-picker');
                    const newColor = document.createElement('div');
                    newColor.className = 'color-option selected';
                    newColor.style.backgroundColor = color;
                    newColor.dataset.color = color;
                    newColor.dataset.name = name;
                    newColor.title = name;
                    newColor.innerHTML = '<i class="fas fa-check"></i>';
                    
                    newColor.addEventListener('click', function() {
                        if (this.classList.contains('selected')) {
                            this.classList.remove('selected');
                            selectedColors = selectedColors.filter(c => c !== color);
                        } else {
                            this.classList.add('selected');
                            selectedColors.push(color);
                        }
                    });
                    
                    colorPicker.appendChild(newColor);
                    document.getElementById('customColorName').value = '';
                }
            });
        }



        document.addEventListener('click', function(e) {
            if (e.target.id === 'addVariantBtn') {
                const selectedSizes = Array.from(document.querySelectorAll('.size-option:checked')).map(el => el.value);
                const selectedMaterials = Array.from(document.querySelectorAll('.material-option:checked')).map(el => el.value);
                
 
                if (selectedSizes.length === 0 || selectedColors.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Sélection incomplète',
                        text: 'Veuillez sélectionner au moins une taille et une couleur'
                    });
                    return;
                }
          
                const variantTemplate = document.getElementById('variantTemplate').content.cloneNode(true);
                const variantRow = variantTemplate.querySelector('tr');
          
                variantRow.querySelector('.variant-number').textContent = variantIndex + 1;
                variantRow.querySelector('.variant-sizes').textContent = selectedSizes.join(', ');
                
           
                const colorsContainer = variantRow.querySelector('.variant-colors div');
                selectedColors.forEach(color => {
                    const colorElement = document.querySelector(`.color-option[data-color="${color}"]`);
                    const colorName = colorElement ? colorElement.dataset.name : color;
                    
                    const colorBadge = document.createElement('span');
                    colorBadge.className = 'color-badge';
                    colorBadge.style.backgroundColor = color;
                    colorBadge.title = colorName;
                    colorsContainer.appendChild(colorBadge);
                });
                
                variantRow.querySelector('.variant-materials').textContent = selectedMaterials.length > 0 ? selectedMaterials.join(', ') : 'Aucun';
                
               
                if (variantIndex === 0) {
                    document.querySelector('#variantsTable tbody').innerHTML = '';
                    document.getElementById('nextToImages').disabled = false;
                }
                
                document.querySelector('#variantsTable tbody').appendChild(variantRow);
                variantIndex++;
                
            
                document.querySelectorAll('.size-option:checked, .material-option:checked').forEach(el => {
                    el.checked = false;
                });
                
            
                
                
                Swal.fire({
                    icon: 'success',
                    title: 'Variante ajoutée',
                    showConfirmButton: false,
                    timer: 1500
                });

                updatePreview();
            }
            

            if (e.target.closest('.remove-variant')) {
                const variantItem = e.target.closest('.variant-item');
                const variantNumber = variantItem.querySelector('.variant-number').textContent;
                
                Swal.fire({
                    title: 'Supprimer cette variante?',
                    text: `Vous êtes sur le point de supprimer la variante #${variantNumber}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, supprimer!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        variantItem.remove();
                        variantIndex--;
                        
                       
                        document.querySelectorAll('.variant-item').forEach((item, index) => {
                            item.querySelector('.variant-number').textContent = index + 1;
                        });
                        
                        if (document.querySelectorAll('.variant-item').length === 0) {
                            document.querySelector('#variantsTable tbody').innerHTML = `
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Aucune variante ajoutée pour le moment
                                    </td>
                                </tr>
                            `;
                            document.getElementById('nextToImages').disabled = true;
                            variantIndex = 0;
                        }
                        
                      
                        updatePreview();
                    }
                });
            }
        });

    
   




document.getElementById('productForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const allStepsValid = [1, 2, 3, 4].every(step => validateFormStep(step));
    
    if (!allStepsValid) {
        Swal.fire({
            icon: 'error',
            title: 'Formulaire incomplet',
            text: 'Veuillez compléter toutes les étapes correctement',
            scrollbarPadding: false
        });
        return;
    }

    prepareVariantData();


    const result = await Swal.fire({
        title: 'Confirmer la création',
        html: generateConfirmationHTML(),
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Confirmer',
        cancelButtonText: 'Annuler',
        scrollbarPadding: false,
        didOpen: () => {
            const popup = Swal.getPopup();
            popup.style.maxHeight = '80vh';
            popup.style.overflowY = 'auto';
        }
    });

    if (result.isConfirmed) {

    
        await submitForm();
    }
});


function prepareVariantData() {
    
    document.querySelectorAll('input[name^="variants["]').forEach(el => el.remove());
    
    document.querySelectorAll('.variant-item').forEach((variant, index) => {
        const sizes = variant.querySelector('.variant-sizes').textContent.split(', ');
        const colors = Array.from(variant.querySelectorAll('.color-badge')).map(badge => 
            normalizeColorToHex(badge.style.backgroundColor)
        );
        const materialsText = variant.querySelector('.variant-materials').textContent;
        const materials = materialsText !== 'Aucun' ? materialsText.split(', ') : [];

      
        sizes.forEach((size, sizeIndex) => {
            addHiddenInput(`variants[${index}][sizes][${sizeIndex}]`, size);
        });

        colors.forEach((color, colorIndex) => {
            addHiddenInput(`variants[${index}][colors][${colorIndex}]`, color);
        });

        if (materials.length > 0) {
            materials.forEach((material, materialIndex) => {
                addHiddenInput(`variants[${index}][materials][${materialIndex}]`, material);
            });
        } else {
            addHiddenInput(`variants[${index}][materials]`, '');
        }
    });
}

function addHiddenInput(name, value) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    document.getElementById('productForm').appendChild(input);
}

function generateConfirmationHTML() {
    const productData = {
        name: document.getElementById('name').value,
        price: document.getElementById('base_price').value + ' FCFA',
        category: selectedCategory?.path || 'Non définie',
        variants: document.querySelectorAll('.variant-item').length,
        images: document.getElementById('imagePreview').children.length || 
                document.getElementById('images').files.length
    };
    
    return `
        <div class="text-start">
            <p>Vous êtes sur le point de créer un nouveau produit avec les caractéristiques suivantes :</p>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Nom :</span>
                    <span>${productData.name}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Prix :</span>
                    <span>${productData.price}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Catégorie :</span>
                    <span>${productData.category}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Variantes :</span>
                    <span>${productData.variants}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    <span class="fw-bold">Images :</span>
                    <span>${productData.images}</span>
                </li>
            </ul>
        </div>
    `;
}

async function submitForm() {

    const swalInstance = Swal.fire({
        title: 'Création en cours',
        html: 'Veuillez patienter pendant la création de votre produit...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    try {
        const form = document.getElementById('productForm');
        const formData = new FormData(form);
        
        const headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        };

        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: headers
        });


        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.message || 'Erreur serveur');
        }

        const data = await response.json();

        swalInstance.close();

        Swal.fire({
            icon: 'success',
            title: 'Produit créé!',
            text: 'Votre produit a été créé avec succès',
            confirmButtonText: 'OK',
            scrollbarPadding: false
        }).then(() => {
            window.location.href = data.redirect || "{{ route('manager.products.index') }}";
        });

    } catch (error) {
        swalInstance.close();

        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: error.message || 'Une erreur est survenue lors de la création du produit',
            scrollbarPadding: false
        });
    }
}



function normalizeColorToHex(color) {
    if (!color) return '#000000';
    
   
    if (/^#[0-9A-F]{6}$/i.test(color)) {
        return color.toUpperCase();
    }
    

    if (color.startsWith('rgb')) {
        const values = color.match(/\d+/g);
        if (values && values.length >= 3) {
            const r = parseInt(values[0]);
            const g = parseInt(values[1]);
            const b = parseInt(values[2]);
            return `#${((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1).toUpperCase()}`;
        }
    }
    

    const ctx = document.createElement('canvas').getContext('2d');
    ctx.fillStyle = color;
    const hex = ctx.fillStyle;
    return /^#[0-9A-F]{6}$/i.test(hex) ? hex.toUpperCase() : '#000000';
}






    });
</script>
@endsection