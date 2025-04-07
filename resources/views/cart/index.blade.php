@extends('layouts.app')

@section('content')
<style>
:root {
    --primary: #2a52be;
    --primary-dark: #1a3a8a;
    --text: #333;
    --light-bg: #f9f9f9;
    --border: #e0e0e0;
    --shadow: 0 4px 15px rgba(0,0,0,0.1);
    --error: #ff4242;
}

/* Reset et base */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
    line-height: 1.5;
    background-color: #f9f9f9;
}

.panier-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
    min-height: 60vh;
}


/* Layout principal */
.panier-wrapper {
    display: flex;
    gap: 2rem;
    align-items: flex-start;
}

.articles-panier {
    flex: 2;
    min-width: 0;
}

.recapitulatif {
    flex: 1;
    position: sticky;
    top: 20px;
}

/* Cartes */
.card1 {
    background: white;
    border-radius: 8px;
    box-shadow: var(--shadow);
    overflow: hidden;
    margin-bottom: 2rem;
}

.card1-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border);
    background-color: #f5f7fa;
}

.card1-header h2 {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text);
}

.sous-titre {
    color: #666;
    font-size: 0.9rem;
}

.card1-body {
    padding: 1.5rem;
}

/* Checkout steps */
.checkout-steps {
    display: flex;
    justify-content: space-between;
    margin: 2rem 0;
    flex-wrap: wrap;
    gap: 1rem;
}

.checkout-steps__item {
    flex: 1;
    padding: 15px;
    border: 1px solid var(--border);
    border-radius: 6px;
    background-color: #fafafa;
    text-decoration: none;
    transition: all 0.3s ease;
    min-width: 200px;
}

.checkout-steps__item.active {
    border-color: var(--primary);
    background-color: #e6f0ff;
}

.checkout-steps__item-number {
    font-size: 20px;
    font-weight: bold;
    margin-right: 10px;
    color: var(--primary);
}

.checkout-steps__item-title span {
    font-weight: 600;
    display: block;
}

.checkout-steps__item-title em {
    font-size: 13px;
    color: #888;
}

/* Clear cart button container */
.clear-cart-container {
    display: flex;
    justify-content: flex-end; /* Align to the right */
    margin-bottom: 1rem;
}

/* Articles */
.article-item {
    display: flex;
    gap: 1.5rem;
    padding: 1.5rem 0;
    border-bottom: 1px solid var(--border);
    align-items: flex-start;
}

.article-image {
    width: 120px;
    height: 120px;
    flex-shrink: 0;
    background: var(--light-bg);
    border-radius: 4px;
    overflow: hidden;
}

.article-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
}

.placeholder-image {
    width: 100%;
    height: 100%;
    display: grid;
    place-items: center;
    color: #ccc;
    font-size: 2rem;
}

.article-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.article-header {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.article-header h3 {
    font-size: 1.1rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex: 1;
}

.couleur {
    color: #666;
    font-size: 0.9rem;
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.btn-remove {
    background: none;
    border: none;
    color: var(--error);
    cursor: pointer;
    font-size: 1.25rem;
    padding: 0.5rem;
    margin: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    min-height: 40px;
    border-radius: 50%;
    transition: all 0.2s ease;
}

.btn-remove:hover {
    background: rgba(255, 66, 66, 0.1);
    transform: scale(1.1);
}

/* Pied d'article */
.article-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    flex-wrap: wrap;
    gap: 1rem;
}

.quant {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.btn-quantite {
    width: 32px;
    height: 32px;
    border: 1px solid var(--border);
    background: white;
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1rem;
    transition: all 0.2s ease;
    padding: 0;
}

.btn-quantite:hover {
    background: var(--light-bg);
}

.quant1 {
    min-width: 24px;
    text-align: center;
    font-weight: 500;
    font-size: 1rem;
}
a{
    text-decoration: none;
}
.prix {
    text-align: right;
    min-width: 120px;
}

.total {
    font-weight: 600;
    font-size: 1.1rem;
    white-space: nowrap;
}

.prix small {
    color: #666;
    font-size: 0.8rem;
    display: block;
}

/* Formulaire code promo */
.form-coupon {
    margin-bottom: 1.5rem;
}

.input-group {
    display: flex;
    width: 100%;
}

.input-group input {
    flex: 1;
    padding: 0.75rem;
    border: 1px solid var(--border);
    border-radius: 6px 0 0 6px;
    border-right: none;
    font-size: 0.9rem;
}

.input-group button {
    padding: 0 1.5rem;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 0 6px 6px 0;
    cursor: pointer;
    transition: all 0.2s ease;
    font-weight: 600;
    font-size: 0.9rem;
}

.input-group button:hover {
    background: var(--primary-dark);
}

/* Tableau récapitulatif */
.table-total {
    width: 100%;
    margin: 1.5rem 0;
    border-collapse: collapse;
}

.table-total tr:not(.total-row) td {
    padding: 0.75rem 0;
    color: #666;
    border-bottom: 1px solid var(--border);
}

.table-total td:last-child {
    text-align: right;
}

.total-row td {
    padding: 1rem 0;
    font-weight: 600;
    font-size: 1.1rem;
}

/* Boutons */
.btn-outline-danger {
    border: 1px solid var(--error);
    color: var(--error);
    padding: 0.375rem 0.75rem;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.btn-outline-danger:hover {
    background-color: var(--error);
    color: white;
}

.btn-dark {
    background-color: var(--primary);
    color: white;
    padding: 1rem;
    border-radius: 6px;
    font-weight: 600;
    transition: all 0.2s ease;
    width: 100%;
    text-align: center;
    display: block;
    border: none;
    cursor: pointer;
}

.btn-dark:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 992px) {
    .panier-wrapper {
        flex-direction: column;
    }
    
    .recapitulatif {
        position: static;
        width: 100%;
    }
}

@media (max-width: 768px) {
    .article-item {
        flex-direction: column;
        gap: 1rem;
    }
    
    .article-image {
        width: 100%;
        height: auto;
        aspect-ratio: 1/1;
    }
    
    .article-footer {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .prix {
        text-align: left;
        width: 100%;
    }

    .checkout-steps__item {
        min-width: 100%;
    }
}

@media (max-width: 480px) {
    .card1-header, .card1-body {
        padding: 1rem;
    }
    
    .btn-quantite {
        width: 28px;
        height: 28px;
    }
    
    .article-header {
        flex-direction: column;
    }
}
</style>

<div class="panier-container">
    <h2 class="page-title">Livraison et Paiement</h2>
    <div class="checkout-steps">
        <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
            <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                <span>Panier</span>
                <em>Gérez vos articles</em>
                </span>
        </a>

                        <a href="{{ route('cart.checkout') }}" class="checkout-steps__item">
                            <span class="checkout-steps__item-number">02</span>
                            <span class="checkout-steps__item-title">
                            <span>Livraison et Paiement</span>
                            <em>Finalisez votre commande</em>
                            </span>
                        </a>
                
                    <a href="order-confirmation.html" class="checkout-steps__item">
                        <span class="checkout-steps__item-number">03</span>
                        <span class="checkout-steps__item-title">
                            <span>Confirmation</span>
                            <em>Confirmez votre commande</em>
                            </span>
                    </a>
    </div>
    <div class="panier-wrapper">
        <!-- Colonne des articles -->
        <div class="articles-panier">
            <div class="card1">
                <div class="card1-header">
                    <h2>Votre Panier</h2>
                    <p class="sous-titre">Gérez vos articles</p>
                </div>

                <div class="card1-body">
                    

                    <div class="clear-cart-container">
                        <form action="{{ route('cart.clear') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-outline-danger">
                                <i class="fas fa-trash-alt me-1"></i> Clear Cart
                            </button>
                        </form>
                    </div>

                    @foreach($cartItems as $item)
                    <div class="article-item">
                        <div class="article-image">
                            @if($item->product->image && Storage::disk('public')->exists('products/'.basename($item->product->image)))
                                <img src="{{ asset('storage/products/' . basename($item->product->image)) }}" 
                                    alt="{{ $item->product->name }}">
                            @else
                                <div class="placeholder-image">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>
                            
                        <div class="article-details">
                            <div class="article-header">
                                <div class="article-info">
                                    <h3>{{ $item->product->name }}</h3>
                                    <p class="couleur">
                                        <span>Couleur :</span> 
                                        <strong>{{ $item->color }}</strong>
                                    </p>
                                </div>

                                <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove" aria-label="Supprimer l'article" title="Supprimer">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>
                                
                            <div class="article-footer">
                                <div class="quantite">
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="quant">
                                            <button type="submit" name="change" value="-1" class="btn-quantite">
                                                -
                                            </button>
                                            <span class="quant1">{{ $item->quantity }}</span>
                                            <button type="submit" name="change" value="1" class="btn-quantite">
                                                +
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="prix">
                                    <p class="total">{{ number_format($item->price * $item->quantity, 2) }} MAD</p>
                                    <small>{{ number_format($item->price, 2) }} MAD l'unité</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Colonne du total -->
        <div class="recapitulatif">
            <div class="card1">
                <div class="card1-header">
                    <h2>Récapitulatif</h2>
                </div>
                
                <div class="card1-body">
                    <form action="{{ route('cart.applyCoupon') }}" method="POST" class="form-coupon">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="coupon_code" placeholder="Code promo">
                            <button type="submit">APPLIQUER</button>
                        </div>
                    </form>
                    
                    <table class="table-total">
                        <tr class="total-row">
                            <td>Total</td>
                            <td>{{ number_format($total, 2) }} MAD</td>
                        </tr>
                    </table>
                    
                    
                    <a href="{{ route('cart.checkout') }}" class="btn-dark">
                        <i class="fas fa-shopping-cart"></i> Passer à la caisse
                    </a>

                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection