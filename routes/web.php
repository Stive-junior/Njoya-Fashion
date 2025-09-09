<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Client\ProductController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Manager\ManagerDashboardController;
use App\Http\Controllers\Manager\ManagerProductController;
use App\Http\Controllers\Manager\ManagerOrderController;
use App\Http\Controllers\Manager\ManagerCategoryController;
use App\Http\Controllers\Manager\ManagerCouponController;
use App\Http\Controllers\Manager\ManagerUserController;
use App\Http\Controllers\Client\FavoriteController;
use App\Http\Controllers\Manager\ManagerPromotionController;
use App\Http\Controllers\Manager\ManagerReturnController;
use App\Http\Controllers\Manager\PaymentMethodController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SearchController;
use App\Models\Payement_methods;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Laravel\Prompts\SearchPrompt;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('/', [WelcomeController::class, 'index'])->name('home')->middleware('is.custom');
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{id}/product', [CategorieController::class, 'show'])->name('category.show');
Route::get('/category/{id}/', [CategorieController::class, 'showSubcategorie'])->name('category.subcategories');
Route::get('/product/{id}',[ProductController::class],'show')->name('client.products.show');


Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add/{article}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::put('/cart/up/{cartItem}',[CartController::class ,  'updateItemDetails'])->name('cart.up');
Route::put('/cart/{itemId}/quantity', [CartController::class, 'updateQuantity'])->name('cart.update.quantity');
Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('client.cart.remove');
Route::post('/cart/sync',[CartController::class, 'syncCart'])->name('cart.sync');
Route::get('/cart/data', [CartController::class, 'cartData'])->name('client.cart.data');
Route::post('/cart/clear-session', [CartController::class, 'clearSession'])->name('cart.clearSession');

Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process');
Route::post('/verify-payment', [PaymentController::class, 'verifyPayment']);
Route::post('/cart/clear', [CartController::class, 'clear']);


Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');



Route::prefix('manager')->middleware(['auth', 'is.manager'])->group(function () {

    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
    Route::get('/products/create', [ManagerProductController::class, 'create'])->name('manager.products.create');
    Route::get('/products', [ManagerProductController::class, 'index'])->name('manager.products.index');
    Route::get('/products/{product}/edit', [ManagerProductController::class, 'edit'])->name('manager.products.edit');
    Route::put('/products/update/{article}', [ManagerProductController::class, 'update'])->name('manager.products.update');
    Route::get('/products/{product}', [ManagerProductController::class, 'show'])->name('manager.products.show');
    Route::delete('/products/destroy/{product}', [ManagerProductController::class, 'destroy'])->name('manager.products.destroy');

    Route::get('/orders', [ManagerOrderController::class, 'index'])->name('manager.orders.index');
    Route::get('/users', [ManagerOrderController::class, 'index'])->name('manager.users.index');
    Route::get('/orders/{order}', [ManagerOrderController::class, 'show'])->name('manager.orders.show');
    Route::put('/orders/{order}', [ManagerOrderController::class, 'update'])->name('manager.orders.update');
    Route::get('/promotions', [ManagerPromotionController::class, 'index'])->name('manager.promotions.index');
    Route::get('/payements', [PaymentMethodController::class, 'index'])->name('manager.payment-methods.index');
    Route::get('/returns', [ManagerReturnController::class, 'index'])->name('manager.returns.index');
    Route::get('/category', [ManagerCategoryController::class, 'index'])->name('manager.categories.index');
    Route::get('/coupon', [ManagerCouponController::class, 'index'])->name('manager.coupons.index');
    Route::get('categories/{id}/subcategories', [ManagerCategoryController::class, 'getSubCategories']);

    Route::resource('/coupons', ManagerCouponController::class)->except(['show']);

     Route::resource('products', \App\Http\Controllers\Manager\ManagerProductController::class)
        ->except(['show'])
        ->names([
            'index' => 'manager.products.index',
            'create' => 'manager.products.create',
            'store' => 'manager.products.store',
            'edit' => 'manager.products.edit',
        ]);
  
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::post('/favorites/remove/{article}', [FavoriteController::class, 'remove'])->name('favorites.remove');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order?}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/search', [SearchController::class, 'show'])->name('search');


    Route::prefix('favorites')->group(function() {
    Route::get('/', [FavoriteController::class, 'index'])->name('favorites');
    Route::post('/add/{article}', [FavoriteController::class, 'add'])->name('favorites.add');
    Route::post('/remove/{article}', [FavoriteController::class, 'remove'])->name('favorites.remove');
    Route::post('/toggle/{article}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    
});



Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

});

require __DIR__.'/auth.php';

