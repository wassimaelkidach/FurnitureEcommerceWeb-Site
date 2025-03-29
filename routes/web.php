<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
Route::get('/', function () {
    return view('layouts.home');  // Assure-toi que 'home.blade.php' existe dans 'resources/views'
})->name('layouts.home');
Route::get('/', [CategoryController::class, 'index'])->name('home');
Route::get('/category/{id}', [ProductController::class, 'productsByCategory'])->name('category.products');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard après connexion pour l'utilisateur

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profil.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
