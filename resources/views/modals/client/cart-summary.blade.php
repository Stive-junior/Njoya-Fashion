
<div class="modal fade" id="cartPreviewModal" tabindex="-1" aria-labelledby="cartPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartPreviewModalLabel">Votre Panier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="cartItemsContainer">
                    <!-- Les éléments du panier seront chargés ici dynamiquement -->
                </div>
                <div class="text-end fw-bold fs-5 mt-3">
                    Total: <span id="cartTotal">0</span> FCFA
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Continuer mes achats</button>
                <a href="{{ route('client.cart.index') }}" class="btn btn-primary">Passer la commande</a>
            </div>
        </div>
    </div>
</div>