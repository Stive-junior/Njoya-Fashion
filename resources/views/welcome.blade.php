@extends('layouts.app')

@section('content')

{{-- Première Section Héros: Introduction Njoya --}}
<section class="hero-intro-section position-relative overflow-hidden py-5 d-flex align-items-center min-vh-100">
    <div class="background-overlay"></div>
    <div class="container z-1">
        <div class="row align-items-center">
            <div class="col-lg-6 text-center text-lg-start mb-5 mb-lg-0">
                <h1 class="display-2 fw-bold text-white mb-3" data-scroll>Njoya</h1>
                <h3 class="display-6 fw-light text-white-50 mb-4" data-scroll>Boutique de Mode</h3>
                <p class="lead text-white-75 mb-5" data-scroll>"La mode est bien plus qu'un vêtement, c'est une attitude, une déclaration, une histoire. Osez vous démarquer, embrassez l'élégance et redéfinissez les tendances."</p>
                <div data-scroll>
                    <a href="#nouveautes" class="btn btn-primary btn-lg shadow-lg animate__animated animate__fadeInUp">Explorer la collection</a>
                </div>
            </div>
            <div class="col-lg-6 d-flex justify-content-center align-items-center" data-scroll>
                <div class="image-gallery-grid">
                    @foreach (['jpeg.png', 'pull.jpeg', 'cloth.png', 'logo.webp'] as $index => $image)
                        <div class="gallery-img-wrapper animate__animated animate__zoomIn animate__delay-{{ $index }}s">
                            <img src="{{ asset('images/' . $image) }}" alt="Image {{ $index + 1 }}" class="img-fluid rounded shadow-lg">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

---

{{-- Section Galerie de Nouveautés --}}
<section id="nouveautes" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 display-4 fw-bold text-dark" data-scroll>Nouveautés</h2>
        <div class="nouveautes-grid" data-scroll>
            @for ($i = 1; $i <= 8; $i++)
                <div class="nouveautes-item card shadow-sm border-0 animate__animated animate__fadeInUp animate__delay-{{ floor(($i - 1) / 4) }}s">
                    <img src="{{ asset('images/image.png') }}" alt="Nouveauté {{ $i }}" class="card-img-top object-fit-cover">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Nouveauté {{ $i }}</h5>
                        <p class="card-text text-muted">Découvrez notre dernière collection.</p>
                        <a href="#" class="btn btn-outline-dark btn-sm mt-3">Voir plus</a>
                    </div>
                </div>
            @endfor
        </div>
        <div class="text-center mt-5" data-scroll>
            <a href="#" class="btn btn-secondary btn-lg animate__animated animate__fadeInUp animate__delay-1s">Voir toute la collection</a>
        </div>
    </div>
</section>

---

{{-- Section Icônes Animées en Arrière-plan --}}
<div class="animated-background-icons">
    @foreach (['tshirt', 'hat-cowboy', 'socks', 'shoe-prints', 'glasses', 'ring', 'handbag', 'scarf', 'belt', 'watch', 'glove', 'umbrella', 'sunglasses', 'wallet', 'backpack', 'cap', 'coat', 'dress', 'jeans', 'shorts'] as $icon)
        <i class="fas fa-{{ $icon }}"></i>
    @endforeach
</div>

---

{{-- Section Accueil - Marketing Oriented --}}
<section class="marketing-hero-section py-5 position-relative overflow-hidden min-vh-100 d-flex align-items-center">
    <div class="container z-1">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-5 mb-md-0">
                <div class="social-icons mb-4" data-scroll>
                    <a href="#" class="btn btn-outline-light me-2 animate__animated animate__fadeInLeft"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-outline-light me-2 animate__animated animate__fadeInLeft animate__delay-1s"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="btn btn-outline-light animate__animated animate__fadeInLeft animate__delay-2s"><i class="fab fa-instagram"></i></a>
                </div>
                <h1 class="display-3 fw-bold text-white mb-3" data-scroll>Njoya</h1>
                <h3 class="display-6 text-white-75 mb-4" data-scroll>Élégance Redéfinie</h3>
                <p class="lead text-white-50 mb-5" data-scroll>"Découvrez notre collection exclusive d'habits et d'accessoires. Des pièces uniques pour un style inoubliable."</p>
                <div class="cta-buttons" data-scroll>
                    <a href="#nouveautes" class="btn btn-primary btn-lg me-3 animate__animated animate__fadeInUp">Découvrir les Nouveautés</a>
                    <a href="#promotions" class="btn btn-outline-light btn-lg animate__animated animate__fadeInUp animate__delay-1s">Promotions en Cours</a>
                </div>
            </div>
            <div class="col-md-6 d-flex justify-content-center" data-scroll>
                <div class="hero-image-wrapper position-relative animate__animated animate__zoomIn">
                    <img src="{{ asset('images/image.png') }}" alt="Crystal" class="img-fluid rounded shadow-lg">
                    <div class="glow-effect"></div>
                    <div class="badge-new-collection position-absolute top-0 start-0 translate-middle badge bg-primary fs-6 py-2 px-3 animate__animated animate__bounceIn">
                        Nouvelle Collection
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

---

{{-- Section Galerie de Produits (Carrousel) --}}
<section class="product-gallery-section py-5 bg-dark text-white" id="promotions">
    <div class="container">
        <h2 class="text-center mb-5 display-4 fw-bold" data-scroll>Nos Collections Phares</h2>
        <div id="productCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner rounded shadow-lg">
                @foreach (['pull.jpeg', 'image.png', 'logo.webp'] as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ asset('images/' . $image) }}" class="d-block w-100 object-fit-cover" alt="Product {{ $index + 1 }}">
                        <div class="carousel-caption d-none d-md-block text-start bg-dark bg-opacity-75 p-3 rounded">
                            <h5 class="display-6 fw-bold">Produit {{ $index + 1 }}</h5>
                            <p class="lead">€{{ number_format(49.99 + $index * 10, 2) }}</p>
                            <a href="#" class="btn btn-outline-light btn-sm mt-2">Détails</a>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
        </div>
    </div>
</section>

---

{{-- Section Livraison et Paiement --}}
<section class="delivery-payment-section py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 display-4 fw-bold text-dark" data-scroll>Livraison & Paiement</h2>
        <div class="row g-4 justify-content-center">
            @foreach ([
                ['icon' => 'truck', 'title' => 'Livraison Express', 'text' => 'Recevez vos articles en 24/48h partout au Cameroun.'],
                ['icon' => 'credit-card', 'title' => 'Paiement Sécurisé', 'text' => 'Transactions 100% protégées par les dernières technologies de cryptage.'],
                ['icon' => 'shield-alt', 'title' => 'Satisfait ou Remboursé', 'text' => '30 jours pour changer d\'avis. Retours faciles et gratuits.']
            ] as $card)
                <div class="col-md-6 col-lg-4" data-scroll>
                    <div class="card feature-card h-100 text-center shadow-sm border-0 animate__animated animate__fadeInUp">
                        <div class="card-body p-4">
                            <i class="fas fa-{{ $card['icon'] }} fa-4x text-primary mb-4"></i>
                            <h3 class="card-title fw-bold mb-3">{{ $card['title'] }}</h3>
                            <p class="card-text text-muted">{{ $card['text'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

---

{{-- Section Avis Clients --}}
<section class="reviews-section py-5 bg-dark text-white">
    <div class="container">
        <h2 class="text-center mb-5 display-4 fw-bold" data-scroll>Ce que nos Clients Disent</h2>
        <div class="row g-4 justify-content-center">
            @foreach (['Nana T.', 'Steve P.', 'Junior L.'] as $user)
                <div class="col-md-6 col-lg-4" data-scroll>
                    <div class="card review-card h-100 shadow-lg border-0 bg-secondary animate__animated animate__fadeInUp">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ asset('images/image.jpg') }}" alt="{{ $user }}" class="review-avatar rounded-circle me-3 border border-3 border-primary">
                                <h4 class="card-title mb-0 fw-bold text-white">{{ $user }}</h4>
                            </div>
                            <p class="card-text text-white-75 mb-3">"Absolument ravie de mon achat chez Njoya ! La qualité est exceptionnelle et la livraison a été super rapide. Je recommande vivement !"</p>
                            <div class="rating">
                                @for ($i = 0; $i < 5; $i++)
                                    <i class="fas fa-star text-warning"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5" data-scroll>
            <a href="#" class="btn btn-outline-light btn-lg animate__animated animate__fadeInUp animate__delay-1s">Lire plus d'avis</a>
        </div>
    </div>
</section>

---

{{-- Section Contact --}}
<section class="contact-section py-5 bg-primary-gradient text-white">
    <div class="container">
        <h2 class="text-center mb-5 display-4 fw-bold" data-scroll>Contactez-nous</h2>
        <form action="#" method="post" class="contact-form p-4 p-md-5 rounded-4 shadow-lg mx-auto animate__animated animate__fadeInUp" style="max-width: 800px;">
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="name" class="form-label visually-hidden">Nom:</label>
                    <input type="text" class="form-control futuristic-input" id="name" name="name" placeholder="Votre Nom Complet" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label visually-hidden">Email:</label>
                    <input type="email" class="form-control futuristic-input" id="email" name="email" placeholder="Votre Email" required>
                </div>
                <div class="col-12">
                    <label for="subject" class="form-label visually-hidden">Sujet:</label>
                    <input type="text" class="form-control futuristic-input" id="subject" name="subject" placeholder="Sujet du Message">
                </div>
                <div class="col-12">
                    <label for="message" class="form-label visually-hidden">Message:</label>
                    <textarea class="form-control futuristic-input" id="message" name="message" rows="6" placeholder="Votre Message..." required></textarea>
                </div>
                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-light btn-lg text-primary fw-bold shadow-sm animate__animated animate__pulse animate__infinite">Envoyer le Message</button>
                </div>
            </div>
        </form>
    </div>
</section>

---

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
{{-- Intégration de Font Awesome pour les icônes --}}
<script src="https://kit.fontawesome.com/votre_code_font_awesome.js" crossorigin="anonymous"></script> 
{{-- IMPORTANT : Remplacez 'votre_code_font_awesome.js' par votre propre kit ou utilisez la version CDN standard si vous n'avez pas de kit pro --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/ScrollTrigger.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></script>


<script>
    // Initialisation de GSAP
    gsap.registerPlugin(ScrollTrigger);

    // Animation de scroll pour les éléments avec data-scroll
    const scrollElements = document.querySelectorAll("[data-scroll]");

    scrollElements.forEach((el) => {
        gsap.fromTo(el,
            { opacity: 0, y: 50 }, // État initial (caché, décalé vers le bas)
            {
                opacity: 1,
                y: 0,
                duration: 1, // Durée de l'animation
                ease: "power2.out", // Type d'accélération
                scrollTrigger: {
                    trigger: el,
                    start: "top 85%", // Commence l'animation quand l'élément est à 85% du haut du viewport
                    toggleActions: "play none none none", // Joue l'animation une fois
                    // markers: true, // Pour le débogage, commenter en production
                }
            }
        );
    });

    // Animation des icônes en arrière-plan (plus subtile et continue)
    document.querySelectorAll('.animated-background-icons i').forEach((icon, index) => {
        const size = Math.random() * 20 + 10; // Taille entre 10px et 30px
        icon.style.fontSize = `${size}px`;
        icon.style.opacity = Math.random() * 0.3 + 0.1; // Opacité faible
        icon.style.position = 'absolute';
        icon.style.left = `${Math.random() * 100}%`;
        icon.style.top = `${Math.random() * 100}%`;
        icon.style.color = `rgba(255, 255, 255, ${Math.random() * 0.2 + 0.05})`; // Couleur blanche semi-transparente

        gsap.to(icon, {
            x: (Math.random() - 0.5) * 500, // Déplacement horizontal
            y: (Math.random() - 0.5) * 500, // Déplacement vertical
            rotation: Math.random() * 360, // Rotation
            scale: Math.random() * 0.5 + 0.8, // Zoom léger
            opacity: Math.random() * 0.3 + 0.1,
            duration: Math.random() * 20 + 10, // Durée longue
            ease: "none",
            repeat: -1, // Répète à l'infini
            yoyo: true, // Va et vient
            delay: Math.random() * 5 // Délai initial aléatoire
        });
    });

    // Animation spécifique pour les images de la première section héros
    gsap.fromTo(".image-gallery-grid .gallery-img-wrapper",
        { opacity: 0, scale: 0.8 },
        {
            opacity: 1,
            scale: 1,
            duration: 1,
            ease: "back.out(1.7)",
            stagger: 0.2, // Délai entre chaque image
            scrollTrigger: {
                trigger: ".image-gallery-grid",
                start: "top 80%",
                toggleActions: "play none none none",
            }
        }
    );

</script>

<style>
    /* Import de Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&family=Playfair+Display:wght@400;700&display=swap');
    
    /* Variables CSS */


    h1, h2, h3, h4, h5, h6 {
        font-family: var(--font-heading);
        color: var(--text-color-dark);
        margin-bottom: 1rem;
    }

    /* Couleurs des boutons Bootstrap personnalisées */
    .btn-primary {
        background-color: var(--primary-color) !important;
        border-color: var(--primary-color) !important;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: darken(var(--primary-color), 10%) !important; /* Pas du SCSS, mais l'idée est d'assombrir */
        border-color: darken(var(--primary-color), 10%) !important;
        transform: translateY(-2px);
    }

    .btn-outline-dark {
        border-color: var(--secondary-color);
        color: var(--secondary-color);
        transition: all 0.3s ease;
    }

    .btn-outline-dark:hover {
        background-color: var(--secondary-color);
        color: #fff;
    }

    .btn-outline-light {
        border-color: var(--text-color-light);
        color: var(--text-color-light);
        transition: all 0.3s ease;
    }

    .btn-outline-light:hover {
        background-color: var(--text-color-light);
        color: var(--dark-bg);
    }

    /* Styles pour les sections */
    section {
        padding: 80px 0;
        position: relative;
        z-index: 1;
    }

    /* --- Section Héros d'Introduction --- */
    .hero-intro-section {
        background: linear-gradient(135deg, rgba(30, 30, 30, 0.9), rgba(60, 60, 60, 0.9));
        color: var(--text-color-light);
        position: relative;
    }

    .hero-intro-section .background-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('{{ asset('images/bg_pattern.png') }}'); /* Exemple de motif subtil */
        background-size: cover;
        opacity: 0.1; /* Très subtil */
        z-index: 0;
    }

    .hero-intro-section h1 {
        font-size: 5rem;
        color: #fff;
        line-height: 1;
    }

    .hero-intro-section h3 {
        font-size: 3rem;
        color: rgba(255, 255, 255, 0.7);
    }

    .hero-intro-section p {
        font-size: 1.25rem;
        color: rgba(255, 255, 255, 0.85);
        max-width: 600px;
        margin: 0 auto 2.5rem auto; /* Centré pour les petits écrans */
    }

    @media (min-width: 992px) {
        .hero-intro-section p {
            margin: 0 0 2.5rem 0; /* Alignement gauche pour les grands écrans */
        }
    }


    .image-gallery-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        max-width: 500px; /* Limite la largeur du grid d'images */
        margin: auto;
    }

    .image-gallery-grid .gallery-img-wrapper {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        transition: transform 0.3s ease;
    }

    .image-gallery-grid .gallery-img-wrapper:hover {
        transform: translateY(-5px) scale(1.02);
    }

    .image-gallery-grid img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* --- Section Nouveautés --- */
    .nouveautes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
    }

    .nouveautes-item {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }

    .nouveautes-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .nouveautes-item img {
        height: 300px; /* Hauteur fixe pour toutes les images de nouveautés */
        border-bottom: 1px solid #eee;
    }

    /* --- Icônes animées en arrière-plan --- */
    .animated-background-icons {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none; /* Empêche les icônes d'interférer avec les clics */
        z-index: 0; /* S'assure qu'elles sont derrière le contenu */
        overflow: hidden;
    }

    .animated-background-icons i {
        position: absolute;
        display: block;
        color: rgba(255, 255, 255, 0.05); /* Très faible opacité */
        text-shadow: 0 0 5px rgba(255, 255, 255, 0.1);
    }


    /* --- Section Marketing Hero --- */
    .marketing-hero-section {
        background: linear-gradient(to right, var(--dark-bg), var(--secondary-color));
        color: var(--text-color-light);
    }

    .marketing-hero-section h1,
    .marketing-hero-section h3 {
        color: #fff;
    }

    .marketing-hero-section p {
        color: rgba(255, 255, 255, 0.8);
    }

    .social-icons a {
        font-size: 1.5rem;
        width: 50px;
        height: 50px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .social-icons a:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        transform: translateY(-3px);
    }

    .hero-image-wrapper {
        border-radius: 15px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        background: rgba(255, 255, 255, 0.05); /* Pour le fond du glow */
        padding: 15px;
    }
    
    .hero-image-wrapper img {
        border-radius: 10px;
    }

    .hero-image-wrapper .glow-effect {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 80%;
        height: 80%;
        background: radial-gradient(circle, var(--primary-color) 0%, transparent 70%);
        filter: blur(50px);
        transform: translate(-50%, -50%);
        opacity: 0.3;
        z-index: -1;
    }

    .badge-new-collection {
        transform: translate(-50%, -50%) rotate(-15deg) !important;
        white-space: nowrap;
    }
    
    /* --- Section Galerie de Produits (Carrousel) --- */
    .product-gallery-section .carousel-item img {
        height: 500px; /* Hauteur fixe pour les images du carrousel */
    }

    .product-gallery-section .carousel-caption {
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 8px;
        padding: 1.5rem;
        bottom: 20%; /* Positionnement légèrement plus haut */
        left: 5%;
        right: auto;
        width: 90%; /* Prend plus de place sur les petits écrans */
        max-width: 400px; /* Largeur max sur grands écrans */
        text-align: left;
    }

    .product-gallery-section .carousel-caption h5 {
        color: #fff;
    }

    @media (max-width: 767.98px) {
        .product-gallery-section .carousel-caption {
            position: static; /* Supprime le positionnement absolu sur mobile */
            width: auto;
            border-radius: 0;
            background-color: var(--dark-bg); /* S'assure d'avoir un fond même sans opacité */
            margin-top: 1rem;
        }
        .product-gallery-section .carousel-item img {
            height: 300px;
        }
    }


    /* --- Section Livraison et Paiement --- */
    .feature-card {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .feature-card i {
        color: var(--primary-color);
    }

    /* --- Section Avis Clients --- */
    .reviews-section {
        background: linear-gradient(135deg, var(--secondary-color), var(--dark-bg));
    }

    .review-card {
        background-color: rgba(255, 255, 255, 0.08) !important;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s ease, background-color 0.3s ease;
    }

    .review-card:hover {
        transform: translateY(-8px);
        background-color: rgba(255, 255, 255, 0.15) !important;
    }

    .review-avatar {
        width: 70px;
        height: 70px;
        object-fit: cover;
    }

    .review-card .card-title {
        color: var(--primary-color);
    }

    .review-card .card-text {
        color: rgba(255, 255, 255, 0.85);
    }

    /* --- Section Contact --- */
    .contact-section {
        background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
    }

    .contact-form {
        background-color: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px); /* Effet de flou sur l'arrière-plan du formulaire */
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .futuristic-input {
        background-color: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #fff;
        padding: 12px 18px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .futuristic-input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .futuristic-input:focus {
        background-color: rgba(255, 255, 255, 0.25);
        border-color: #fff;
        box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
        color: #fff;
    }
</style>

@endsection