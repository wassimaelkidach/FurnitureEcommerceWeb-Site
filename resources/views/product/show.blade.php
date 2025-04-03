@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="product-detail-container">
    <div class="product-gallery">
        <!-- Image principale -->
        <div class="main-image">
            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="product-main-img">
        </div>
        
        <!-- Miniatures -->
        <div class="thumbnails">
            @foreach($product->images as $image)
            <div class="thumbnail">
                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image produit supplémentaire">
            </div>
            @endforeach
        </div>
    </div>

    <div class="product-info">
        <h1 class="product-title">{{ $product->name }}</h1>
        
        <div class="product-rating">
            <div class="stars">
                @php $avgRating = round($product->reviews->avg('rating'), 1) @endphp
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= $avgRating)
                        <i class="fas fa-star"></i>
                    @else
                        <i class="far fa-star"></i>
                    @endif
                @endfor
            </div>
            <span>{{ $avgRating }}/5 ({{ $product->reviews->count() }} avis)</span>
        </div>

        <p class="product-description">{{ $product->description }}</p>
        
        <div class="product-price">
            {{ number_format($product->price, 2) }} MAD
        </div>

        <div class="product-actions">
    <!-- Ajouter au panier -->
    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
        @csrf
        <div class="quantity-selector">
            <button type="button" class="quantity-btn minus">-</button>
            <input type="number" name="quantity" value="1" min="1" class="quantity-input">
            <button type="button" class="quantity-btn plus">+</button>
        </div>
        <button type="submit" class="add-to-cart-btn">
            <i class="fas fa-shopping-cart"></i> Ajouter au panier
        </button>
    </form>
    
    <!-- Ajouter aux favoris -->
    <form action="{{ route('favorites.store', $product->id) }}" method="POST" class="favorite-form">
        @csrf
        <button type="submit" class="favorite-btn">
            <i class="far fa-heart"></i> Ajouter aux favoris
        </button>
    </form>
</div>
    </div>

    <!-- Section des avis -->
    <div class="reviews-section">
        <h2 class="section-title"><i class="fas fa-comments"></i> Avis des clients</h2>
        
        @if($product->reviews->count() > 0)
            <div class="reviews-list">
                @foreach($product->reviews as $review)
                <div class="review-card">
                    <div class="review-header">
                        <div class="reviewer-info">
                            <div class="reviewer-avatar">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                            <div>
                                <strong>{{ $review->user->name }}</strong>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <small class="review-date">{{ $review->created_at->format('d/m/Y') }}</small>
                    </div>
                    <p class="review-comment">{{ $review->comment }}</p>
                </div>
                @endforeach
            </div>
        @else
            <p class="no-reviews">Aucun avis pour ce produit</p>
        @endif

        <!-- Formulaire d'avis -->
        @auth
            <div class="review-form">
                <h3><i class="fas fa-pencil-alt"></i> Laisser votre avis</h3>
                <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Votre note</label>
                        <div class="rating-input">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                                <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="comment">Votre avis</label>
                        <textarea name="comment" rows="4" required placeholder="Décrivez votre expérience avec ce produit..."></textarea>
                    </div>
                    
                    <button type="submit" class="submit-review">Publier votre avis</button>
                </form>
            </div>
        @else
            <div class="auth-prompt">
                <a href="{{ route('login') }}" class="login-link">Connectez-vous</a> pour laisser un avis.
            </div>
        @endauth
    </div>
</div>
@endsection

<style>
    /* Base Styles */
    .product-detail-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
        font-family: 'Montserrat', sans-serif;
        color: #333;
        display: grid;
        gap: 2rem;
    }

    /* Gallery Styles */
    .product-gallery {
        display: grid;
        gap: 1.5rem;
    }

    .main-image {
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        height: 400px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f9f9f9;
    }

    .product-main-img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .thumbnails {
        display: flex;
        gap: 1rem;
        overflow-x: auto;
        padding-bottom: 1rem;
    }

    .thumbnail {
        width: 80px;
        height: 80px;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow: hidden;
        cursor: pointer;
        flex-shrink: 0;
        transition: transform 0.2s;
    }

    .thumbnail:hover {
        transform: scale(1.05);
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Product Info Styles */
    .product-title {
        font-size: 2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #222;
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .stars {
        color: #FFD700;
    }

    .product-description {
        line-height: 1.6;
        margin-bottom: 1.5rem;
        color: #555;
    }

    .product-price {
        font-size: 1.8rem;
        font-weight: 700;
        color: #B3AC9D;
        margin-bottom: 2rem;
    }

    /* Actions Styles */
    .product-actions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 2rem;
    }

    .quantity-selector {
        display: flex;
        margin-bottom: 0.5rem;
    }

    .quantity-btn {
        width: 40px;
        height: 40px;
        background: #f1f1f1;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }

    .quantity-btn:hover {
        background: #e0e0e0;
    }

    .quantity-input {
        width: 60px;
        height: 40px;
        text-align: center;
        border: 1px solid #ddd;
        margin: 0 5px;
    }

    .add-to-cart-btn, .favorite-btn, .submit-review {
        width: 100%;
        padding: 0.8rem;
        border-radius: 4px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .add-to-cart-btn {
        background: #B3AC9D;
        color: white;
        border: none;
    }

    .add-to-cart-btn:hover {
        background: #7A7568;
    }

    .favorite-btn {
        background: white;
        color: #B3AC9D;
        border: 1px solid #B3AC9D;
    }

    .favorite-btn:hover {
        background: #F5F3EE;
    }

    .favorite-btn.active {
        background: #ff4757;
        color: white;
        border-color: #ff4757;
    }

    /* Reviews Styles */
    .reviews-section {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid #eee;
    }

    .section-title {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        color: #222;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .review-card {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .reviewer-avatar {
        width: 40px;
        height: 40px;
        background: #B3AC9D;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    .review-rating {
        color: #FFD700;
        font-size: 0.9rem;
    }

    .review-date {
        color: #999;
    }

    .review-comment {
        line-height: 1.6;
        color: #555;
    }

    .no-reviews {
        text-align: center;
        padding: 2rem;
        background: #f9f9f9;
        border-radius: 8px;
        color: #666;
    }

    /* Review Form Styles */
    .review-form {
        background: white;
        border-radius: 8px;
        padding: 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-top: 2rem;
    }

    .review-form h3 {
        margin-bottom: 1.5rem;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        margin-top: 0.5rem;
    }

    .rating-input input {
        display: none;
    }

    .rating-input label {
        color: #ddd;
        font-size: 1.5rem;
        cursor: pointer;
        transition: color 0.2s;
    }

    .rating-input input:checked ~ label,
    .rating-input input:hover ~ label,
    .rating-input label:hover ~ label {
        color: #FFD700;
    }

    textarea {
        width: 100%;
        padding: 1rem;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-family: inherit;
        resize: vertical;
        min-height: 120px;
    }

    .submit-review {
        background: #B3AC9D;
        color: white;
        border: none;
    }

    .submit-review:hover {
        background: #7A7568;
    }

    .auth-prompt {
        text-align: center;
        padding: 2rem;
        background: #f9f9f9;
        border-radius: 8px;
    }

    .login-link {
        color: #B3AC9D;
        font-weight: 500;
        text-decoration: none;
    }

    .login-link:hover {
        text-decoration: underline;
    }

    /* Responsive Styles */
    @media (min-width: 768px) {
        .product-detail-container {
            grid-template-columns: 1fr 1fr;
        }
        
        .reviews-section {
            grid-column: span 2;
        }
    }

    @media (max-width: 767px) {
        .main-image {
            height: 300px;
        }
    }
</style>
