@extends('layouts.app')
@section('content')

    <section class="landing-page-section">

        <div class="hero">

            <h1 class="buy">Achetez vos meubles de rêve !</h1>
                <div class="stats">
                    <div class="stat stat1">
                        <span>50+</span>
                        <p>Meubles pour la maison</p>
                    </div>
                    <div class="stat">
                        <span>100+</span>
                        <p>Clients satisfaits</p>
                    </div>
                </div>
            

            <div class="cta">
                <div class="input-search-container">
                    <div class="search-wrapper">
                        <input type="text" name="search" class="search" placeholder="Que recherchez-vous ?">
                        <button type="submit" class="button-search">
                        <div style="display: flex;">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Icône de recherche (inchangée) -->
                            </svg>
                        </div>
                        </button>
                    </div>
                </div>
                
            </div>
        </div>
        
    </section>

<section class="categories-section">

    <div class="container">
        <h2>Catégories</h2>

        <p>Trouvez ce que vous cherchez</p>
        <div class="categories-container">
            @foreach($categories as $category)
                <div class="categories">
                    <div class="category">
                        @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top" alt="{{ $category->name }}">
                        @else
                            <img src="{{ asset('images/category-placeholder.jpg') }}" class="card-img-top" alt="{{ $category->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <a href="{{ route('category.products', $category->id) }}" class="btn btn-primary">voir les produits <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="15px" width="15px" class="icon">
                            <!-- Icône flèche (inchangée) -->
                            </svg></a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

    <section class="best-selling">
        <h2>Nos meubles les plus vendus</h2>
        <div class="trendyproducts">
            <div class="products">
                <div class="product">

                </div>
            </div>

        </div>
    
    </section>

    <section class="delivery-section">
        <div class="delivery-container">
            <h2>Commandez maintenant</h2>
            <div class="delivery-features">
            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <h2>Grand choix</h2>
                <p>Nous proposons de nombreux types de produits avec moins de variations dans chaque catégorie.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h2>Livraison rapide et gratuite</h2>
                <p>Délai de livraison de 4 jours ou moins, livraison gratuite et option de livraison express.</p>
            </div>
            <div class="feature">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h2>Support 24/7</h2>
                <p>Réponses à toute demande commerciale 24h/24 et 7j/7 en temps réel.</p>
            </div>
            </div> 
        </div>
    </section>


<section class="reviews-section">
    <div class="reviews-container">
        <h2>Ce que nos clients disent de nous !</h2>
        
        <div class="reviews-grid">

            <div class="card">
                <div class="header">
                    <div class="image"><img src="{{ asset('images/john.png') }}" alt=""></div>
                    
                    <div class="stars">
                        <!-- Étoiles de notation (inchangées) -->
                    </div>
                    <p class="name">John Doe</p>
            
                
                </div>

                <p class="message">
                "J'adore absolument les meubles de Dwira ! Les designs sont modernes, élégants et incroyablement confortables. La qualité est exceptionnelle et le service client était excellent. Je recommande vivement !"
               </p>
            </div>

            <div class="card">
                <div class="header">
                    <div class="image"><img src="{{ asset('images/crestina.png') }}" alt=""></div>
                    
                    <div class="stars">
                        <!-- Étoiles de notation (inchangées) -->
                    </div>
                    <p class="name">Crestina Dauth</p>
            
                
                </div>

                <p class="message">
                "J'adore absolument les meubles de Dwira ! Les designs sont modernes, élégants et incroyablement confortables. La qualité est exceptionnelle et le service client était excellent. Je recommande vivement !"
               </p>
            </div>
            
        </div>
    </div>
</section>

<!-- Pied de page -->
    <footer>
        <div class="footer-brand">
            <h3 class="logo">dwira</h3>
        </div>
        <div class="footer-links">
            <a href="#">Accueil</a>
            <a href="#">Produits</a>
            <a href="#">Catégories</a>
            <a href="#">À propos</a>
            <a href="#">Contactez-nous</a>
        </div>
        <div class="footer-contact">
            <p>+212 (06) 644121800</p> <br>
            <p>&copy; 2025 Dwira Style. Tous droits réservés</p>

        </div>
        
    </footer>
@endsection