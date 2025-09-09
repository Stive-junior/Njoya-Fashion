<div class="modal fade futuristic-modal" id="variantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Ajouter une variante</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="variantForm">
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Tailles disponibles</h6>
                        <div class="row g-2" id="sizeOptions"></div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Couleurs disponibles</h6>
                        <div class="row g-2" id="colorOptions"></div>
                    </div>
                    
                    <div class="mb-4" id="materialSection">
                        <h6 class="fw-bold mb-3">Matériaux disponibles</h6>
                        <div class="row g-2" id="materialOptions"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" id="saveVariantBtn" class="btn btn-primary">Enregistrer la variante</button>
            </div>
        </div>
    </div>
</div>