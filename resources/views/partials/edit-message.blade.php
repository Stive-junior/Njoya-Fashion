    <div class="modal fade futuristic-modal" id="messageModal{{ $itemId }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-dark border-or">
                <div class="modal-header border-bottom-or">
                    <h5 class="modal-title text-or">Modifier le message</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <textarea class="form-control custom-message-textarea" rows="4"
                              id="messageInput{{ $itemId }}">{{ $customMessage }}</textarea>
                </div>
                <div class="modal-footer border-top-or">
                    <button type="button" class="btn  futur-btn text-white" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary save-message-btn futur-btn text-white"
                            data-item-id="{{ $itemId }}" data-bs-dismiss="modal">
                        Enregistrer
                    </button>
                </div>
            </div>
        </div>
    </div>
