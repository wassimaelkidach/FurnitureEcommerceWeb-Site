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


            
            <div class="img-supp">
               @if($product->images->count() > 0)
             <div class="image-thumbnails">
             @foreach($product->images as $image)
                <div class="thumbnail-wrapper">
                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                         alt="Vue supplémentaire de {{ $product->name }}"
                         class="thumbnail-img"
                         onclick="previewImage(this)">
                </div>
               @endforeach
              </div>
              @endif
            </div>

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
                        <option value="{{ $color->id}}" style="background-color: {{ $color->hex_code }}; color: #fff; padding: 8px;">
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
    </div


    <!-- Section des avis -->
    <div class="customer-reviews">
        <div class="reviews-header">
            <h2 class="reviews-title">Avis des clients</h2>
            <div class="reviews-summary">
                <div class="average-rating">
                    {{ number_format($product->reviews->avg('rating'), 1) }}/5
                </div>
                <div class="stars">
                    @php
                        $avgRating = $product->reviews->avg('rating');
                        $fullStars = floor($avgRating);
                        $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                    @endphp
                    
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $fullStars)
                            <i class="fas fa-star filled"></i>
                        @elseif($i == $fullStars + 1 && $hasHalfStar)
                            <i class="fas fa-star-half-alt filled"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <div class="reviews-count">
                    {{ $product->reviews->count() }} avis
                </div>
            </div>
        </div>
        
        @if($product->reviews->count() > 0)
            <div class="reviews-grid">
                @foreach($product->reviews as $review)
                <div class="review-card">
                    <div class="reviewer-info">
                        <div class="reviewer-avatar">
                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                        </div>
                        <div class="reviewer-details">
                            <div class="reviewer-name">{{ $review->user->name }}</div>
                            <div class="review-date">{{ $review->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    <div class="review-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                <i class="fas fa-star filled"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="review-content">
                        <p>{{ $review->comment }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="no-reviews">
                <i class="fas fa-comment-alt"></i>
                <p>Aucun avis pour ce produit</p>
            </div>
        @endif

        @auth
        <div class="add-review">
            <h3 class="add-review-title">Donnez votre avis</h3>
            <form action="{{ route('reviews.store', $product->id) }}" method="POST" class="review-form">
                @csrf
                <div class="rating-input">
                    <label>Votre note</label>
                    <div class="star-rating">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="rating-{{ $i }}" name="rating" value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }}>
                            <label for="rating-{{ $i }}" class="star-label"><i class="far fa-star"></i></label>
                        @endfor
                    </div>
                </div>
                <div class="review-textarea">
                    <label for="review-comment">Votre avis</label>
                    <textarea id="review-comment" name="comment" rows="4" required></textarea>
                </div>
                <button type="submit" class="submit-review">Publier votre avis</button>
            </form>
        </div>
        @else
        <div class="review-login-prompt">
            <p>Vous devez <a href="{{ route('login') }}">vous connecter</a> pour laisser un avis.</p>
        </div>
        @endauth
    </div>
</div>

<style>
:root {
    --primary: #5885AF;
    --primary-dark: #274472;
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
    background: var(--primary-dark);
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


/* Galerie d'images supplémentaires */
.gallery-title {
    font-size: 1.2rem;
    color: var(--primary-dark);
    margin: 1.5rem 0 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid var(--border);
}

.image-thumbnails {
    display: flex;
    flex-wrap: wrap;
    gap: 0.8rem;
    margin-top: 1rem;
}

.thumbnail-wrapper {
    width: 80px;
    height: 80px;
    border: 1px solid rgba(0,0,0,0.1);
    border-radius: 6px;
    overflow: hidden;
    transition: all 0.2s ease;
    cursor: pointer;
}

.thumbnail-wrapper:hover {
    transform: translateY(-3px);
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    border-color: var(--primary);
}

.thumbnail-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

@media (max-width: 768px) {
    .thumbnail-wrapper {
        width: 70px;
        height: 70px;
    }
}
/* Images supplémentaires */
.product-images-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.additional-image {
    border: 1px solid #eee;
    border-radius: 6px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
}

.additional-image:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.additional-thumbnail {
    width: 100%;
    height: 120px;
    object-fit: cover;
}

/* Lightbox style */
.lightbox {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    cursor: zoom-out;
}

.lightbox img {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
}

@media (max-width: 768px) {
    .product-images-grid {
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
    }
    
    .additional-thumbnail {
        height: 90px;
    }
}

/* Section des avis */
.review-box {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: transform 0.2s ease;
    margin-bottom: 20px;
    padding: 10px;
}

.review-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.review-box strong {
    font-size: 1.1rem;
    color: var(--primary);
}

.review-box p {
    margin: 0.5rem 0;
    color: var(--text);
    line-height: 1.5;
}

.review-box small {
    color: #888;
    font-size: 0.85rem;
}




@media (max-width: 768px) {
    .similar-products-sidebar {
        flex-direction: row;
        overflow-x: auto;
        overflow-y: hidden;
        max-height: none;
        padding-bottom: 0.5rem;
    }
    
    .similar-product {
        flex-direction: column;
        min-width: 150px;
    }
    
    .similar-image, .similar-image-placeholder {
        width: 100%;
        height: 120px;
    }
}

/* Formulaire d'avis */
.customer-reviews {
    border-top: 1px solid var(--light-gray);
    padding-top: 3rem;
}

.reviews-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.reviews-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--dark);
}

.reviews-summary {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.average-rating {
    font-size: 1.5rem;
    font-weight: 700;
    color: #FFD700;
}

.stars {
    display: flex;
    gap: 0.25rem;
}

.stars i, .review-rating i {
    color: #FFD700;
    margin-right: 2px;
}

.stars .far, .review-rating .far {
    color: #ccc;
}

.stars .fa-star-half-alt {
    color: #FFD700;
}

.reviews-count {
    color: var(--dark-gray);
    font-size: 0.9rem;
}

.reviews-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.review-card {
    background: var(--white);
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: var(--shadow-sm);
    transition: var(--transition);
}

.review-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-md);
}

.reviewer-info {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.reviewer-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--primary);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.reviewer-name {
    font-weight: 600;
    color: var(--dark);
}

.review-date {
    font-size: 0.85rem;
    color: var(--dark-gray);
}

.review-rating {
    margin-bottom: 0.5rem;
}

.review-content p {
    line-height: 1.6;
    color: var(--dark);
}

.no-reviews {
    text-align: center;
    padding: 2rem;
    color: var(--dark-gray);
}

.no-reviews i {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--medium-gray);
}

.add-review {
    background: var(--white);
    border-radius: 12px;
    padding: 2rem;
    box-shadow: var(--shadow-sm);
    max-width: 600px;
    margin: 0 auto;
}

.add-review-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    color: var(--dark);
    text-align: center;
}

.review-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.rating-input {
    text-align: center;
}

.star-rating {
    display: flex;
    justify-content: center;
    flex-direction: row-reverse;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.star-rating input {
    display: none;
}

.star-label {
    font-size: 1.75rem;
    cursor: pointer;
    transition: var(--transition);
}

.star-rating input:checked ~ .star-label i,
.star-rating input:hover ~ .star-label i,
.star-rating .star-label:hover i,
.star-rating .star-label:hover ~ .star-label i {
    color: #FFD700;
    font-weight: 900;
}

.review-textarea {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.review-textarea label {
    font-weight: 600;
    color: var(--dark);
}

.review-textarea textarea {
    width: 100%;
    padding: 1rem;
    border: 1px solid var(--medium-gray);
    border-radius: 8px;
    min-height: 120px;
    resize: vertical;
    font-family: inherit;
    transition: var(--transition);
}

.review-textarea textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 2px rgba(67, 97, 238, 0.2);
}

.submit-review {
    background:rgb(250, 223, 49);
    color: var(--white);
    border: none;
    padding: 1rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
}

.submit-review:hover {
    background:rgb(239, 212, 39);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.review-login-prompt {
    text-align: center;
    margin-top: 2rem;
    color: var(--dark-gray);
}

.review-login-prompt a {
    color: var(--secondary);
    font-weight: 600;
    text-decoration: none;
}

.review-login-prompt a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 992px) {
    .product-hero {
        flex-direction: column;
    }
    
    .main-image-container {
        height: 400px;
    }
    
    .product-header {
        margin-top: 1.5rem;
    }
    
    .reviews-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}
</style>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de la quantité
    const minusBtn = document.querySelector('.quantity-adjust.minus');
    const plusBtn = document.querySelector('.quantity-adjust.plus');
    const quantityInput = document.querySelector('.quantity-input');
    
    function updateQuantityButtons() {
        const value = parseInt(quantityInput.value);
        const min = parseInt(quantityInput.min);
        const max = parseInt(quantityInput.max);
        
        minusBtn.disabled = value <= min;
        plusBtn.disabled = value >= max;
    }
    
    if (minusBtn && plusBtn && quantityInput) {
        updateQuantityButtons();
        
        minusBtn.addEventListener('click', () => {
            let value = parseInt(quantityInput.value);
            if (value > parseInt(quantityInput.min)) {
                quantityInput.value = value - 1;
                updateQuantityButtons();
            }
        });
        
        plusBtn.addEventListener('click', () => {
            let value = parseInt(quantityInput.value);
            if (value < parseInt(quantityInput.max)) {
                quantityInput.value = value + 1;
                updateQuantityButtons();
            }
        });
        
        quantityInput.addEventListener('change', function() {
            let value = parseInt(this.value);
            this.value = Math.max(Math.min(value, parseInt(this.max)), parseInt(this.min));
            updateQuantityButtons();
        });
    }

    // Gestion de la sélection des étoiles
    document.querySelectorAll('.star-rating input').forEach(input => {
        input.addEventListener('change', function() {
            const rating = parseInt(this.value);
            const stars = this.parentElement.querySelectorAll('.star-label i');
            
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('far');
                    star.classList.add('fas');
                } else {
                    star.classList.remove('fas');
                    star.classList.add('far');
                }
            });
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    // Gestion du clic sur les miniatures
    const mainImage = document.querySelector('.product-image');
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
    
    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                mainImage.src = this.src;
            });
        });
    }
    
    // Lightbox pour l'image principale
    if (mainImage) {
        mainImage.addEventListener('click', function() {
            const lightbox = document.createElement('div');
            lightbox.style.position = 'fixed';
            lightbox.style.top = '0';
            lightbox.style.left = '0';
            lightbox.style.width = '100%';
            lightbox.style.height = '100%';
            lightbox.style.backgroundColor = 'rgba(0,0,0,0.8)';
            lightbox.style.display = 'flex';
            lightbox.style.alignItems = 'center';
            lightbox.style.justifyContent = 'center';
            lightbox.style.zIndex = '1000';
            lightbox.style.cursor = 'zoom-out';
            
            const img = document.createElement('img');
            img.src = this.src;
            img.style.maxWidth = '90%';
            img.style.maxHeight = '90%';
            img.style.objectFit = 'contain';
            
            lightbox.appendChild(img);
            document.body.appendChild(lightbox);
            
            lightbox.addEventListener('click', function() {
                document.body.removeChild(lightbox);
            });
        });
    }
});





function previewImage(element) {
    const lightbox = document.createElement('div');
    lightbox.style.position = 'fixed';
    lightbox.style.top = '0';
    lightbox.style.left = '0';
    lightbox.style.width = '100%';
    lightbox.style.height = '100%';
    lightbox.style.backgroundColor = 'rgba(0,0,0,0.9)';
    lightbox.style.display = 'flex';
    lightbox.style.alignItems = 'center';
    lightbox.style.justifyContent = 'center';
    lightbox.style.zIndex = '1000';
    lightbox.style.cursor = 'zoom-out';
    
    const img = document.createElement('img');
    img.src = element.src;
    img.alt = element.alt;
    img.style.maxWidth = '90%';
    img.style.maxHeight = '90%';
    img.style.objectFit = 'contain';
    
    lightbox.appendChild(img);
    document.body.appendChild(lightbox);
    
    lightbox.addEventListener('click', function() {
        document.body.removeChild(lightbox);
    });
}
</script>