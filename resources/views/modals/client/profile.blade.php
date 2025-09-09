
<div class="modal fade futuristic-modal" id="profileModal" tabindex="1"  aria-hidden="true" style="z-index: 1000;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
           
            <div class="modal-header">
                <h5 class="modal-title" id="profileModalLabel">Mon Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

          
            <div class="modal-body text-center">
                 <div class="row">
                <div class="user-info mb-3 col-md-5">
                    <div class="user-avatar" style="background-image: url('<?= $profilePicture ? asset('storage/' . $profilePicture->url) : asset('images/default-avatar.png') ?>');"></div>
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>{{ Auth::user()->email }}</p>
                </div>
                 

                 
                <div class="stats d-flex mb-2 text-start  col-md-6" style="gap:10%;">
                    <div class="stat-item">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Panier : 3 articles</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-box"></i>
                        <span>Commandes : 5</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-star"></i>
                        <span>Note : 4.5/5</span>
                    </div>
                </div>
                 </div>

              
                <div class="actions d-flex justify-content-around">
                    <a href="{{ route('profile.edit') }}" class="btn">
                        <i class="fas fa-edit me-2"></i> Modifier le profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn text-white btn-danger">
                            <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>