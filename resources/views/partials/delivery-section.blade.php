
<section id="delivery" class="hero-section delivery-section py-5 ">
    <div class="container">
        <div class="section-header text-center mb-5" data-scroll>
            <h1 class="section-title">Livraison & Paiement</h1>
            <p class="section-subtitle">Des options flexibles adaptées à vos besoins</p>
        </div>

        <div class="row g-4">
           
            <div class="col-md-4" data-scroll>
                <div class="delivery-card card h-100 border-0 shadow-sm hover-effect">
                    <div class="card-body text-center p-4">
                        <div class="delivery-icon mb-4">
                            <i class="fas fa-bolt"></i>
                            <div class="icon-bg"></div>
                        </div>
                        <h2 class="h5 mb-3 text-dark">Livraison Express</h2>
                        <ul class="delivery-features">
                            <li><i class="fas fa-check-circle  me-2"></i> Livré en 24-48h</li>
                            <li><i class="fas fa-check-circle me-2"></i> Suivi en temps réel</li>
                            <li><i class="fas fa-check-circle me-2"></i> Emballage premium</li>
                        </ul>
                        <p class="price-badge mt-3">À partir de 10 000 CFA</p>
                    </div>
                </div>
            </div>

    
            <div class="col-md-4" data-scroll>
                <div class="delivery-card card h-100 border-0 shadow-sm hover-effect">
                    <div class="card-body text-center p-4">
                        <div class="delivery-icon mb-4">
                            <i class="fas fa-lock"></i>
                            <div class="icon-bg"></div>
                        </div>
                        <h2 class="h5 mb-3 text-dark">Paiement Sécurisé</h2>
                        <div class="payment-methods mb-3">
                            <img src="{{ asset('storage/payement/MTN.png') }}" alt="MTN Mobile Money" width="60">
                            <img src="{{ asset('storage/payement/orange.png') }}" alt="Orange Money" width="60">
                            <img src="{{ asset('storage/payement/Visa.png') }}" alt="Visa" width="60">
                        </div>
                        <p class=" text-dark " style="margin-top: 100px;">100% sécurisé - Aucune donnée bancaire stockée</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4" data-scroll>
                <div class="delivery-card card h-100 border-0 shadow-sm hover-effect">
                    <div class="card-body text-center p-4">
                        <div class="delivery-icon mb-4">
                            <i class="fas fa-exchange-alt"></i>
                            <div class="icon-bg"></div>
                        </div>
                        <h2 class="h5 mb-3 text-dark">Retour Facile</h2>
                        <ul class="delivery-features">
                            <li><i class="fas fa-check-circle   me-2"></i> 15 jours pour changer d'avis</li>
                            <li><i class="fas fa-check-circle  me-2"></i> Retour gratuit sous conditions</li>
                            <li><i class="fas fa-check-circle  me-2"></i> Remboursement sous 72h</li>
                        </ul>
                        <button class="btn btn-dark futur-btn btn-s mt-2" data-bs-toggle="modal" data-bs-target="#Politique">
                            Voir la politique
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="delivery-info mt-5 pt-4 border-top-or" data-scroll>
            <div class="row">
                <div class="col-md-6">
                    <h4><i class="fas fa-map-marker-alt futuristic-btn  me-2"></i> Zones de livraison</h4>
                    <p class="text-dark">Nous livrons dans toutes les grandes villes du Cameroun : Douala, Yaoundé, Bafoussam, Bamenda, etc.</p>
                </div>
                <div class="col-md-6">
                    <h4><i class="fas fa-clock futuristic-btn me-2"></i> Heures de livraison</h4>
                    <p class="text-dark">Livraison entre 8h et 18h du lundi au samedi. Commandez avant 14h pour une livraison le lendemain.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials.politique')

<style>
/* DELIVERY SECTION STYLES */
.delivery-section {
  
    position: relative;
    overflow: hidden;
}

.delivery-section::before {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(212, 175, 55, 0.05);
    border-radius: 50%;
    z-index: 0;
}

.delivery-section::after {
    content: '';
    position: absolute;
    bottom: -100px;
    left: -100px;
    width: 300px;
    height: 300px;
    background: rgba(33, 37, 41, 0.03);
    border-radius: 50%;
    z-index: 0;
}

.section-header {
    position: relative;
    z-index: 2;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    background: linear-gradient(to right, var(--black-1), var(--gris-anthracite));
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    display: inline-block;
    margin-bottom: 1rem;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -15px;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(to right, var(--or-metallise), transparent);
    border-radius: 3px;
}


.delivery-card {
    border: none;
    border-radius: 12px;
    background: linear-gradient(circle, rgba(255,255,255,0.8) 0%, rgba(255,255,0,0.7) 70%);
    transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    z-index: 1;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.delivery-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(to right, var(--or-metallise), #f8f9fa);
}

.delivery-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
}

.delivery-icon {
    position: relative;
    width: 90px;
    height: 90px;
    margin: 0 auto 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(212, 175, 55, 0.1);
    border-radius: 50%;
    box-shadow: 0 3px 30px rgba(159, 139, 74, 0.9);
    transition: all 0.3s ease;
}

.delivery-icon i {
    font-size: 2.5rem;
    color: var(--black-2);
    transition: all 0.3s ease;
}

.delivery-card:hover .delivery-icon {
    transform: rotateY(180deg);
    background: rgba(212, 175, 55, 0.2);
}

.delivery-card:hover .delivery-icon i {
    transform: rotateY(-180deg);
}

.delivery-features {
    list-style: none;
    padding: 0;
    margin: 1.5rem 0;
    flex-direction: column;
    justify-content: flex-start;
    text-align: start;
}

.delivery-features li i{
    color:rgb(1, 147, 38);
    font-size: 25px;
}

.delivery-features li {
    padding: 8px 0;
    position: relative;
    padding-left: 30px;
    margin-bottom: 5px;
}



.price-badge {
    display: inline-block;
    background: linear-gradient(to right, var(--or-metallise),rgb(235, 208, 109));
    color: var(--black-2) !important;
    border: 1px solid var(--black-2);
    padding: 15px 20px;
    border-radius: 30px;
    
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 1px;
    box-shadow: 0 3px 20px rgba(116, 113, 103, 0.3);
}

.payment-methods {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
    margin: 1.5rem 0;
}

.payment-methods img {
    height: 100px;
    width: auto;
    filter: grayscale(20%);
    opacity: 1;
    transition: all 0.3s ease;
    border-radius: 15px;
}

.payment-methods img:hover {
    filter: grayscale(0%);
    opacity: 1;
    transform: scale(1.1);
}

.delivery-info {
    position: relative;
    z-index: 2;
    background: linear-gradient(to right, var(--or-metallise),rgb(227, 207, 135));
    padding: 2rem;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    margin-top: 3rem;
}

.delivery-info h4 {
    color: var(--black-1);
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
}

.delivery-info h4 i {
    margin-right: 10px;
    color: var(--black-2);
}

.delivery-info p {
    color: #6c757d;
    padding-left: 30px;
}

/* Animations */
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}

.delivery-card:hover {
    animation: float 3s ease-in-out infinite;
}

/* Responsive */
@media (max-width: 768px) {
    .delivery-section {
        padding: 3rem 0;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .delivery-card {
        margin-bottom: 2rem;
    }
    
    .delivery-info {
        padding: 1.5rem;
    }
}

.delivery-card:hover::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.8) 0%, rgba(255,255,0,0.7) 70%);
    transform: rotate(45deg);
    z-index: -1;
    opacity: 0;
    transition: opacity 0.5s ease;
}

.delivery-card:hover::after {
    opacity: 1;
}
</style>