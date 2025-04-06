@extends('layouts.app')

@section('content')
<div class="favorites-container">
    <h1 class="page-title">Mes Favoris</h1>

    @if(session('success'))
        <div class="alert-message success">
            {{ session('success') }}
        </div>
    @endif

    @if($favorites->count() > 0)
        <div class="products-grid">
            @foreach($favorites as $favorite)
                <div class="product-card">
                    <div class="product-image-container">
                        <img src="{{ asset('storage/' . $favorite->product->image) }}" alt="{{ $favorite->product->name }}" class="product-image">
                        <div class="product-badge favorite">
                            <i class="fas fa-heart"></i>
                        </div>
                    </div>

                    <div class="product-info">
                        <h3 class="product-name">{{ $favorite->product->name }}</h3>
                        <p class="product-price">{{ number_format($favorite->product->price, 2) }} MAD</p>
                        
                        <div class="product-actions">
                            <form action="{{ route('favorites.destroy', $favorite->product->id) }}" method="POST" class="remove-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-btn">
                                    <i class="fas fa-trash-alt"></i> Retirer
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="far fa-heart"></i>
            <p>Vous n'avez aucun favori</p>
        </div>
    @endif

    <!-- Section recommandations -->
    <h3 class="recommendation-title">Vous pourriez aussi aimer</h3>
    <div class="products-grid">
        @foreach($randomProducts as $product)
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
                    <p class="product-price">{{ number_format($product->price, 2) }} MAD</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

<style>
    /* Style général */
    .favorites-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
        font-family: 'Montserrat', sans-serif;
    }

    .page-title {
        font-size: 2rem;
        color: #333;
        margin-bottom: 2rem;
        font-weight: 600;
        text-align: center;
    }

    /* Message d'alerte */
    .alert-message {
        padding: 1rem;
        border-radius: 5px;
        margin-bottom: 2rem;
        text-align: center;
    }

    .alert-message.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    /* État vide */
    .empty-state {
        text-align: center;
        padding: 3rem;
        background: #f9f9f9;
        border-radius: 10px;
        margin: 2rem 0;
    }

    .empty-state i {
        font-size: 3rem;
        color: #274472;
        margin-bottom: 1rem;
    }

    .empty-state p {
        font-size: 1.2rem;
        color: #666;
    }

    /* Grille de produits */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin: 2rem 0;
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

    /* Badge favori */
    .product-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: white;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }

    .product-badge.favorite {
        color: #ff4757;
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

    .product-price {
        font-size: 1.3rem;
        color: #274472;
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    /* Actions sur le produit */
    .product-actions {
        display: flex;
        justify-content: center;
    }

    .remove-form, .favorite-form {
        width: 100%;
    }

    .remove-btn {
        width: 100%;
        background: #ff4757;
        color: white;
        border: none;
        padding: 0.8rem;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: background 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .remove-btn:hover {
        background: #e84118;
    }

    .favorite-btn {
        position: absolute;
        top: 10px;
        right: 10px;
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

    /* Titre recommandations */
    .recommendation-title {
        font-size: 1.5rem;
        color: #333;
        margin: 3rem 0 1.5rem;
        font-weight: 600;
        text-align: center;
        position: relative;
    }

    .recommendation-title::after {
        content: '';
        display: block;
        width: 100px;
        height: 3px;
        background: #274472;
        margin: 0.5rem auto 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
        }
        
        .page-title {
            font-size: 1.8rem;
        }
    }
</style>