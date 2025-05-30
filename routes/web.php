<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\PaypalController;



Route::get('/', [HomeController::class, 'index'])->name('home');

//  Afficher les produits par catégorie
Route::get('/category/{id}', [ProductController::class, 'productsByCategory'])->name('category.products');
// Lorsqu'un utilisateur accède à /category/{id}, tous les produits de cette catégorie sont affichés

//  Afficher le formulaire de connexion
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

//  Traitement de la connexion
Route::post('/login', [AuthController::class, 'login']);
// Vérifie les informations d'identification et connecte l'utilisateur s'il est valide

//  Afficher le formulaire d'inscription
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

//  Traitement de l'inscription et création du compte utilisateur
Route::post('/register', [AuthController::class, 'register']);

//  Déconnexion de l'utilisateur
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Lors de cette requête, l'utilisateur est déconnecté

// Tableau de bord utilisateur (accessible uniquement après connexion)
Route::middleware(['auth'])->group(function () {

    //  Afficher le profil utilisateur
    Route::get('/profile', [ProfileController::class, 'show'])->name('profil.show');

    //  Mettre à jour les informations du profil
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Afficher les détails d'un produit
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
// Lorsqu'un utilisateur accède à /product/{id}, les détails du produit correspondant sont affichés


// Dashboard Admin (accessible uniquement aux admins)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});
Route::prefix('admin')->middleware('auth', 'admin')->group(function () {
    Route::get('categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('categories/create', [AdminCategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    // Modifier une catégorie
    Route::get('categories/{category}/edit', [AdminCategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('categories/{category}', [AdminCategoryController::class, 'update'])->name('admin.categories.update');
    
    // Supprimer une catégorie
    Route::delete('categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Afficher la liste des produits (admin)
    Route::get('products', [AdminProductController::class, 'index'])->name('products.index');

    // Afficher le formulaire de création de produit
    Route::get('products/create', [AdminProductController::class, 'create'])->name('products.create');

    // Enregistrer un produit
    Route::post('products', [AdminProductController::class, 'store'])->name('products.store');

    // Afficher le formulaire d'édition d'un produit
    Route::get('products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');

    // Mettre à jour un produit
    Route::put('products/{product}', [AdminProductController::class, 'update'])->name('products.update');

    // Supprimer un produit
    Route::delete('products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    // Afficher les détails d'un produit spécifique (optionnel)
    Route::get('products/{product}', [AdminProductController::class, 'show'])->name('products.show');
    
});

//paiments d'admin 

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Categories
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    
    // Products
    Route::resource('products', AdminProductController::class);
    
    // Payments
    Route::resource('payments', PaymentController::class)->except(['create', 'destroy']);    Route::get('/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('payments.show');
    Route::put('/payments/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'update'])->name('payments.update');
});


// Route pour afficher tous les produits
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/search', [ProductController::class, 'search'])->name('products.search');

Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// panier
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
    Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
    Route::delete('/cart/coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');
    Route::patch('/cart/{cartItem}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
});
// favoris

Route::middleware(['auth'])->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/{id}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
});

// Clear coupon session data 
Route::get('/clear-coupon-session', function() {
  Session::forget(['coupon', 'discounts']);
  return redirect()->back()->with('success', 'Coupon session data cleared!');});



//paypal
 
    Route::middleware(['web'])->group(function () {
        // PayPal Payment Processing
        Route::post('/paypal/process', [PayPalController::class, 'processPayment'])
            ->name('paypal.process');
        
        // PayPal Return URLs
        Route::get('/paypal/success', [PayPalController::class, 'handleSuccess'])
            ->name('paypal.success');
        
        Route::get('/paypal/cancel', [PayPalController::class, 'handleCancel'])
            ->name('paypal.cancel');
        
        // Order Confirmation
        Route::get('/order/confirmation/{order}', function ($order) {
            return view('order.confirmation', [
                'order' => $order,
                'success' => session('success')
            ]);
        })->name('order.confirmation');
        
        Route::get('/checkout/payment', function () {
            return view('payment.form'
            );
        })->name('payment.form');
        
        // Error Page
        Route::get('/payment/error', function () {
            return view('payment.error')->with('error', session('error'));
        })->name('payment.error');
    });


    /*search*/
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');

    Route::get('/about-us', function () {
        return view('layouts.aboutus');
    })->name('aboutus');
    Route::get('/contact', function () {
        return view('layouts.contact');
    })->name('contact');