@extends('layouts.app')

@section('content')
<div class="products-page">
    <h1>Tous les Produits</h1>

    <!-- Messages d'alerte -->
    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif

    <div class="products-grid">
        @foreach($products as $product)
        <div class="product">
            <div class="imgbox">
                <img src="{{ asset('storage/' . $product->image) }}" 
                     alt="{{ $product->name }}"
                     loading="lazy">
            </div>
            <div class="details">
                <h1>{{ $product->name }}</h1>
                @if($product->category)
                    <span> Category: {{ $product->category->name }}</span>
                @else
                    <span class="category-name">No category assigned</span>
                @endif

                <div class="price">{{ number_format($product->price, 2) }} MAD</div>
                
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    
                    <!-- Champ quantité -->
                    <label>Quantité</label>
                    <input type="number" 
                           name="quantity" 
                           value="1" 
                           min="1" 
                           max="{{ $product->stock }}"
                           style="width: 100%; padding: 5px; margin: 5px 0 15px;"
                    required class="quantity-input">
                    
                    <!-- Sélecteur de couleur -->
                    @if($product->colors->count() > 0)
                    <label for="color-{{ $product->id }}">Couleurs</label>
                    <select name="color" id="color-{{ $product->id }}" class="color-select" required>
                        <option value="">Choisir une couleur</option>
                        @foreach($product->colors as $color)
                        <option value="{{$color->name}}" style="background-color: {{ $color->hex_code }};">{{ $color->name }}</option>
                        @endforeach
                    </select>
                    @endif
                    
                    <button type="submit">Ajouter au panier</button>
                    <a href="{{ route('product.show', $product->id) }}" class="view-details">
                        Voir détails
                    </a>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

<style>
body {
    margin: 0;
    padding: 0;
    background: white;
    font-family: Arial, Helvetica, sans-serif;
}

.products-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.products-page h1 {
    text-align: center;
    color: #04456f;
    margin-bottom: 30px;
}

.alert {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 4px;
}

.success {
    background-color: #d4edda;
    color: #155724;
}

.error {
    background-color: #f8d7da;
    color: #721c24;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 30px;
    padding: 20px 0;
}

.product {
    position: relative;
    width: 100%;
    height: 400px;
    background: white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border-radius: 10px;;
    overflow: hidden;
}

.product .imgbox {
    height: 100%;
    box-sizing: border-box;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product .imgbox img {
    display: block;
    width: 90%;
    max-height: 80%;
    object-fit: contain;
}

.details {
    position: absolute;
    width: 100%;
    bottom: -200px;
    background: white;
    padding: 15px;
    box-sizing: border-box;
    box-shadow: 0 0 0 rgba(0, 0, 0, 0);
    transition: 0.5s;
}

.product:hover .details {
    bottom: 0;
    box-shadow: 0 -5px 15px rgba(0, 0, 0, 0.1);
}

.details h1 {
    margin: 0;
    padding: 0;
    font-size: 18px;
    width: 100%;
    text-align: left;
}

.details h1 span {
    font-size: 14px;
    color: rgb(141, 137, 137);
    font-weight: normal;
}

.details .price {
    position: absolute;
    top: 15px;
    right: 20px;
    font-weight: bold;
    color: #ff4242;
    font-size: 20px;
}

form{
    margin-top: 10px;
}

label {
    display: block;
    margin-top: 5px;
    font-weight: bold;
    font-size: 14px;
    color: #274472;
}

.quantity-input, .color-select {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 0.9rem;
}
    
    .color-select {
        margin-bottom: 5px;
    }

button, .view-details {
    display: block;
    padding: 8px;
    color: #fff;
    margin: 10px 0;
    background: #04456f;
    text-align: center;
    text-decoration: none;
    transition: 0.3s;
    cursor: pointer;
    border: none;
    width: 100%;
    font-size: 14px;
}

button:hover, .view-details:hover {
    background: #00c8ff;
}

.view-details {
    background: #5885AF;
}

@media (max-width: 768px) {
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    }
    
    .product {
        height: 380px;
    }
}
</style>