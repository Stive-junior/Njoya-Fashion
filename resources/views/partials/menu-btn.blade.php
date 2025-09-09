@php
    $user = Auth::user();
    if($user){
    $cartCount = $user->panier ? $user->panier->items->count() : 0;
    }else{
    $cartItems = Session::get('cart.items', []);
    $cartCount = is_array($cartItems) ? count($cartItems) : 0;
    }

    /** @var \App\Models\User $user */
    $user = Auth::user();

    $totalFavorites =  $user ? $user->favorites()->count() : 0;
@endphp

<style>
    /* Style de base amélioré */
    .ultra-menu-container {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
    }
    
    .ultra-menu-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6e8efb, #a777e3);
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        transform: scale(1);
        position: relative;
    }
    
    .ultra-menu-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.4);
    }
    
    .ultra-menu-btn.active {
        transform: rotate(45deg) scale(1.1);
        background: linear-gradient(135deg,rgb(251, 140, 110),rgb(227, 119, 119));
    }
    
    /* Badge pour le panier */
    .cart-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background: #ff4757;
        color: white;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }
    
    .ultra-menu-btn:hover .cart-badge {
        transform: scale(1.1);
    }
    
    /* Options du menu améliorées */
    .ultra-menu-options {
        position: absolute;
        bottom: 70px;
        right: 0;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 15px;
        opacity: 0;
        pointer-events: none;
        transform: translateY(20px);
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    .ultra-menu-options.active {
        opacity: 1;
        pointer-events: all;
        transform: translateY(0);
    }
    
    .ultra-menu-option {
        padding: 12px 20px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transform: translateX(20px);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .ultra-menu-options.active .ultra-menu-option {
        transform: translateX(0);
        opacity: 1;
    }
    
    /* Animation en cascade améliorée */
   
    <?php for ($i = 1; $i <= 10; $i++): ?>
        .ultra-menu-options.active .ultra-menu-option:nth-child(<?= $i ?>) { 
            transition-delay: <?= 0.05 * $i ?>s;
        }
    <?php endfor; ?>


    
    .ultra-menu-option:hover {
       background: linear-gradient(135deg, #6e8efb, #a777e3);
        transform: scale(1.05) translateX(0) !important;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }
    
    .ultra-menu-option i {
        font-size: 18px;
        width: 20px;
        text-align: center;
    }
    
    /* Style spécifique pour les liens */
    .ultra-menu-option.text-white {
        color: white !important;
    }
    
    .ultra-menu-option.text-white:hover {
        color: #6e8efb !important;
    }
    
    
    @media (max-width: 768px) {
        .ultra-menu-container {
            bottom: 80px;
            right: 20px;
        }
        
        .ultra-menu-btn {
            width: 50px;
            height: 50px;
            font-size: 20px;
        }
        
        .ultra-menu-options {
            bottom: 60px;
        }
    }
</style>

<div class="ultra-menu-container">
    <button class="ultra-menu-btn" id="ultraMenuBtn">
        <i class="fas fa-bars"></i>
        @if($cartCount + $totalFavorites > 0)
            <span class="cart-badg item-quantity top-0 " id="cartBadge">{{ $cartCount + $totalFavorites }}</span>
        @endif
    </button>
    
    <div class="ultra-menu-options" id="ultraMenuOptions">
        <a class="ultra-menu-option" href="{{ route('home') }}">
            <i class="fas fa-home"></i> Accueil
        </a>
      
        @auth
        @if($user->hasRole('client'))
            <a class="ultra-menu-option" href="{{ route('orders.index') }}">
                <i class="fas fa-box"></i> Mes Commandes
            </a>
            
            <a class="ultra-menu-option" href="{{ route('products') }}">
                <i class="fas fa-images"></i> Galerie
            </a>
            
            <a class="ultra-menu-option" href="{{ route('favorites') }}">
                <i class="fas fa-heart"></i> Favoris
                 @if($totalFavorites > 0)
                    <span class="item-quantity">{{ $totalFavorites }}</span>
                @endif
            </a>
            
            <a class="ultra-menu-option" href="{{ route('cart') }}">
                <i class="fas fa-shopping-cart"></i> Panier
                @if($cartCount > 0)
                    <span class="item-quantity">{{ $cartCount }}</span>
                @endif
            </a>
            
            <a class="ultra-menu-option" href="{{ route('profile.edit') }}">
                <i class="fas fa-user"></i> Profil
            </a>
            
            <a class="ultra-menu-option" href="{{ route('home') }}#Contact">
                <i class="fas fa-phone-alt"></i> Contact
            </a>
        @endif

        @if($user->hasRole('manager'))
            <a class="ultra-menu-option" href="{{ route('manager.products.index') }}">
                <i class="fas fa-cube"></i> Produits
            </a>
            
            <a class="ultra-menu-option" href="{{ route('manager.orders.index') }}">
                <i class="fas fa-clipboard-list"></i> Commandes
            </a>
            
            <a class="ultra-menu-option" href="{{ route('manager.users.index') }}">
                <i class="fas fa-users"></i> Utilisateurs
            </a>
        @endif

        @if($user->hasRole('livreur'))
            <a class="ultra-menu-option" href="{{ route('livreur.missions') }}">
                <i class="fas fa-truck"></i> Livraisons
            </a>
            
            <a class="ultra-menu-option" href="{{ route('livreur.stats') }}">
                <i class="fas fa-chart-line"></i> Statistiques
            </a>
        @endif
        @endauth

        @if(!Auth::user())

            
            <a class="ultra-menu-option" href="{{ route('products') }}">
                <i class="fas fa-images"></i> Galerie
            </a>

            
            <a class="ultra-menu-option" href="{{ route('cart') }}">
                <i class="fas fa-shopping-cart"></i> Panier
                @if($cartCount > 0)
                    <span class="item-quantity">{{ $cartCount }}</span>
                @endif
            </a>
            
            <a class="ultra-menu-option" href="{{ route('login') }}">
                <i class="fas fa-user"></i> profil
            </a>
            
            <a class="ultra-menu-option" href="{{ route('home') }}#Contact">
                <i class="fas fa-phone-alt"></i> Contact
            </a>
        @endif


    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuBtn = document.getElementById('ultraMenuBtn');
        const menuOptions = document.getElementById('ultraMenuOptions');
        
        // Toggle menu avec animation fluide
        menuBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            this.classList.toggle('active');
            menuOptions.classList.toggle('active');
        });
        
        // Fermer le menu quand on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!menuBtn.contains(e.target) && !menuOptions.contains(e.target)) {
                menuBtn.classList.remove('active');
                menuOptions.classList.remove('active');
            }
        });
        
        // Empêcher la fermeture quand on clique dans le menu
        menuOptions.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        // Mise à jour dynamique du badge panier (exemple)
        function updateCartCount(count) {
            const badge = document.getElementById('cartBadge');
            if (count > 0) {
                if (!badge) {
                    const newBadge = document.createElement('span');
                    newBadge.id = 'cartBadge';
                    newBadge.className = 'cart-badge';
                    newBadge.textContent = count;
                    menuBtn.appendChild(newBadge);
                } else {
                    badge.textContent = count;
                }
            } else if (badge) {
                badge.remove();
            }
        }
        
        // Exemple d'utilisation (à adapter avec votre logique)
        // updateCartCount(5);
    });
</script>