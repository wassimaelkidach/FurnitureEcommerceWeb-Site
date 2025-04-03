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
