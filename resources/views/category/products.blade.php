@extends('layouts.app')

@section('content')
    <div class="category-container">
        <h1 class="category-title">Produits de la catégorie : {{ $category->name }}</h1>

        <div class="products-grid">
            @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                        <div class="product-actions">
                            <form action="{{ route('favorites.store', $product->id) }}" method="POST" class="favorite-form">
                                @csrf
                                <button type="submit" class="favorite-btn">
                                    <i class="far fa-heart"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="product-info">
                        <h3 class="product-name">{{ $product->name }}</h3>
                        <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                        <p class="product-price">{{ number_format($product->price, 2) }} MAD</p>
                        
                        <div class="product-buttons">
                            <a href="{{ route('product.show', $product->id) }}" class="details-btn">
                                <i class="fas fa-eye"></i> Voir détails
                            </a>
                            
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <div class="quantity-selector">
                                    <input type="number" name="quantity" value="1" min="1" class="quantity-input">
                                    <button type="submit" class="add-to-cart-btn">
                                        <i class="fas fa-shopping-cart"></i> Ajouter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<style>
    /* Style général */
    .category-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
        font-family: 'Montserrat', sans-serif;
    }

    .category-title {
        font-size: 2rem;
        color: #333;
        margin-bottom: 2rem;
        text-align: center;
        font-weight: 600;
    }

    /* Grille de produits */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
    }

    /* Carte de produit */
    .product-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    /* Image du produit */
    .product-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.05);
    }

    /* Actions sur le produit */
    .product-actions {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .favorite-btn {
        background: white;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        color: #ccc;
        transition: all 0.3s ease;
    }

    .favorite-btn:hover {
        color: #ff4757;
        transform: scale(1.1);
    }

    /* Informations du produit */
    .product-info {
        padding: 1.5rem;
    }

    .product-name {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: #333;
        font-weight: 600;
    }

    .product-description {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .product-price {
        font-size: 1.3rem;
        color: #B3AC9D;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    /* Boutons */
    .product-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }

    .details-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: #B3AC9D;
        color: white;
        padding: 0.6rem;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.9rem;
        transition: background 0.3s ease;
    }

    .details-btn:hover {
        background: #7A7568;
        color: white;
    }

    /* Formulaire d'ajout au panier */
    .add-to-cart-form {
        width: 100%;
    }

    .quantity-selector {
        display: flex;
        gap: 0.5rem;
    }

    .quantity-input {
        width: 60px;
        padding: 0.6rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-align: center;
    }

    .add-to-cart-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: #4CAF50;
        color: white;
        border: none;
        padding: 0.6rem;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: background 0.3s ease;
    }

    .add-to-cart-btn:hover {
        background: #3e8e41;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
        }
        
        .product-buttons {
            flex-direction: column;
        }
        
        .quantity-selector {
            flex-direction: column;
        }
        
        .quantity-input {
            width: 100%;
        }
    }
</style>