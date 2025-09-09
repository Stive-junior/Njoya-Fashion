<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Article;
use App\Models\Article_variant;
use App\Models\Categories;
use App\Models\Promotions;
use App\Models\Returns;
use App\Models\User;
use Carbon\Carbon;

class ManagerDashboardController extends Controller
{
   public function index()
{
    
    $productsCount = Article::count();
    $ordersCount = Order::count();
    
    $promotions = Promotions::all()->filter(function ($promotion) { return $promotion->active();});
    $promotionsCount = $promotions->count();

    $returnsCount = Returns::count();
    
 
    $recentOrders = Order::with(['user', 'items'])
        ->orderByDesc('created_at')
        ->take(5)
        ->get();
    
   
    $popularProducts = Article::with(['images', 'category'])
        ->withCount(['orderItems as sales_count' => function($query) {
            $query->whereHas('order', function($q) {
                $q->where('status', '!=', 'cancelled');
            });
        }])
        ->orderByDesc('sales_count')
        ->take(3)
        ->get();


    $categories = Categories::with(['children' => function($query) {
            $query->where('status', 1)->orderBy('order');
        }])
        ->whereNull('parent_id')
        ->where('status', 1)
        ->orderBy('order')
        ->get();
    

    $salesData = $this->getMonthlySalesData();
    $categoriesData = $this->getCategoriesData();

     $todaySales = Order::whereDate('created_at', today())
        ->sum('total_amount');
    
    $monthlySales = Order::whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('total_amount');
    
    $averageOrderValue = $ordersCount > 0 
        ? Order::sum('total_amount') / $ordersCount 
        : 0;
    

 
    $pendingOrders = Order::whereIn('status', ['pending', 'processing'])
        ->orderBy('created_at')
        ->take(5)
        ->get();
    
    return view('manager.dashboard', compact(
        'productsCount',
        'ordersCount',
        'promotionsCount',
        'returnsCount',
        'recentOrders',
        'popularProducts',
        'salesData',
        'categoriesData',
        'categories',
        'todaySales',
        'monthlySales',
        'averageOrderValue',
        'pendingOrders'
    ));
}

protected function getCategoriesData()
{
    $categories = Categories::withCount(['articles as products_count' => function($query) {
            $query->where('status', 1); 
        }])
        ->where('status', 1)
        ->orderByDesc('products_count')
        ->take(5)
        ->get();
    
    return [
        'names' => $categories->pluck('name'),
        'counts' => $categories->pluck('products_count'),
        'categories' => $categories
    ];
}

protected function getMonthlySalesData()
{
    $months = [];
    $amounts = [];
    $ordersCount = [];
    

    for ($i = 5; $i >= 0; $i--) {
        $date = Carbon::now()->subMonths($i);
        $monthKey = $date->format('M Y');
        
        $orders = Order::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month);
            
        $months[] = $monthKey;
        $amounts[] = $orders->sum('total_amount');
        $ordersCount[] = $orders->count();
    }
    
    return [
        'months' => $months,
        'amounts' => $amounts,
        'orders_count' => $ordersCount
    ];
}
}