<section id="Contact" class="hero-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 class="text-center t mb-5">Contactez-nous</h2>
                <form  action="{{route('home')}}" method="get" class="contact-form row g-3 bg-dark p-5 rounded-3" data-scroll>
                  
                        <div class="col-md-6">
                            <div>
                           <label for="name" class="form-label">Votre nom</label>
                            <input type="text" class="form-control futuristic-input" id="name" placeholder="Votre nom" required>
                            </div>
                            
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Votre email</label>
                                <input type="email" class="form-control futuristic-input" id="email" placeholder="Votre email" required>
                                
                            
                        </div>
                        <div class="col-12">
                            <label for="subject" class="form-label">Sujet</label>
                                <input type="text" class="form-control futuristic-input" id="subject" placeholder="Sujet" required>
                                
                            
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label">Votre message</label>
                                <textarea class="form-control futuristic-input" placeholder="Votre message" id="message" style="height: 150px" required></textarea>
                                
                            
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary futur-btn px-4 py-2">
                                <i class="fas fa-paper-plane me-2"></i> Envoyer
                            </button>
                        </div>
                    
                </form>
            
                
                <div class="contact-inf d-flex justify-content-between mt-5 text-center text-white">
                    <div class="col-md-3 mb-4">
                        <i class="fas fa-map-marker-alt fa-2x mb-3" style="color: var(--or-metallise);"></i>
                        <h5>Adresse</h5>
                        <p>Yaounde, Cameroun</p>
                    </div>
                    <div class="col-md-3 mb-4">
                        <i class="fas fa-phone-alt fa-2x mb-3" style="color: var(--or-metallise);"></i>
                        <h5>Téléphone</h5>
                        <p>+237 672 037 300</p>
                    </div>
                    <div class="col-md-3 ms-4">
                        <i class="fas fa-envelope fa-2x mb-3" style="color: var(--or-metallise);"></i>
                        <h5>Email</h5>
                        <p>contact@njoya.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


<style>
.contact-form .form-control {
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    color: white;
}
.contact-form .form-control:focus {
    background: rgba(255,255,255,0.2);
    color: white;
}
.contact-form label {
    color: rgba(255,255,255,0.7) ;
}


</style>