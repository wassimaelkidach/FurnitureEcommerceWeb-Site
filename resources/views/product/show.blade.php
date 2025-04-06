@extends('layouts.app')

@section('content')
<div class="product-detail-container">
    <div class="product-wrapper">
        <!-- Image Gallery -->
        <div class="product-gallery">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
            @else
                <div class="image-placeholder">
                    <i class="fas fa-image"></i>
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="product-info">
            <h1>{{ $product->name }}</h1>
            <div class="price">{{ number_format($product->price, 2) }} MAD</div>
            
            <p class="description">{{ $product->description }}</p>

            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>Couleur</label>
                    <select name="color" required>
                        @foreach($product->colors as $color)
                        <option value="{{ $color->id }}" style="background-color: {{ $color->hex_code }}; color: #fff; padding: 8px;">
                            {{ $color->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Quantité</label>
                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" required>
                </div>

                <button type="submit">
                    <i class="fas fa-shopping-bag"></i>
                    Ajouter au panier
                </button>
            </form>
        </div>
    </div>
</div>

<style>
:root {
    --primary: #2a52be;
    --primary-dark: #1a3a8a;
    --accent: #ff4242;
    --text: #333;
    --light-bg: #f9f9f9;
    --border: #e0e0e0;
}

.product-detail-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.product-wrapper {
    display: flex;
    gap: 3rem;
}

.product-gallery {
    flex: 1;
}

.product-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.image-placeholder {
    height: 500px;
    background: var(--light-bg);
    display: grid;
    place-items: center;
    border-radius: 8px;
}

.image-placeholder i {
    font-size: 3rem;
    color: #ccc;
}

.product-info {
    flex: 1;
    padding-top: 1rem;
}

.product-info h1 {
    font-size: 2rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--text);
}

.price {
    font-size: 1.75rem;
    font-weight: 700;
    color: #ff4242;
    margin-bottom: 1.5rem;
}

.description {
    line-height: 1.6;
    margin-bottom: 2rem;
    color: var(--text);
}

form {
    border-top: 1px solid var(--border);
    padding-top: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

select, input[type="number"] {
    width: 100%;
    max-width: 300px;
    padding: 0.75rem;
    border: 1px solid var(--border);
    border-radius: 6px;
    font-size: 1rem;
}

select {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23333' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
    appearance: none;
}

button {
    background: var(--primary);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
}

button:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .product-wrapper {
        flex-direction: column;
        gap: 2rem;
    }
    
    .product-image, .image-placeholder {
        height: 350px;
    }
}
</style>
@endsection