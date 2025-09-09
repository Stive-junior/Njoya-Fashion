@php
   
    $cartItems = Session::get('cart.items', []);
    $cartCount = is_array($cartItems) ? count($cartItems) : 0;
@endphp


<div class="top-bar bg-dark text-white py-2">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div class="left">
                <span><i class="fas fa-phone"></i> +237 672 03 73 00</span>
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
   
    <button 
        class="btn menu-btn d-flex align-items-center justify-content-center p-0" 
        type="button" 
        data-bs-toggle="offcanvas" 
        data-bs-target="#mobileMenu"
        aria-label="Menu">
        <span class="menu-icon">
            <span class="menu-bar top-bar"></span>
            <span class="menu-bar middle-bar"></span>
            <span class="menu-bar bottom-bar"></span>
        </span>
    </button>

 
    <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
        <strong>Njoya Fashion</strong>
    </a>
</div>

        
            <div class="d-flex">
                <a href="{{ route('login') }}" class="btn futuristic-btn text-white me-2">
                    <i class="bx bxs-user futuristic-icon"></i>
                </a>
               
                <a href="{{ route('cart') }}" class="btn futuristic-btn position-relative">
                    <i class="bx bxs-cart"></i>
                    @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle item-quantity rounded-pill bg-danger">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                
                <button id="darkbtn" class="btn btn-outline-light rounded-pill px-3 py-2">
                <i class='fas fa-moon'></i> {{-- Initial icon for moon --}}
            </button>

                <input type="checkbox" id="darkbtn" class="d-none">
                    <label for="darkbtn" class="text-white btn futuristic-btn">
                        <i class='bx bxs-sun futuristic-icon'></i>
                    </label>
            </div>
        </div>
    </div>
</header>


<header class="header bg-dark shadow-sm d-none d-lg-block">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center py-1">
          
            <div class="logo">
                <a href="{{ route('home') }}" class="d-flex align-items-center">
                    <img src="{{ asset('images/log.png') }}" alt="" class="img-fluid" style="max-height: 50px;">
                    <strong class="ms-2">Njoya Fashion</strong>
                </a>
            </div>
    
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li><a href="{{ route('home') }}" style="--navAni:1"><i class="fas fa-home"></i> Accueil</a></li>
                        <li><a href="{{ route('products') }}" style="--navAni:2"><i class="fas fa-images"></i> Galerie</a></li>
                        <li><a href="{{ route('home')}}#Livraison" style="--navAni:3"><i class="fas fa-car"></i> Livraison</a></li>
                        <li><a href="{{ route('home') }}#Avis" style="--navAni:4"><i class="fas fa-home"></i> Avis</a></li>
                        <li><a href="{{ route('home') }}#Contact" style="--navAni:5"><i class="fas fa-phone-alt"></i> Contact</a></li>
                    </ul>
                </div>
            </nav>

          
            <div class="search-cart">
                <div class="d-flex align-items-center">
                    <a href="{{ route('login') }}" title="Connectez vous" class="btn futuristic-btn text-white me-3">
                        <i class="bx bxs-user futuristic-icon"></i>
                    </a>
                    
                <a href="{{ route('cart') }}" class="btn futuristic-btn position-relative">
                    <i class="bx bxs-cart"></i>
                    @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle item-quantity rounded-pill bg-danger">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                    <input type="checkbox" id="darkbtn" class="d-none">
                    <label for="darkbtn" class="text-white btn futuristic-btn">
                        <i class='bx bxs-sun futuristic-icon'></i>
                    </label>
                </div>
            </div>
        </div>
    </div>
</header>


<div class="offcanvas offcanvas-start  men text-white" tabindex="-1" id="mobileMenu" style="width: 280px;">
    <div class="offcanvas-header border-bottom">
       

         <div class="logo offcanvas-title">
                <a href="{{ route('home') }}" class="d-flex align-items-center">
                    <img src="{{ asset('images/log.png') }}" alt="" class="img-fluid" style="max-height: 30px;">
                   
                </a>
            </div>
    

        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body ">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('home') }}"><i class="fas fa-home me-2"></i> Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('products') }}"><i class="fas fa-images me-2"></i> Galerie</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('home')}}#Livraison"><i class="fas fa-car me-2"></i> Livraison</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('home') }}#Avis"><i class="fas fa-home me-2"></i> Avis</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('home') }}#Contact"><i class="fas fa-phone-alt me-2"></i> Contact</a>
            </li>
        </ul>
        
      
        <div class="mt-4">
                <div class="border-bottom">
            <h5 class="px-3 mb-3 text-bold py-1">Catégories</h5>
                </div>
            <div class="accordion " id="mobileCategories">
                @foreach($categories as $category)
                <div class="accordion-item bg-[var(--brun)] border-0">
                    <h2 class="accordion-header">
                        
                        <button class="accordion-button collapsed men text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $category->id }}">
                          <i class="fas fa-caret-right me-2"></i>   {{ $category->name }}
                        </button>
                    </h2>
                    <div id="collapse{{ $category->id }}" class="accordion-collapse collapse" data-bs-parent="#mobileCategories">
                        <div class="accordion-body men p-2">
                            @include('partials.mobile-subcategories', ['subcategories' => $category->children])

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


<div class="sticky-header sticky-top">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="z-index: 1030;">
        <div class="container-fluid">
    
            <div class="search-bar" style="max-width: 40%; min-width: 40px;">
                <form action="{{ route('products') }}" method="GET" class="w-100">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Rechercher des articles..." name="search">
                        <button class="btn btn-outline-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>

   
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
                    <i class="{{ getCategoryIcon($child->name) }}" ></i> {{ $child->name }}
                </a>
            @endforeach
        </div>
    </div>
@endif

    
   
</div>


<style>

    .men{
        background: linear-gradient(145deg, var(--black-1), var(--brun)) !important;
    }
   
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
    }



    .menu-btn {
        background-color: rgba(255, 255, 255, 0.1);
        border: none;
        cursor: pointer;
        padding: 0px;
        width: 38px;
        height: 35px;
        position: relative;
        transition: all 0.3s ease;
    }


    .menu-btn:hover {
        background-color: var(--or);
        border-radius: 10%;
    }

    .menu-btn:hover .menu-bar{
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
        top: -2px;
    }

    .middle-bar {
        top: 36%;
       
    }

    .bottom-bar {
        bottom: 0;
    }

  




</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
  

        const navbar = document.querySelector('.navbar');
        const subcategorySticky = document.querySelector('.subcategory-sticky');
        
        if (subcategorySticky) {
            subcategorySticky.style.top = navbar.offsetHeight + 'px';
        }
        
  
        
    });
</script>