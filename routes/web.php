<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromoCodeController;
use App\Models\Product;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// Product routes: includes all CRUD (index, create, store, show, edit, update, destroy)
Route::resource('products', ProductController::class);
Route::get('/checkout', [OrderController::class, 'showCheckout'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('checkout.place');
Route::get('/checkout-success', [OrderController::class, 'success'])->name('checkout.success');
// Home route: make the welcomepage the default landing page
Route::get('/', function () {
    $products = Product::all(); // Retrieve all products
    return view('welcomepage', compact('products'));
})->name('welcomepage');

// Dashboard route, protected by auth middleware
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Guest routes for login and register
Route::middleware(['guest'])->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
});

// Logout route (protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});
Route::resource('promo_codes', PromoCodeController::class);

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}', [AdminOrderController::class, 'update'])->name('orders.update');

    Route::get('/popular-items', [ProductController::class, 'popularItems'])->name('products.popular');
// Include additional auth routes
require __DIR__.'/auth.php';
