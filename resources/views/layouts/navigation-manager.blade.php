<?php

use Illuminate\Support\Facades\Auth;

/** @var \App\Models\User|null $user */
$user = Auth::user();

$profilePictureUrl = null;

// On récupère l'URL de la photo de profil si elle existe
if ($user && $user->profil && $user->profil->url) {
    $profilePictureUrl = asset('storage/' . $user->profil->url);
} else {
    // Image par défaut (mets le chemin que tu veux)
    $profilePictureUrl = asset('images/google-logo.png');
}
?>

<div class="top-bar bg-dark text-white py-2 d-none d-md-block"> {{-- Added d-none d-md-block for mobile hiding --}}
    <div class="container d-flex justify-content-between align-items-center">
        <div class="left">
            <span><i class="fas fa-phone"></i> +237 672 037 300</span>
            <span class="ms-3"><i class="fas fa-envelope"></i> contact@njoya.com</span>
        </div>
        <div class="right">
            <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
            <a href="#" class="text-white"><i class="fab fa-pinterest"></i></a>
        </div>
    </div>
</div>

<header class="header bg-dark shadow-sm">
    <div class="container d-flex justify-content-between align-items-center py-2">
        <div class="logo">
            <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none text-white"> {{-- Added text-white for logo text --}}
                <img src="{{ asset('images/log.png') }}" alt="Logo" class="img-fluid me-2" style="max-height: 50px;">
            </a>
        </div>

        {{-- Navbar Toggler for mobile --}}
        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbarCollapse" aria-controls="mainNavbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Main Navigation Links --}}
        <nav class="navbar navbar-expand-lg navbar-dark d-none d-lg-block"> {{-- Hide on mobile, show on large screens --}}
            <ul class="navbar-nav">
                <li><a href="{{ route('home') }}" class="nav-link"><i class="fas fa-home"></i> Accueil</a></li>
                @if($user && $user->hasRole('client')) {{-- Added null check for $user --}}
                    <li><a href="{{ route('orders.index') }}" class="nav-link"><i class="fas fa-box"></i> Mes Commandes</a></li>
                    <li><a href="{{ route('products') }}" class="nav-link"><i class="fas fa-images"></i> Galerie</a></li>
                    <li><a href="{{ route('favorites') }}" class="nav-link"><i class="fas fa-heart"></i> Mes Favoris</a></li>
                    <li><a href="{{ route('profile.edit') }}" class="nav-link"><i class="fas fa-user"></i> Profil</a></li>
                    <li><a href="{{ route('home') }}#Contact" class="nav-link"><i class="fas fa-phone-alt"></i> Contact</a></li>
                @endif
            </ul>
        </nav>

        {{-- Search, Cart, User Dropdown, Dark Mode Toggle --}}
        <div class="search-cart d-flex align-items-center gap-3">
            

            {{-- User Profile Dropdown --}}
            <div class="dropdown">
                @guest {{-- If user is NOT logged in --}}
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 py-2">Connexion</a>
                @else {{-- If user is logged in --}}
                    <a class="btn profile-avatar dropdown-toggle p-0"
                       href="#"
                       role="button"
                       id="userProfileDropdown"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">
                        <img src="{{ $profilePictureUrl }}" alt="Profile Picture" class="rounded-circle object-fit-cover">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow-lg rounded" aria-labelledby="userProfileDropdown">
                        <li><h6 class="dropdown-header">{{ $user->name }}</h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-circle me-2"></i> Mon Profil
                            </a>
                        </li>
                        {{-- Add other manager-specific links here if needed --}}
                        @if($user->hasRole('manager'))
                            <li>
                                <a class="dropdown-item" href="{{ route('manager.dashboard') }}">
                                    <i class="fas fa-tools me-2"></i> Tableau de bord Manager
                                </a>
                            </li>
                        @endif
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                @endguest
            </div>

            {{-- Dark Mode Toggle Button --}}
            <button id="darkModeToggle" class="btn btn-outline-light rounded-pill px-3 py-2">
                <i class='fas fa-moon'></i> {{-- Initial icon for moon --}}
            </button>
        </div>
    </div>

    {{-- Collapsible Navbar for Mobile (Main Links) --}}
    <div class="collapse navbar-collapse d-lg-none" id="mainNavbarCollapse">
        <ul class="navbar-nav mx-auto text-center">
            <li class="nav-item"><a class="nav-link text-white" href="{{ route('home') }}"><i class="fas fa-home me-1"></i> Accueil</a></li>
            @if($user && $user->hasRole('client'))
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('orders.index') }}"><i class="fas fa-box"></i> Mes Commandes</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('products') }}"><i class="fas fa-images"></i> Galerie</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('favorites') }}"><i class="fas fa-heart"></i> Mes Favoris</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Profil</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="{{ route('home') }}#Contact"><i class="fas fa-phone-alt"></i> Contact</a></li>
            @endif
        </ul>
    </div>
</header>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid justify-content-between">
        {{-- Original Search Bar (Keep as is) --}}
        <div class="search-bar x-auto"   style="width: 40%;">
            <form action="{{ route('manager.products.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher des articles..." name="search" >
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- Navbar Toggler for Categories (mobile) --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span> Catégories
        </button>

        {{-- Original Categories Mega Menu --}}
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                @foreach($categories as $category)
                    <li class="nav-item dropdown mega-menu">
                        <a class="nav-link dropdown-toggle" href="#"
                           data-bs-toggle="dropdown"
                           data-bs-auto-close="outside"
                           aria-expanded="false">
                            {{ $category->name }}
                        </a>
                        <div class="dropdown-menu bg-dark dropdown-menu-dark" >
                            <div class="container">
                                <div class="row">
                                    @include('partials.subcategories', [
                                        'subcategories' => $category->children,
                                        'level' => 1
                                    ])
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="progress-bar-scroll"></div> {{-- Renamed for clarity and consistency with JS --}}
</nav>

{{-- Script for progress bar and dark mode --}}
<script>
    // Script pour la barre de progression au défilement
    document.addEventListener('DOMContentLoaded', () => {
        const progressBar = document.querySelector('.progress-bar-scroll');

        window.addEventListener('scroll', () => {
            const totalHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrollPosition = document.documentElement.scrollTop;
            const progress = (scrollPosition / totalHeight) * 100;
            progressBar.style.width = progress + '%';
        });

       
     });
</script>

<style>

/* Base body styles for light mode */
body {
    transition: background-color 0.3s ease, color 0.3s ease;
}



/* --- Profile Avatar Dropdown --- */
.profile-avatar {
    width: 60px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid transparent; /* Initial border */
    transition: border-color 0.2s ease, transform 0.2s ease;
    display: flex; /* Ensure content is centered if no image */
    align-items: center;
    justify-content: center;
    font-size: 1.5rem; /* For the fallback icon */
    color: #fff; /* For the fallback icon */
}

.profile-avatar:hover {
    border-color: var(--primary-color); /* Primary color on hover */
    transform: translateY(-2px); /* Slight lift effect */
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}





/* --- Dark Mode Toggle Button --- */
#darkModeToggle {
    border-color: var(--primary-color);
    color: var(--primary-color);
    transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, transform 0.2s ease;
}

#darkModeToggle:hover {
    background-color: var(--primary-color);
    color: #fff;
    transform: translateY(-2px);
}

body.dark-mode #darkModeToggle {
    background-color: var(--primary-color); /* Active dark mode state */
    color: #fff;
    border-color: var(--primary-color);
}

body.dark-mode #darkModeToggle:hover {
    background-color: darken(var(--primary-color), 10%); /* Adjust shade for hover in dark mode */
}


/* --- General Responsive Adjustments for Navbar --- */
@media (max-width: 991.98px) { /* For screens smaller than 'lg' breakpoint */
    .top-bar {
        display: none !important; /* Explicitly hide top bar on mobile */
    }

    .header .navbar-nav {
        text-align: center;
        width: 100%;
        background-color: var(--dark-bg); /* Background for mobile collapsed menu */
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 1rem;
        padding-bottom: 1rem;
    }

    .header .navbar-nav .nav-item .nav-link {
        color: #fff; /* White links for dark mobile menu */
        padding: 0.75rem 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05); /* Separator */
    }

    .header .navbar-nav .nav-item:last-child .nav-link {
        border-bottom: none; /* No separator for last item */
    }

    .header .d-lg-none { /* Ensure the toggler is visible */
        display: block !important;
    }

    .navbar-toggler {
        border-color: rgba(255, 255, 255, 0.1);
    }
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml,%3csvg xmlns='[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.55%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    /* Adjustments for the second navbar's collapse on mobile */
    .navbar-dark .navbar-collapse {
        background-color: var(--dark-bg);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        position: absolute; /* Position the collapsed menu */
        width: 100%;
        left: 0;
        top: 100%;
        z-index: 1020;
    }
}



/* --- Utility Classes --- */
.rounded-pill {
    border-radius: 50rem !important;
}

.object-fit-cover {
    object-fit: cover;
}
</style>