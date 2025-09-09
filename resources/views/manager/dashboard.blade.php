@php

$profilePicture = null;


if(Auth::check() && Auth::user()->profil){
 $profilePicture = Auth::user()->profil->first()->url;
}


@endphp



@extends('layouts.manager')

@section('content')
<div class="manager-dashboard">
    <div class="dashboard-main py-3">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-lg-3 mb-4" data-scroll>
                    <div class="dashboard-nav">
                        <div class="nav-header">
                            <h4><i class="fas fa-bars me-2"></i> Menu Manager</h4>
                        </div>
                        <ul class="nav-menu">
                            <li class="nav-item">
                                <a class="{{ request()->is('manager/dashboard') ? 'active' : '' }}" href="{{ route('manager.dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i>
                                    <span>Tableau de bord</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="{{ request()->is('manager/products*') ? 'active' : '' }}" href="{{ route('manager.products.index') }}">
                                    <i class="fas fa-box"></i>
                                    <span>Produits</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="{{ request()->is('manager/categories*') ? 'active' : '' }}" href="{{ route('manager.categories.index') }}">
                                    <i class="fas fa-list"></i>
                                    <span>Catégories</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="{{ request()->is('manager/orders*') ? 'active' : '' }}" href="{{ route('manager.orders.index') }}">
                                    <i class="fas fa-shopping-bag"></i>
                                    <span>Commandes</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="{{ request()->is('manager/promotions*') ? 'active' : '' }}" href="{{ route('manager.promotions.index') }}">
                                    <i class="fas fa-tags"></i>
                                    <span>Promotions</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="{{ request()->is('manager/coupons*') ? 'active' : '' }}" href="{{ route('manager.coupons.index') }}">
                                    <i class="fas fa-percentage"></i>
                                    <span>Coupons</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="{{ request()->is('manager/returns*') ? 'active' : '' }}" href="{{ route('manager.returns.index') }}">
                                    <i class="fas fa-exchange-alt"></i>
                                    <span>Retours</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="{{ request()->is('manager/users*') ? 'active' : '' }}" href="{{ route('manager.users.index') }}">
                                    <i class="fas fa-users"></i>
                                    <span>Utilisateurs</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                
             
                <div class="col-lg-9">
                    
                    <div class="dashboard-header mb-4 rounded-5">
                        <div class="container-fluid py-3">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h1 class="dashboard-title">
                                        <i class="fas fa-tachometer-alt me-2"></i> Tableau de Bord
                                    </h1>
                                </div>
                                <div class="col-md-6 text-end">
                                    <div class="admin-profile">
                                        <img src="<?=  $profilePicture ? asset('storage/' . $profilePicture) : asset('storage/profile/junior-nana-profile-1743123318.png') ?>" 
                                             alt="{{ Auth::user()->name }}" 
                                             class="profile-img rounded-circle">
                                        <span class="profile-name ms-2">{{ Auth::user()->name }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="dashboard-stats mb-4">
                        <div class="container-fluid">
                            <div class="row g-4">
                                <div class="col-md-6 col-lg-3 py-3" data-scroll>
                                    <div class="stat-card bg-primary">
                                        <div class="stat-icon">
                                            <i class="fas fa-box-open"></i>
                                        </div>
                                        <div class="stat-info">
                                            <h3>{{ $productsCount }}</h3>
                                            <p>Produits</p>
                                            <a href="{{ route('manager.products.index') }}" class="stat-link">Voir tous <i class="fas fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-3 py-3" data-scroll>
                                    <div class="stat-card bg-success">
                                        <div class="stat-icon">
                                            <i class="fas fa-shopping-bag"></i>
                                        </div>
                                        <div class="stat-info">
                                            <h3>{{ $ordersCount }}</h3>
                                            <p>Commandes</p>
                                            <a href="{{ route('manager.orders.index') }}" class="stat-link">Voir toutes <i class="fas fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-3 py-3" data-scroll>
                                    <div class="stat-card bg-warning">
                                        <div class="stat-icon">
                                            <i class="fas fa-tags"></i>
                                        </div>
                                        <div class="stat-info">
                                            <h3>{{ $promotionsCount }}</h3>
                                            <p>Promotions</p>
                                            <a href="{{ route('manager.promotions.index') }}" class="stat-link">Voir toutes <i class="fas fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-lg-3 py-3" data-scroll>
                                    <div class="stat-card bg-danger">
                                        <div class="stat-icon">
                                            <i class="fas fa-exchange-alt"></i>
                                        </div>
                                        <div class="stat-info">
                                            <h3>{{ $returnsCount }}</h3>
                                            <p>Retours</p>
                                            <a href="{{ route('manager.returns.index') }}" class="stat-link">Voir tous <i class="fas fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 
                    <div class="row mb-4">
                        <div class="col-md-4 col-lg-4 py-3" data-scroll>
                            <div class="stat-card bg-info">
                                <div class="stat-icon">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                                <div class="stat-info">
                                    <h3>{{ number_format($todaySales, 0, ',', ' ') }} FCFA</h3>
                                    <p>Ventes aujourd'hui</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-lg-4 py-3" data-scroll>
                            <div class="stat-card bg-purple">
                                <div class="stat-icon">
                                    <i class="fas fa-calendar-month"></i>
                                </div>
                                <div class="stat-info">
                                    <h3>{{ number_format($monthlySales, 0, ',', ' ') }} FCFA</h3>
                                    <p>Ventes ce mois</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-lg-4 py-3" data-scroll>
                            <div class="stat-card bg-dark">
                                <div class="stat-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="stat-info">
                                    <h3>{{ number_format($averageOrderValue, 0, ',', ' ') }} FCFA</h3>
                                    <p>Panier moyen</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                   
                    <div class="dashboard-card mb-4" data-scroll>
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3><i class="fas fa-shopping-bag me-2"></i> Dernières Commandes</h3>
                            @if($recentOrders->IsNotEmpty())
                            <a href="{{ route('manager.orders.index') }}" class="btn btn-sm btn-outline-primary">
                                Voir tout <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                            @endif
                        </div>
                        
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                @if($recentOrders->IsNotEmpty())
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Client</th>
                                            <th>Date</th>
                                            <th>Total</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentOrders as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td>
                                            <td>
                                                <span class="badge bg-{{ $order->status_color }}">
                                                    {{ $order->status_label }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('manager.orders.show', $order->id) }}" 
                                                   class="btn btn-sm btn-primary" 
                                                   title="Voir détails">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <div>
                                            <td colspan="6" class="text-center py-4">Aucune commande récente</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                @else
                                <div  class="text-center py-4">Aucune commande récente</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    
                    <div class="dashboard-card mb-4" data-scroll>
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3><i class="fas fa-star me-2"></i> Produits Populaires</h3>
                            @if($popularProducts->IsNotEmpty())
                            <a href="{{ route('manager.products.index') }}" class="btn btn-sm btn-outline-primary">
                                Voir tout <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                @forelse($popularProducts as $product)
                                <div class="col-md-4 text-dark">
                                    
                                    <div class="product-card h-100">
                                       @include('partials.product-image',[ 'article' => $product])
                                        <div class="product-info">
                                            <h5>{{ $product->name }}</h5>
                                            <div class="product-meta mb-2">
                                                <span class="text-muted">{{ $product->category->name ?? 'Non catégorisé' }}</span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="price text-dark">{{ number_format($product->base_price, 0, ',', ' ') }} FCFA</span>
                                                <div class="badg">{{ $product->sales_count }} ventes</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12 text-center py-4">
                                    <p class="">Aucun produit populaire pour le moment</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    



                  
                    <div class="row  d-flex justify-content-between">
                        <div class="col-md-6 mb-2" data-scroll>
                            <div class="dashboard-card h-100">
                                <div class="card-header">
                                    <h3><i class="fas fa-chart-line me-2"></i> Ventes Mensuelles</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="monthlySalesChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-2" data-scroll>
                            <div class="dashboard-card h-100">
                                <div class="card-header">
                                    <h3><i class="fas fa-chart-pie me-2"></i> Catégories Populaires</h3>
                                </div>
                                <div class="card-body">
                                    <canvas id="categoriesChart" height="250"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<style>
.manager-dashboard {
    position: relative;
    min-height: 100vh;
    background-color: #f1f1f1;
  
}

.dark-mode .manager-dashboard{
    background-color: var(--bs-dark);
}

.dark-mode .dashboard-header{
    background: linear-gradient(135deg,var(--or-metallise),var(--or)) !important;
    color: var(--bs-dark);
     box-shadow: 0 4px 6px rgba(255, 255, 255, 0.1);
}
.dashboard-header {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.dark-mode .dashboard-title{
    color: var(--bs-dark);
}

.dashboard-title {
    font-weight: 700;
    margin: 0;
    color: white;
}

.admin-profile {
    display: inline-flex;
    align-items: center;
    background: rgba(255,255,255,0.1);
    padding: 8px 20px;
    border-radius: 50px;
    transition: all 0.3s;
}
.dark-mode .admin-profile{
    background: rgba(0, 0, 0, 0.89);
    color: white;
}

.dark-mode .admin-profile:hover{
    background: rgba(0, 0, 0, 0.50);
    color: white;
}

.admin-profile:hover {
    background: rgba(255,255,255,0.2);
}

.profile-img {
    width: 40px;
    height: 40px;
    object-fit: cover;
    border: 2px solid #d4af37;
}

.profile-name {
    color: var(--bs-white) ;
    font-weight: 500;
    font-size: 0.9rem;
}


.stat-card {
    color: var(--bs-white);
    border-radius: 10px;
    padding: 20px;
    display: flex;
    align-items: center;
    height: 100%;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 10px 10px 1px rgba(0,0,0,0.35);
}

.dark-mode .stat-card:hover{
    box-shadow: 10px 10px 2px rgba(242, 242, 242, 0.28);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: -20px;
    right: -20px;
    width: 100px;
    height: 100px;
    background: rgba(99, 96, 96, 0.15);
    border-radius: 50%;
}

.stat-icon {
    font-size: 2rem;
    margin-right: 20px;
    z-index: 1;
    opacity: 1;
}

.stat-info h3 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 5px;
    z-index: 1;
}

.stat-info p {
    margin-bottom: 5px;
    font-size: 1rem;
    opacity: 0.9;
    z-index: 1;
}

.stat-link {
    color: var(--bs-bs-dark);
    font-size: 0.85rem;
    text-decoration: none;
    z-index: 1;
    display: inline-block;
    margin-top: 5px;
    opacity: 0.8;
    transition: all 0.3s;
}

.stat-link:hover {
    opacity: 1;
    text-decoration: underline;
}


.bg-primary { background-color: #3490dc !important; }
.bg-success { background-color: #38c172 !important; }
.bg-warning { background-color: #ffc107 !important; }
.bg-danger { background-color: #e3342f !important; }
.bg-info { background-color: #17a2b8 !important; }
.bg-purple { background-color: #6f42c1 !important; }
.bg-dark { background-color: #343a40 !important; }


.dashboard-nav {
    background-color: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    overflow: hidden;
}

.nav-header {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
    padding: 15px;
}

.nav-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-item {
    border-bottom: 1px solid #f1f1f1;
}

.nav-item:last-child {
    border-bottom: none;
}

.nav-item a {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    color: #495057;
    text-decoration: none;
    transition: all 0.3s ease;
}

.nav-item a i {
    width: 25px;
    text-align: center;
    margin-right: 10px;
}

.nav-item a:hover, .nav-item a.active {
    background-color: rgba(212, 175, 55, 0.1);
    color: #d4af37;
    padding-left: 20px;
}


.dashboard-card {
    background: linear-gradient(145deg,var(--bs-white) 1% , var(--or) 70%);
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    margin-bottom: 20px;
    border: 1px solid var(--bs-dark);
    overflow: hidden;
    transition: all 0.3s ease;
}

.dark-mode .dashboard-card {
    border-color: var(--bs-dark)
}

.dashboard-card:hover {
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.card-header {
    background-color: var(--bs-dark);
    padding: 15px 20px;
    border-radius: 12px;
    
    border-bottom: 1px solid var(--bs-white);

    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-body ,.card-body p{
    color: var(--bs-dark) !important;
}

.dark-mode .card-header{
    background: var(--bg-dark);
    border-bottom-color: var(--bs-dark);

}




.card-header h3 {
    margin: 0;
    font-size: 1.25rem;
    color: var(--bs-white);
    display: flex;
    align-items: center;
}
.dark-mode .card-header h3{
    color: var(--bs-dark);
}

.card-header h3 i {
    margin-right: 10px;
    color: #d4af37;
}

.card-body {
    padding: 20px;
}


.table-responsive {
    overflow: hidden;

}

.table {
    margin-bottom: 0;
}

.table th {
    background-color: #f8f9fa;
    color: #343a40;
    font-weight: 600;
    padding: 12px 15px;
}

.table td {
    padding: 12px 15px;
    vertical-align: middle;
}

.table-hover tbody tr {
    transition: all 0.2s;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.02);
}





.product-card {
    border: 1px solid #eee;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.product-thumb {
    height: 180px;
    overflow: hidden;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.product-card:hover .product-thumb img {
    transform: scale(1.05);
}

.product-info {
    padding: 15px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.product-info h5 {
    font-size: 1rem;
    margin-bottom: 10px;
    color: #343a40;
    font-weight: 600;
}

.product-meta {
    margin-bottom: 10px;
}

.price {
    font-weight: 700;
    color: #d4af37;
    font-size: 1.1rem;
}


[data-scroll] {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease;
}

[data-scroll].animated {
    opacity: 1;
    transform: translateY(0);

}

@media (max-width: 992px) {
    .dashboard-nav {
        margin-bottom: 20px;
    }
    
    .stat-info h3 {
        font-size: 1.5rem;
    }
}

@media (max-width: 768px) {
    .dashboard-stats .col-md-6 {
        margin-bottom: 15px;
    }
    
    .stat-card {
        text-align: center;
        flex-direction: column;
    }
    
    .stat-icon {
        margin-right: 0;
        margin-bottom: 15px;
    }
    
    .product-card {
        margin-bottom: 15px;
    }
    
    .admin-profile {
        padding: 5px 10px;
    }
    
    .profile-name {
        display: none;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const animateOnScroll = () => {
        const elements = document.querySelectorAll("[data-scroll]");
        elements.forEach(el => {
            const rect = el.getBoundingClientRect();
            if (rect.top <= window.innerHeight * 0.75) {
                el.classList.add("animated");
            }
        });
    };
    
    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll();
    
  
    const salesCtx = document.getElementById('monthlySalesChart').getContext('2d');
    


    new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: <?=json_encode($salesData['months'])?>,
            datasets: [{
                label:'Vente mensuelle',
                data: <?=json_encode($salesData['amounts'])?>,
                backgroundColor: 'rgba(113, 209, 44, 0.7)',
                borderColor: 'rgba(113, 209, 44, 0.7)',
                borderWidth: 1,
                type:'line',
                yAxisID: 'y1'
            }, {
                label: 'Nombre de commandes',
                data: <?=json_encode($salesData['orders_count'])?>,
                backgroundColor: 'rgba(33, 37, 41, 0.7)',
                borderColor: 'rgba(33, 37, 41, 1)',
                borderWidth: 1,
                type: 'line',
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    title: {
                        display: true,
                        text: 'Montant (FCFA)'
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR').format(value);
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    title: {
                        display: true,
                        text: 'Nombre de commandes'
                    },
                    grid: {
                        drawOnChartArea: false
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.datasetIndex === 0) {
                                label += new Intl.NumberFormat('fr-FR').format(context.raw) + ' FCFA';
                            } else {
                                label += context.raw + ' commande(s)';
                            }
                            return label;
                        }
                    }
                },
                legend: {
                    position: 'top',
                }
            }
        }
    });
    
   
    const categoriesCtx = document.getElementById('categoriesChart').getContext('2d');
    new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
            labels: <?=json_encode($categoriesData['names'])?>,
            datasets: [{
                data: <?=json_encode($categoriesData['counts'])?>,
                backgroundColor: [
                    'rgba(212, 175, 55, 0.7)',
                    'rgba(33, 37, 41, 0.7)',
                    'rgba(108, 117, 125, 0.7)',
                    'rgba(40, 167, 69, 0.7)',
                    'rgba(220, 53, 69, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} produit(s) (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

   
    function refreshDashboard() {
        fetch(window.location.href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
         
            document.querySelectorAll('.stat-card h3').forEach((el, index) => {
                const values = [
                    data.productsCount,
                    data.ordersCount,
                    data.promotionsCount,
                    data.returnsCount,
                    data.todaySales,
                    data.monthlySales,
                    data.averageOrderValue
                ];
                if (index < values.length) {
                    animateValue(el, el.textContent, values[index], 1000);
                }
            });
        })
        .catch(error => console.error('Error refreshing dashboard:', error));
    }

  
    function animateValue(element, start, end, duration) {
        const startValue = parseFloat(start.replace(/[^\d.-]/g, ''));
        const endValue = parseFloat(end);
        const suffix = start.match(/[^0-9.-]/g)?.join('') || '';
        let startTimestamp = null;
        
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (endValue - startValue) + startValue);
            element.textContent = new Intl.NumberFormat('fr-FR').format(value) + ' ' + suffix;
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        
        window.requestAnimationFrame(step);
    }


    setInterval(refreshDashboard, 120000);
});
</script>
@endsection