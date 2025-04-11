@extends('layouts.app')

@section('title', 'Résultats de recherche')

@section('content')
<style>
    /* Style général plus compact */
    .search-results-section {
        padding: 2rem 0;
        background-color: #f9f9f9;
        min-height: 70vh;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        color: #2c3e50;
        margin-bottom: 1rem;
        font-weight: 700;
    }

    /* Message aucun résultat */
    .no-results {
        font-size: 1rem;
        color: #7f8c8d;
        margin-top: 1.5rem;
    }

    /* Grille de produits plus compacte */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    /* Carte produit plus compacte */
    .product-card {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.2s ease;
    }

    .product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Image produit */
    .img-cover {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    /* Placeholder image */
    .no-image {
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f7fa;
        color: #bdc3c7;
    }

    /* Détails produit plus compact */
    .product-info {
        padding: 1rem;
    }

    .product-card h3 {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #34495e;
    }

    .price {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2ecc71;
        margin-bottom: 0.8rem;
    }

    /* Options de produit compactes */
    .product-options {
        margin-bottom: 0.8rem;
    }

    .product-options label {
        display: block;
        font-size: 0.75rem;
        color: #7f8c8d;
        margin-bottom: 0.2rem;
    }

    .product-options input,
    .product-options select {
        width: 100%;
        padding: 0.4rem;
        margin-bottom: 0.4rem;
        border: 1px solid #e0e0e0;
        border-radius: 4px;
        font-size: 0.85rem;
    }

    /* Actions produit compactes */
    .product-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }

    .action-btn {
        background: white;
        border: 1px solid #e0e0e0;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #7f8c8d;
        font-size: 0.9rem;
    }

    .action-btn:hover {
        background: #3498db;
        color: white;
        border-color: #3498db;
    }

    /* Pagination compacte */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
        padding: 0.5rem 0;
    }

    .pagination li {
        margin: 0 0.3rem;
    }

    .pagination li a, 
    .pagination li span {
        padding: 0.3rem 0.8rem;
        font-size: 0.9rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }
        
        .img-cover, .no-image {
            height: 150px;
        }
    }

    @media (max-width: 480px) {
        .products-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        h1 {
            font-size: 1.5rem;
        }
    }
</style>

<section class="search-results-section">
    <div class="container">
        <h1>Résultats pour "{{ $query }}"</h1>
        
        @if($products->isEmpty())
            <p class="no-results">Aucun produit trouvé pour votre recherche.</p>
        @else
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <a href="{{ route('product.show', $product->id) }}">
                            @if($product->image && Storage::disk('public')->exists('products/'.basename($product->image)))
                                <img src="{{ asset('storage/products/' . basename($product->image)) }}" 
                                     class="img-cover"
                                     alt="{{ $product->name }}">
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image fa-2x"></i>
                                </div>
                            @endif
                        </a>
                        
                        <div class="product-info">
                            <h3>{{ Str::limit($product->name, 40) }}</h3>
                            <span class="price">{{ number_format($product->price, 2) }} MAD</span>
                            
                            <div class="product-options">
                                <label for="quantity-{{ $product->id }}">Qté:</label>
                                <input type="number" 
                                       id="quantity-{{ $product->id }}"
                                       class="quantity-input"
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->stock }}">
                                
                                @if($product->colors->count() > 0)
                                <label for="color-{{ $product->id }}">Couleur:</label>
                                <select id="color-{{ $product->id }}" class="color-select">
                                    <option value="">Choisir</option>
                                    @foreach($product->colors as $color)
                                    <option value="{{ $color->name }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                            
                            <div class="product-actions">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" class="quantity-field" value="1">
                                    <input type="hidden" name="color" class="color-field" value="">
                                    <button type="submit" class="action-btn" title="Ajouter au panier">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </form>
                                
                                <form action="{{ route('favorites.store', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="action-btn favorite" title="Favoris">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            {{ $products->links() }}
        @endif
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mise à jour des champs cachés du formulaire
    document.querySelectorAll('.product-card').forEach(card => {
        const quantityInput = card.querySelector('.quantity-input');
        const quantityField = card.querySelector('.quantity-field');
        const colorSelect = card.querySelector('.color-select');
        const colorField = card.querySelector('.color-field');
        
        if (quantityInput && quantityField) {
            quantityInput.addEventListener('change', function() {
                quantityField.value = this.value;
            });
        }
        
        if (colorSelect && colorField) {
            colorSelect.addEventListener('change', function() {
                colorField.value = this.value;
            });
        }
    });
});
</script>
@endsection