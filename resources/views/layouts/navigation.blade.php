@php
    $user = Auth::user();
    $cartCount = $user->panier ? $user->panier->items->count() : 0;
   


/** @var \App\Models\User|null $user */
$user = Auth::user();

$profilePictureUrl = null;

// On récupère l'URL de la photo de profil si elle existe
if ($user && $user->profil && $user->profil->url) {
    $profilePictureUrl = asset('storage/' . $user->profil->url);
} else {
    // Image par défaut (mets le chemin que tu veux)
    $profilePictureUrl = asset('images/default-avatar.png');
}

@endphp


<div class="top-bar bg-dark text-white py-2">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="left">
                <span><i class="fas fa-phone"></i> +33 1 23 45 67 89</span>
                <span class="ms-3"><i class="fas fa-envelope"></i> contact@njoya.com</span>
            </div>
            <div class="right">
                <a href="#" class="text-white me-3 social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white me-3 social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white me-3 social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white social-icon"><i class="fab fa-pinterest"></i></a>
            </div>
        </div>
    </div>
</div>


<header class="header bg-dark shadow-sm d-lg-none">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center py-2">
           
            <div class="logo d-flex align-items-center gap-2">
                <button class="btn menu-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenuUser" aria-label="Menu">
                    <span class="menu-icon">
                         <svg viewBox="0 0 24 24" class="w-7 h-7 text-afrixTextGray dark:text-afrixMediumGray hover:text-afrixRed dark:hover:text-afrixLightGray transition-colors duration-300">
                            <path d="M3.75 8.5C3.75 8.08579 4.08579 7.75 4.5 7.75H5.75C6.16421 7.75 6.5 8.08579 6.5 8.5C6.5 8.91421 6.16421 9.25 5.75 9.25H4.5C4.08579 9.25 3.75 8.91421 3.75 8.5ZM3.75 12C3.75 11.5858 4.08579 11.25 4.5 11.25H5.75C6.16421 11.25 6.5 11.5858 6.5 12C6.5 12.4142 6.16421 12.75 5.75 12.75H4.5C4.08579 12.75 3.75 12.4142 3.75 12ZM3.75 15.5C3.75 15.0858 4.08579 14.75 4.5 14.75H5.75C6.16421 14.75 6.5 15.0858 6.5 15.5C6.5 15.9142 6.16421 16.25 5.75 16.25H4.5C4.08579 16.25 3.75 15.9142 3.75 15.5ZM4.25 3C2.45507 3 1 4.45507 1 6.25V17.75C1 19.5449 2.45508 21 4.25 21H19.75C21.5449 21 23 19.5449 23 17.75V6.25C23 4.45507 21.5449 3 19.75 3H4.25ZM19.75 19.5H9V4.5H19.75C20.7165 4.5 21.5 5.2835 21.5 6.25V17.75C21.5 18.7165 20.7165 19.5 19.75 19.5ZM4.25 4.5H7.5V19.5H4.25C3.2835 19.5 2.5 18.7165 2.5 17.75V6.25C2.5 5.2835 3.2835 4.5 4.25 4.5Z" fill="currentColor"></path>
                        </svg>
                    </span>
                </button>
                <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                     <img src="{{ asset('images/log.png') }}" alt="Logo" class="img-fluid" style="max-height: 30px;">
                    
                </a>
            </div>


            <div class="d-flex align-items-center gap-2">
               
                <a href="{{ route('cart') }}" class="btn futuristic-btn position-relative">
                    <i class="bx bxs-cart"></i>
                    @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle item-quantity rounded-pill bg-danger">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <input type="checkbox" id="darkbtn" class="d-none">
                <input type="checkbox" id="darkbtn" class="d-none">
                    <label for="darkbtn" class="text-white btn futuristic-btn">
                        <i class='bx bxs-sun futuristic-icon'></i>
                    </label>

                <a class="btn profile futuristic-btn" 
                   style="background-image: url('<?= $profilePictureUrl ? $profilePictureUrl : asset('images/default-avatar.png') ?>'); 
                          background-size: cover; background-position: center; width: 36px; height: 36px;">
                    <?php

                                                    use Illuminate\Support\Facades\Auth;

 if(!$profilePictureUrl): ?>
                        <i class="bx bxs-user"></i>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </div>
</header>


<header class="header bg-dark shadow-sm d-none d-lg-block">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-1">
          
            <div class="logo">
                <a href="{{ route('home') }}" class="d-flex align-items-center">
                    <img src="{{ asset('images/log.png') }}" alt="Logo" class="img-fluid" style="max-height: 50px;">
                    
                </a>
            </div>

           
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li><a href="{{ route('home') }}" style="--navAni:1"><i class="fas fa-home"></i> Accueil</a></li>
                        
                        @if($user->hasRole('client'))
                            <li><a href="{{ route('orders.index') }}" style="--navAni:2"><i class="fas fa-box"></i> Mes Commandes</a></li>
                            <li><a href="{{ route('products') }}" style="--navAni:3"><i class="fas fa-images"></i> Galerie</a></li>
                            <li><a href="{{ route('favorites') }}" style="--navAni:4"><i class="fas fa-heart"></i> Mes Favoris</a></li>
                            <li><a href="{{ route('profile.edit') }}" style="--navAni:5"><i class="fas fa-user"></i> Profil</a></li>
                            <li><a href="{{ route('home') }}#Contact" style="--navAni:6"><i class="fas fa-phone-alt"></i> Contact</a></li>
                        @endif

                        @if($user->hasRole('manager'))
                            <li><a href="{{ route('manager.products.index') }}" style="--navAni:2"><i class="fas fa-cube"></i> Produits</a></li>
                            <li><a href="{{ route('manager.orders.index') }}" style="--navAni:3"><i class="fas fa-clipboard-list"></i> Commandes</a></li>
                            <li><a href="{{ route('manager.users.index') }}" style="--navAni:4"><i class="fas fa-users"></i> Utilisateurs</a></li>
                        @endif

                        @if($user->hasRole('livreur'))
                            <li><a href="{{ route('livreur.missions') }}" style="--navAni:2"><i class="fas fa-truck"></i> Livraisons</a></li>
                            <li><a href="{{ route('livreur.stats') }}" style="--navAni:3"><i class="fas fa-chart-line"></i> Statistiques</a></li>
                        @endif
                    </ul>
                </div>
            </nav>

      
            <div class="search-cart d-flex align-items-center gap-3">
                <a class="btn profile futuristic-btn" href="#"  
                   style="background-image: url('<?= $profilePictureUrl ? $profilePictureUrl : asset('images/default-avatar.png') ?>'); 
                          background-size: cover; background-position: center; width: 40px; height: 40px;">
                    <?php if(!$profilePictureUrl): ?>
                        <i class="bx bxs-user"></i>
                    <?php endif; ?>
                </a>

                <a href="{{ route('cart') }}" class="btn futuristic-btn position-relative">
                    <i class="bx bxs-cart"></i>
                    @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle item-quantity rounded-pill bg-danger">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
               
              <input type="checkbox" id="darkbtn_checkbox" class="d-none"> {{-- Changed ID to avoid conflict --}}
<label for="darkbtn_checkbox" class="btn futuristic-icon bg-transparent hover:text-white" id="darkModeToggleButton"> {{-- Added new ID here --}}
    <i class='bx bxs-moon futuristic-icon text-white'></i>
</label>
            </div>
        </div>
    </div>
</header>


<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileMenuUser" style="width: 280px;">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title">Menu Utilisateur</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('home') }}"><i class="fas fa-home me-2"></i> Accueil</a>
            </li>
            
            @if($user->hasRole('client'))
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('orders.index') }}"><i class="fas fa-box me-2"></i> Mes Commandes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('products') }}"><i class="fas fa-images me-2"></i> Galerie</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('favorites') }}"><i class="fas fa-heart me-2"></i> Mes Favoris</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i> Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('home') }}#Contact"><i class="fas fa-phone-alt me-2"></i> Contact</a>
                </li>
            @endif

            @if($user->hasRole('manager'))
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('manager.products.index') }}"><i class="fas fa-cube me-2"></i> Produits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('manager.orders.index') }}"><i class="fas fa-clipboard-list me-2"></i> Commandes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('manager.users.index') }}"><i class="fas fa-users me-2"></i> Utilisateurs</a>
                </li>
            @endif

            @if($user->hasRole('livreur'))
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('livreur.missions') }}"><i class="fas fa-truck me-2"></i> Livraisons</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('livreur.stats') }}"><i class="fas fa-chart-line me-2"></i> Statistiques</a>
                </li>
            @endif
        </ul>


        <div class="mt-4">
            <div class="border-bottom">
                <h5 class="px-3 mb-3 text-bold py-1">Catégories</h5>
            </div>
            <div class="accordion" id="mobileCategoriesUser">
                @foreach($categories as $category)
                <div class="accordion-item bg-dark border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUser{{ $category->id }}">
                            <i class="fas fa-caret-right me-2"></i> {{ $category->name }}
                        </button>
                    </h2>
                    <div id="collapseUser{{ $category->id }}" class="accordion-collapse collapse" data-bs-parent="#mobileCategoriesUser">
                        <div class="accordion-body p-0">
                            @include('partials.mobile-subcategories', ['subcategories' => $category->children])
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
      
        <div class="search-ba mx-auto" style="max-width: 40%; min-width: 40px;">
            <form action="{{ route('products') }}" method="GET" class="w-100">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Rechercher des articles..." name="search">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <!-- Menu catégories -->
        <div class="ms-auto">
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
                        <div class="dropdown-menu bg-dark dropdown-menu-dark">
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
    </div>
    <div class="progress-bar"></div>
</nav>

@if(isset($subCategory))
    <div class="subcategory-sticky bg-dark justify-content-between align-items-center mb-4">
        <h5 class="mx-2">{{ $subCategory->name }}</h5>
        <div class="d-flex justify-content-around flex-wrap" style="gap: 10px;">
            <a href="{{ request()->fullUrlWithQuery(['subsubcategory' => null, 'page' => null]) }}" 
               class="subcategory-item {{ !request()->has('subsubcategory') ? 'active' : '' }}">
                <i class="fas fa-list"></i> Toutes
            </a>
            @foreach($subCategory->children as $child)
                <a href="{{ request()->fullUrlWithQuery(['subsubcategory' => $child->id, 'page' => null]) }}" 
                   class="subcategory-item {{ request()->subsubcategory == $child->id ? 'active' : '' }}">
                    <i class=<?=getCategoryIcon($child->name)?> ></i> {{ $child->name }}
                </a>
            @endforeach
        </div>
    </div>
@endif

<style>
    /* Styles existants conservés */
    .subcategory-sticky {
        transition: all 0.3s ease;
    }
    
    .mega-menu .dropdown-menu {
        width: 100vw;
        left: 50% !important;
        transform: translateX(-50%);
        padding: 1rem;
    }
    
    .navbar-nav .nav-item {
        position: static;
    }
    
    .accordion-button:not(.collapsed) {
        color: #fff;
        background-color: rgba(255,255,255,0.1);
    }
    
    .accordion-button:focus {
        box-shadow: none;
    }
    
    /* Styles pour le menu hamburger */
    .menu-btn {
        background-color: rgba(255, 255, 255, 0.1);
        border: none;
        cursor: pointer;
        padding: 8px;
        width: 38px;
        height: 35px;
        position: relative;
        transition: all 0.3s ease;
        border-radius: 4px;
    }
    
    .menu-btn:hover {
        background-color: var(--or);
    }
    
    .menu-btn:hover .menu-bar {
        background: var(--bs-dark);
    }
    
    .menu-icon {
        display: block;
        position: relative;
        width: 23px;
        height: 18px;
    }
    
    .menu-bar {
        position: absolute;
        display: block;
        width: 100%;
        height: 3px;
        background-color: var(--or);
        border-radius: 1px;
        transition: all 0.3s ease;
    }
    
    .top-bar {
        top: 0;
    }
    
    .middle-bar {
        top: 50%;
        transform: translateY(-50%);
    }
    
    .bottom-bar {
        bottom: 0;
    }
    
    @media (max-width: 992px) {
        .search-bar {
            width: 100% !important;
            max-width: 100% !important;
            margin-bottom: 1rem;
        }
        
        .navbar-collapse {
            width: 100%;
        }
        
        .header {
            position: sticky;
            top: 0;
            z-index: 1020;
        }
        
        .profile {
            width: 36px !important;
            height: 36px !important;
        }
    }
</style>



<style>

     .profile-swal {
        background: linear-gradient(135deg, #1e1e2f 0%, #2d2d44 100%);
        border-radius: 12px;
        border: 1px solid var(--or);
        color: white;
    }
    .profile-swal .swal2-title {
        color: var(--or);
        font-size: 1.5rem;
    }
    .profile-swal .swal2-html-container {
        color: #e0e0e0;
    }

    .image-preview-popup {
        max-width: 90vw !important;
        max-height: 90vh !important;
    }
    .image-preview-close {
        color: white;
        font-size: 2rem;
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1060;
    }
    .swal2-image {
        max-height: 80vh;
        object-fit: contain;
    }
</style>

<script>

    document.addEventListener('DOMContentLoaded', function() {
  
        const navbar = document.querySelector('.navbar');
        const subcategorySticky = document.querySelector('.subcategory-sticky');
        
        if (subcategorySticky) {
            subcategorySticky.style.top = navbar.offsetHeight + 'px';
        }
        
       


    const profileBtn = document.querySelectorAll('.profile').forEach(btn =>{
        btn.addEventListener('click', function(){
          
             Swal.fire({
                title: '<strong>Mon Profil</strong>',
                html: `
                    <div class="text-center">
                        <div class="profile-avatar mb-3" 
                             style="background-image: url('${this.style.backgroundImage.replace(/url\(['"]?(.*?)['"]?\)/i, "$1")}');
                                    width: 100px; height: 100px; border-radius: 50%; 
                                    margin: 0 auto; background-size: cover; background-position: center;
                                    border: 3px solid var(--or);">
                            ${this.querySelector('i') ? '<i class="bx bxs-user" style="font-size: 40px; line-height: 94px; color: white;"></i>' : ''}
                        </div>
                        <h5 class="mt-2">${'<?= Auth::user()->name ?>'}</h5>
                        <p class="text-warning">${'<?= Auth::user()->email ?>'}</p>
                    </div>
                `,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: '<i class="bx bx-edit"></i> Modifier le profil',
                cancelButtonText: '<i class="bx bx-log-out"></i> Déconnexion',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-primary me-2',
                    cancelButton: 'btn btn-danger',
                    popup: 'profile-swal'
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('profile.edit') }}";
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                   
                    Swal.fire({
                        title: 'Déconnexion',
                        text: 'Êtes-vous sûr de vouloir vous déconnecter?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Oui, déconnecter',
                        cancelButtonText: 'Annuler',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'btn btn-danger me-2',
                            cancelButton: 'btn btn-secondary'
                        }
                    }).then((logoutResult) => {
                        if (logoutResult.isConfirmed) {
                            document.getElementById('logout-form').submit();
                        }
                    });
                }
            });
            
        })
    });
    
  
});


document.body.insertAdjacentHTML('beforeend', `
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
`);


</script>