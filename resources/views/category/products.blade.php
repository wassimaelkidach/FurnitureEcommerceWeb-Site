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
                        
                        <p class="product-price">{{ number_format($product->price, 2) }} MAD</p>
                        
                        <div class="product-buttons">
                            <a href="{{ route('product.show', $product->id) }}" class="details-btn">
                                <i class="fas fa-eye"></i>voir les détails
                            </a>
                            
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <div class="quantity-selector">
                                   <input type="number" name="quantity" value="1" min="1" class="quantity-input">
        
                                   
                                    <select name="color" class="color-selector" required>
                                        <option value="">Choisir une couleur</option>
                                        @foreach($product->colors as $color)
                                        <option value="{{$color->name}}" style="background-color: {{ $color->hex_code }};">{{ $color->name }}</option>
                                        @endforeach
                                    </select>
        
                                    <button type="submit" class="add-to-cart-btn">
                                    <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <style>
    /* Variables CSS */
    :root {
        --primary-color: #41729F;
        --secondary-color: #274472;
        --accent-color: #4cc9f0;
        --dark-color: #2b2d42;
        --light-color: #f8f9fa;
        --success-color: #4CAF50;
        --warning-color: #f8961e;
        --error-color: #f94144;
        --border-radius: 8px;
        --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    /* Style général */
    .category-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    .category-title {
        font-size: 2rem;
        color: var(--dark-color);
        margin-bottom: 2rem;
        text-align: center;
        font-weight: 600;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .category-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: var(--primary-color);
    }

    /* Grille de produits */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        padding: 1rem 0;
    }

    /* Carte de produit */
    .product-card {
        background: white;
        border-radius: var(--border-radius);
        overflow: hidden;
        box-shadow: var(--box-shadow);
        transition: var(--transition);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }

    /* Image du produit */
    .product-image-container {
        position: relative;
        height: 220px;
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
        z-index: 2;
    }

    .favorite-btn {
        background: rgba(255, 255, 255, 0.9);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: var(--box-shadow);
        color: #ccc;
        transition: var(--transition);
    }

    .favorite-btn:hover, .favorite-btn.active {
        color: var(--error-color);
        transform: scale(1.1);
    }

    /* Informations du produit */
    .product-info {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .product-name {
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        color: var(--dark-color);
        font-weight: 600;
        line-height: 1.4;
    }

    .product-price {
        font-size: 1.3rem;
        color: var(--primary-color);
        font-weight: 700;
        margin: 0.5rem 0 1.5rem;
    }

    /* Sélecteur de couleur */
    .color-selector {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        margin-bottom: 0.8rem;
        font-size: 0.9rem;
        background: white;
        cursor: pointer;
        transition: var(--transition);
    }

    .color-selector:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.2);
    }

    /* Boutons */
    .product-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
        margin-top: auto;
    }

    .details-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: var(--primary-color);
        color: white;
        padding: 0.7rem;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-size: 0.9rem;
        transition: var(--transition);
        text-align: center;
    }

    .details-btn:hover {
        background: var(--secondary-color);
        color: white;
    }

    /* Formulaire d'ajout au panier */
    .quantity-selector {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .quantity-input {
        width: 60px;
        padding: 0.7rem;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        text-align: center;
        font-size: 0.9rem;
        -moz-appearance: textfield;
    }

    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .add-to-cart-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        background: var(--success-color);
        color: white;
        border: none;
        padding: 0.7rem;
        border-radius: var(--border-radius);
        cursor: pointer;
        font-size: 0.9rem;
        transition: var(--transition);
        flex-grow: 1;
    }

    .add-to-cart-btn:hover {
        background: #3e8e41;
    }

    /* Animation de notification */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 1.5rem;
        }
        
        .product-image-container {
            height: 180px;
        }
        
        .quantity-selector {
            flex-direction: row;
        }
    }

    @media (max-width: 480px) {
        .category-title {
            font-size: 1.5rem;
        }
        
        .products-grid {
            grid-template-columns: 1fr;
        }
        
        .product-buttons {
            flex-direction: column;
        }
        
        .quantity-selector {
            width: 100%;
        }
        
        .quantity-input {
            width: 100%;
        }
    }
</style>

<script>
    // Gestion de la sélection de couleur
    document.querySelectorAll('.color-selector').forEach(select => {
        select.addEventListener('change', function() {
            if (this.value) {
                this.style.borderColor = '#4CAF50';
            } else {
                this.style.borderColor = '#ddd';
            }
        });
    });

    // Validation du formulaire avant soumission
    document.querySelectorAll('form[action*="cart/add"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            const colorSelect = form.querySelector('.color-selector');
            if (!colorSelect.value) {
                e.preventDefault();
                colorSelect.style.borderColor = 'var(--error-color)';
                colorSelect.focus();
                
                // Animation d'erreur
                colorSelect.animate([
                    { transform: 'translateX(0)' },
                    { transform: 'translateX(-5px)' },
                    { transform: 'translateX(5px)' },
                    { transform: 'translateX(0)' }
                ], {
                    duration: 300,
                    iterations: 2
                });
                
                return false;
            }
        });
    });

    // Gestion des quantités
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            if (this.value < 1) this.value = 1;
        });
    });
</script>
@endsection