<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

// Product routes: includes all CRUD (index, create, store, show, edit, update, destroy)
Route::resource('products', ProductController::class);

// Home route: show login page if not authenticated, otherwise redirect to products index
Route::get('/', function () {
    return Auth::check() ? redirect()->route('products.index') : redirect()->route('login');
})->name('home');

// Welcome page, protected by auth middleware
Route::get('/welcomepage', function () {
    return view('welcomepage');
})->middleware(['auth', 'verified'])->name('welcomepage');

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

// Include additional auth routes
require __DIR__.'/auth.php';
