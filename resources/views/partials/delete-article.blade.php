
<div class="modal fade glass-modal" id="deleteArticleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-blur border-0">
            <div class="modal-header bg-gradient-danger text-white">
                <h5 class="modal-title"><i class="fas fa-trash me-2"></i> Confirmer la suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="deleteArticleMessage" class="lead"></p>
                
                <div id="usersInCartAlert" class="alert alert-orange d-none">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                        <div>
                            <h5 class="alert-title">Article présent dans des paniers</h5>
                            <p>Les utilisateurs suivants ont cet article dans leur panier :</p>
                        </div>
                    </div>
                    
                    <div class="table-responsive mt-3">
                        <table class="table table-sm table-hover">
                            <thead class="bg-orange-10">
                                <tr>
                                    <th>Utilisateur</th>
                                    <th>Email</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody id="usersInCartList">
                             
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="confirmForceDelete">
                            <label class="form-check-label" for="confirmForceDelete">
                                Je comprends que cette action supprimera l'article des paniers des utilisateurs
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light-blur">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i> Annuler
                </button>
                <button type="button" class="btn btn-danger" id="confirmArticleDelete">
                    <i class="fas fa-trash me-2"></i> Supprimer
                </button>
                <button type="button" class="btn btn-danger d-none" id="confirmForceArticleDelete" disabled>
                    <i class="fas fa-exclamation-triangle me-2"></i> Forcer la suppression
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.glass-modal .modal-content {
    backdrop-filter: blur(10px);
    background-color: var(--bs-dark);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.bg-light-blur {
    background-color: rgba(255, 255, 255, 0.5);
}

.alert-orange {
    background-color: rgba(253, 126, 20, 0.15);
    border-color: #fd7e14;
    color: #fd7e14;
}

.bg-orange-10 {
    background-color: rgba(253, 126, 20, 0.1);
}
</style>