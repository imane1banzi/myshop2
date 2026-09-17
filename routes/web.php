<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromoCodeController;
use App\Models\Product;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

/*
|--------------------------------------------------------------------------
| 1. ZONE PUBLIQUE = client non authentifié (guest) + client + admin
| Guest traité comme client : même catalogue, panier (localStorage),
| checkout, détails produit. Aucun rôle requis.
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $products = Product::all();
    return view('welcomepage', compact('products'));
})->name('welcomepage');

// Catalogue visible par tous (lecture seule)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/popular-items', [ProductController::class, 'popularItems'])->name('products.popular');
Route::get('/products/new-arrivals', [ProductController::class, 'newArrivals'])->name('products.new-arrivals');

// Panier + checkout accessibles au guest comme au client (JS localStorage)
Route::get('/checkout', [OrderController::class, 'showCheckout'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'placeOrder'])->name('checkout.place');
Route::get('/checkout-success', [OrderController::class, 'success'])->name('checkout.success');

// API publique pour appliquer un code promo dans le panier (lecture seule)
Route::get('/api/promo-codes', [PromoCodeController::class, 'getPromoCodes']);

// About visible sur tout le site (page dédiée, pas seulement ancre accueil)
Route::get('/about', function () {
    return view('about');
})->name('about');

/*
|--------------------------------------------------------------------------
| 2. ZONE CLIENT AUTHENTIFIÉ (profil client d'office après login/register)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Historique commandes personnel (user_id = Auth::id)
    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('my-orders.index');
    Route::get('/my-orders/{id}', [OrderController::class, 'myShow'])->name('my-orders.show');
});

/*
|--------------------------------------------------------------------------
| 3. ZONE ADMIN (auth + middleware admin) : accès à TOUT
| Création admin uniquement via : php artisan db:seed --class=AdminUserSeeder
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    // CRUD produits (sauf index/show déjà publics)
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Gestion codes promo
    Route::resource('promo_codes', PromoCodeController::class)->except(['show']);

    // Gestion toutes les commandes
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}', [AdminOrderController::class, 'update'])->name('orders.update');
});

// Détail produit public — placé APRES /products/create pour éviter le conflit
// {product} numérique uniquement, donc /products/create ne matche pas ici.
Route::get('/products/{product}', [ProductController::class, 'show'])
    ->whereNumber('product')
    ->name('products.show');

require __DIR__.'/auth.php';
