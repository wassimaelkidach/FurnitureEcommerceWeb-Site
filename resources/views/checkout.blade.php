@extends('layouts.app')

@section('content')
<script src="https://www.paypal.com/sdk/js?client-id=VOTRE_ID_CLIENT&currency=USD"></script>

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

/* Réinitialisation et base */
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

/* Disposition principale */
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

/* Étapes de paiement */
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
    box-shadow: 0 2px 8px rgba(52, 144, 220, 0.1);
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

/* Bouton vider panier */
.clear-cart-container {
    display: flex;
    justify-content: flex-end;
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

/* Styles du formulaire de paiement */
.checkout-form {
    display: flex;
    gap: 30px;
    margin-top: 2rem;
}

.billing-info__wrapper {
    flex: 1;
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: var(--shadow);
}

.checkout__totals-wrapper {
    flex: 1;
    max-width: 400px;
}

.checkout__totals {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: var(--shadow);
    margin-bottom: 1.5rem;
}

.order-items-container {
    max-height: 300px;
    overflow-y: auto;
    margin-bottom: 1.5rem;
}

.order-item {
    display: flex;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border);
    align-items: center;
}

.order-item-image {
    width: 80px;
    height: 80px;
    flex-shrink: 0;
    background: var(--light-bg);
    border-radius: 4px;
    overflow: hidden;
    margin-right: 1rem;
}

.order-item-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.order-item-details {
    flex: 1;
}

.order-item-name {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.order-item-info {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.order-item-price {
    font-weight: 600;
    white-space: nowrap;
}

.checkout__payment-methods {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: var(--shadow);
}

.form-floating {
    position: relative;
    margin-bottom: 1rem;
}

.form-floating label {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    padding: 1rem 0.75rem;
    pointer-events: none;
    transition: all 0.2s ease;
    color: #666;
}

.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
    padding: 0 0.5rem;
}

.form-control {
    padding: 1rem 0.75rem;
    border: 1px solid var(--border);
    border-radius: 6px;
    width: 100%;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 0.25rem rgba(42, 82, 190, 0.25);
}

.btn-checkout {
    background-color: var(--primary);
    color: white;
    border: none;
    padding: 1rem;
    border-radius: 6px;
    font-weight: 600;
    width: 100%;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 1.5rem;
}

.btn-checkout:hover {
    background-color: var(--primary-dark);
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 992px) {
    .panier-wrapper, .checkout-form {
        flex-direction: column;
    }
    
    .recapitulatif, .checkout__totals-wrapper {
        position: static;
        width: 100%;
        max-width: none;
    }
}

@media (max-width: 768px) {
    .article-item, .order-item {
        flex-direction: column;
        gap: 1rem;
    }
    
    .article-image, .order-item-image {
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
    .card1-header, .card1-body, 
    .billing-info__wrapper, 
    .checkout__totals,
    .checkout__payment-methods {
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
    <section class="shop-checkout">
        <h2 class="page-title">Livraison et Paiement</h2>
        <div class="checkout-steps">
            <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Panier</span>
                    <em>Gérez vos articles</em>
                </span>
            </a>
            <a href="{{ route('cart.checkout') }}" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Livraison et Paiement</span>
                    <em>Finalisez votre commande</em>
                </span>
            </a>
            <a href="#" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Confirmez votre commande</em>
                </span>
            </a>
        </div>
        
        <form id="checkout-form" method="POST" action="{{ route('paypal.process') }}">
            @csrf
            <div class="checkout-form">
                <div class="billing-info__wrapper">
                    <div class="row">
                        <div class="col-12">
                            <h4><i class="fas fa-truck me-2"></i> DÉTAILS DE LIVRAISON</h4>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="name" id="name" required 
                                       value="{{ old('name', auth()->user()->name ?? '') }}" placeholder="Nom complet *">
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="phone" id="phone" required 
                                       value="{{ old('phone', auth()->user()->phone ?? '') }}" placeholder="Téléphone *">
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="zip" id="zip" required 
                                       value="{{ old('zip') }}" placeholder="Code postal *">
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mt-3 mb-3">
                                <input type="text" class="form-control" name="state" id="state" required 
                                       value="{{ old('state') }}" placeholder="Région *">
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="country" id="country" required 
                                       value="{{ old('country') }}" placeholder="Pays *">
                                
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="city" id="city" required 
                                       value="{{ old('city') }}" placeholder="Ville *">
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="address" id="address" required 
                                       value="{{ old('address') }}" placeholder="N° de rue, Bâtiment *">
                                
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="locality" id="locality" required 
                                       value="{{ old('locality') }}" placeholder="Nom de rue, Quartier *">
                                
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="landmark" id="landmark" 
                                       value="{{ old('landmark') }}" placeholder="Point de repère (Optionnel)">
                                
                            </div>
                        </div>
                        <div class="col-md-12">
                        <label for="type">Type d'adresse</label>
                            <div class="form-floating my-3">
                                <select class="form-control" name="type" id="type">
                                    <option value="home" {{ old('type') == 'home' ? 'selected' : '' }}>Domicile</option>
                                    <option value="office" {{ old('type') == 'office' ? 'selected' : '' }}>Bureau</option>
                                    <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Autre</option>
                                </select>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="checkout__payment-methods">
                        <h4><i class="fas fa-credit-card me-2"></i> MÉTHODE DE PAIEMENT</h4>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                   id="payment_paypal" value="paypal" checked>
                            <label class="form-check-label" for="payment_paypal">
                                PayPal
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="checkout__totals-wrapper">
                    <div class="checkout__totals">
                        <h3><i class="fas fa-shopping-bag me-2"></i> VOTRE COMMANDE</h3>
                
                        <div class="order-items-container">
                            @foreach($cartItems as $item)
                            <div class="order-item">
                                <div class="order-item-image">
                                    @if($item->product->image && Storage::disk('public')->exists('products/'.basename($item->product->image)))
                                        <img src="{{ asset('storage/products/' . basename($item->product->image)) }}" 
                                             alt="{{ $item->product->name }}">
                                    @else
                                        <i class="fas fa-image text-muted"></i>
                                    @endif
                                </div>
                                <div class="order-item-details">
                                    <div class="order-item-name">{{ $item->product->name }}</div>
                                    @if($item->color)
                                        <div class="order-item-info">
                                            <i class="fas fa-palette me-1"></i> Couleur: {{ $item->color }}
                                        </div>
                                    @endif
                                    <div class="order-item-info">
                                        <i class="fas fa-layer-group me-1"></i> Qté: {{ $item->quantity }} × {{ number_format($item->price, 2) }} MAD
                                    </div>
                                </div>
                                <div class="order-item-price">{{ number_format($item->price * $item->quantity, 2) }} MAD</div>
                            </div>
                            @endforeach
                        </div>
                        
                        <table class="table-total">
                            <tbody>
                                <tr>
                                    <th>Sous-total</th>
                                    <td>{{ number_format($subtotal, 2) }} MAD</td>
                                </tr>
                                <tr>
                                    <th>Livraison</th>
                                    <td>{{ number_format($shipping ?? 40.00, 2) }} MAD</td>
                                </tr>
                                <tr>
                                    <th>TVA</th>
                                    <td>{{ number_format($vat, 2) }} MAD</td>
                                </tr>
                                <tr class="total-row">
                                    <th>Total</th>
                                    <td>{{ number_format($total, 2) }} MAD</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <button type="submit" id="place-order-button" class="btn-checkout">
                        <i class="fas fa-shopping-cart me-2"></i> PASSER LA COMMANDE
                    </button>
                </div>
            </div>
        </form>
    </section>
</div>

@push('scripts')
<script>
    // Scripts PayPal et validation du formulaire ici
</script>
@endpush

@endsection