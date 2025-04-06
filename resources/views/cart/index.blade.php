@extends('layouts.app')

@section('content')
<div class="panier-container">
    <div class="panier-wrapper">
        <!-- Colonne des articles -->
        <div class="articles-panier">
            <div class="card1">
                <div class="card1-header">
                    <h2>Votre Panier</h2>
                    <p class="sous-titre">Gérez vos articles</p>
                </div>
                
                <div class="card1-body">
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
                        <tr>
                            <td>Sous-total</td>
                            <td>{{ number_format($subtotal, 2) }} MAD</td>
                        </tr>
                        <tr>
                            <td>Livraison</td>
                            <td>Gratuite</td>
                        </tr>
                        <tr>
                            <td>TVA (20%)</td>
                            <td>{{ number_format($vat, 2) }} MAD</td>
                        </tr>
                        <tr class="total-row">
                            <td>Total</td>
                            <td>{{ number_format($total, 2) }} MAD</td>
                        </tr>
                    </table>
                    
                    <a href="#" class="btn-checkout">PROCÉDER AU PAIEMENT</a>
                </div>
            </div>
        </div>
    </div>
</div>

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
}

.panier-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
    min-height: 60vh; /* Empêche le footer de remonter */
}

/* Layout principal */
.panier-wrapper {
    display: flex;
    gap: 2rem;
    align-items: flex-start; /* Alignement en haut */
}

.articles-panier {
    flex: 2;
    min-width: 0; /* Fix pour flexbox overflow */
}

.recapitulatif {
    flex: 1;
    position: sticky;
    top: 20px; /* Fixe le récapitulatif lors du scroll */
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

/* Articles */
.article-item {
    display: flex;
    gap: 1.5rem;
    padding: 1.5rem 0;
    border-bottom: 1px solid var(--border);
    align-items: flex-start; /* Alignement en haut */
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
    object-fit: contain; /* Changez à 'cover' si préféré */
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
    min-width: 0; /* Fix pour text overflow */
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
    display: inline-flex; /* Changé de flex à inline-flex */
    align-items: center;
    justify-content: center;
    min-width: 40px; /* Au lieu de width fixe */
    min-height: 40px;
    border-radius: 50%;
    transition: all 0.2s ease;
    position: relative;
    z-index: 1;
    visibility: visible !important; /* Force la visibilité */
    opacity: 1 !important; /* Force l'opacité */
}

.btn-remove:hover {
    background: rgba(255, 66, 66, 0.1);
    transform: scale(1.1);
}

.btn-remove i {
    display: inline-block;
    font-size: inherit;
}

/* Pied d'article */
.article-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto; /* Pousse vers le bas */
    flex-wrap: wrap;
    gap: 1rem;
}

.quant {
    display: flex;
    align-items: center;
    gap: 0.75rem; /* Espacement entre les éléments */
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
    padding: 0; /* Important pour éviter des tailles inégales */
}

.btn-quantite:hover {
    background: var(--light-bg);
}

.btn-quantite:disabled {
    opacity: 0.5;
    cursor: not-allowed;
} 

.quant1 {
    min-width: 24px;
    text-align: center;
    font-weight: 500;
    font-size: 1rem;
}

.quantite {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantite span {
    min-width: 20px;
    text-align: center;
    display: inline-block;
}

.prix {
    text-align: right;
    min-width: 120px; /* Empêche le wrapping */
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

/* Bouton de paiement */
.btn-checkout {
    display: block;
    width: 100%;
    padding: 1rem;
    background: var(--primary);
    color: white;
    text-align: center;
    border-radius: 6px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    margin-top: 1rem;
}

.btn-checkout:hover {
    background: var(--primary-dark);
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
@endsection