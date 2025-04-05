@extends('layouts.app')

@section('content')
    <div class="cart-container">
        <h1 class="cart-title">Mon Panier</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cart) > 0)
            <!-- Tableau des articles -->
            <div class="cart-table">
                <div class="cart-header">
                    <div class="cart-header-item">Produit</div>
                    <div class="cart-header-item">Prix</div>
                    <div class="cart-header-item">Quantité</div>
                    <div class="cart-header-item">Total</div>
                    <div class="cart-header-item">Actions</div>
                </div>
                
                @foreach($cart as $productId => $product)
                <div class="cart-item">
                    <div class="cart-product">
                        <img src="{{ asset('storage/'.$product['image']) }}" alt="{{ $product['name'] }}" class="product-image">
                        <div class="product-info">
                            <h3>{{ $product['name'] }}</h3>
                        </div>
                    </div>
                    
                    <div class="cart-price">
                        {{ number_format($product['price'], 2) }} MAD
                    </div>
                    
                    <div class="cart-quantity">
                        <form action="{{ route('cart.update') }}" method="POST" class="quantity-form">
                            @csrf
                            <div class="quantity-control">
                                <button type="button" class="quantity-btn minus">-</button>
                                <input type="number" name="quantities[{{ $productId }}]" 
                                       value="{{ $product['quantity'] }}" min="1" class="quantity-input">
                                <button type="button" class="quantity-btn plus">+</button>
                            </div>
                            <button type="submit" class="update-btn">Actualiser</button>
                        </form>
                    </div>
                    
                    <div class="cart-total">
                        {{ number_format($product['price'] * $product['quantity'], 2) }} MAD
                    </div>
                    
                    <div class="cart-actions">
                        <form action="{{ route('cart.remove', $productId) }}" method="POST">
                            @csrf
                            <button type="submit" class="remove-btn">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Résumé de commande -->
            <div class="order-summary">
                <h3>Résumé de la commande</h3>
                <div class="summary-row">
                    <span>Articles</span>
                    <span>{{ $totalItems }}</span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>{{ number_format($totalPrice, 2) }} MAD</span>
                </div>
                <a href="#" class="checkout-btn">Passer la commande</a>
            </div>

            <!-- Suggestions de produits -->
            <div class="product-suggestions">
                <h3>Complétez votre commande</h3>
                <div class="suggestions-grid">
                    @foreach($randomProducts as $product)
                    <div class="suggestion-card">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="suggestion-image">
                        <div class="suggestion-info">
                            <h4>{{ $product->name }}</h4>
                            <p>{{ number_format($product->price, 2) }} MAD</p>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <div class="add-to-cart">
                                    <input type="number" name="quantity" value="1" min="1" class="suggestion-quantity">
                                    <button type="submit" class="add-btn">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Panier vide -->
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h3>Votre panier est vide</h3>
                <p>Découvrez nos produits et ajoutez-les à votre panier</p>
                <a href="{{ route('home') }}" class="continue-shopping">Continuer vos achats</a>
            </div>
        @endif
    </div>
@endsection


<style>
    /* ============ BASE STYLES ============ */
    .cart-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
        font-family: 'Montserrat', sans-serif;
    }

    .cart-title {
        font-size: 2rem;
        color: #333;
        margin-bottom: 2rem;
        text-align: center;
        font-weight: 600;
    }

    /* ============ CART TABLE STYLES ============ */
    .cart-table {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .cart-header {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr 0.5fr;
        background-color: #f8f9fa;
        padding: 1rem;
        font-weight: 600;
        border-bottom: 1px solid #eee;
    }

    .cart-header-item {
        color: #333;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr 0.5fr;
        align-items: center;
        padding: 1rem;
        border-bottom: 1px solid #eee;
        transition: background-color 0.3s;
    }

    .cart-item:hover {
        background-color: #f9f9f9;
    }

    /* Product cell */
    .cart-product {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: #333;
    }

    .product-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #eee;
    }

    /* Quantity controls */
    .quantity-form {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quantity-btn {
        width: 30px;
        height: 30px;
        background: #f1f1f1;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s;
    }

    .quantity-btn:hover {
        background: #e0e0e0;
    }

    .quantity-input {
        width: 50px;
        height: 30px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .cart-total{
        color: #333;
    }

    .update-btn {
        background: #6E9996;
        color: white;
        border: none;
        padding: 0.8rem;
        border-radius: 4px;
        font-size: 0.8rem;
        cursor: pointer;
        transition: background 0.3s;
        white-space: nowrap;
        margin-right: 20px;
    }

    .update-btn:hover {
        background: #518581;
    }

    /* Remove button */
    .remove-btn {
        background: none;
        color: #ff4757;
        border: none;
        width: 40px;
        height: 30px;
        border-radius: 4px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: color 0.3s;
    }

    .remove-btn:hover {
        color: #e84118;
    }

    /* ============ ORDER SUMMARY ============ */
    .order-summary {
        color: #333;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1.5rem;
        max-width: 400px;
        margin-left: auto;
        margin-bottom: 2rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.8rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px solid #eee;
    }

    .summary-row.total {
        font-weight: 600;
        font-size: 1.1rem;
        border-bottom: none;
    }

    .checkout-btn {
        display: block;
        width: 100%;
        background: #4CAF50;
        color: white;
        text-align: center;
        padding: 0.8rem;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 500;
        margin-top: 1rem;
        transition: background 0.3s;
    }

    .checkout-btn:hover {
        background: #3e8e41;
    }

    /* ============ EMPTY CART ============ */
    .empty-cart {
        text-align: center;
        padding: 3rem;
        background: #f8f9fa;
        border-radius: 8px;
        margin: 2rem 0;
    }

    .empty-cart i {
        font-size: 3rem;
        color: #6E9996;
        margin-bottom: 1rem;
    }

    .empty-cart h3 {
        color: #333;
        margin-bottom: 0.5rem;
    }

    .continue-shopping {
        display: inline-block;
        margin-top: 1rem;
        background: #6E9996;
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 4px;
        text-decoration: none;
        transition: background 0.3s;
    }

    .continue-shopping:hover {
        background: #518581;
    }

    /* ============ PRODUCT SUGGESTIONS ============ */
    .product-suggestions {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid #eee;
    }

    .product-suggestions h3 {
        text-align: center;
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
        color: #333;
    }

    .suggestions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
        margin: 20px 0;
    }

    .suggestion-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }

    .suggestion-card:hover {
        transform: translateY(-5px);
    }

    .suggestion-image {
        width: 100%;
        height: 160px;
        object-fit: cover;
    }

    .suggestion-info {
        padding: 1rem;
    }

    .suggestion-info h4 {
        font-size: 1rem;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .suggestion-info p {
        color: #333;
        font-weight: 600;
        margin-bottom: 0.8rem;
    }

    .add-to-cart {
        display: flex;
        gap: 0.5rem;
    }

    .suggestion-quantity {
        width: 60px;
        padding: 0.4rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        text-align: center;
    }

    .add-btn {
        flex: 1;
        background: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .add-btn:hover {
        background: #3e8e41;
    }

    /* ============ RESPONSIVE STYLES ============ */
    @media (max-width: 768px) {
        .cart-header {
            display: none;
        }
        
        .cart-item {
            grid-template-columns: 1fr;
            gap: 1rem;
            padding: 1.5rem;
            position: relative;
        }
        
        .cart-actions {
            position: absolute;
            top: 1rem;
            right: 1rem;
        }
        
        .order-summary {
            max-width: 100%;
        }
        
        .suggestions-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        }
    }
</style>