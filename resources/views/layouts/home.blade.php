@extends('layouts.app')

@section('title', 'Nos Catégories')

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
                            <g clip-path="url(#clip0_250_225)">
                                    <path d="M14.6776 12.93C15.888 11.2784 16.4301 9.23062 16.1955 7.19644C15.9609 5.16226 14.9668 3.29168 13.4123 1.95892C11.8577 0.626155 9.85727 -0.070492 7.81113 0.00834944C5.76499 0.0871909 3.82407 0.935706 2.37667 2.38414C0.929274 3.83257 0.0821478 5.7741 0.00477057 7.8203C-0.0726067 9.86649 0.625471 11.8665 1.95934 13.4201C3.29322 14.9737 5.16451 15.9663 7.19886 16.1995C9.2332 16.4326 11.2806 15.8891 12.9313 14.6775H12.9301C12.9676 14.7275 13.0076 14.775 13.0526 14.8213L17.8651 19.6338C18.0995 19.8683 18.4174 20.0001 18.749 20.0003C19.0806 20.0004 19.3987 19.8688 19.6332 19.6344C19.8678 19.4 19.9996 19.082 19.9997 18.7504C19.9998 18.4189 19.8682 18.1008 19.6338 17.8663L14.8213 13.0538C14.7766 13.0085 14.7286 12.968 14.6776 12.93ZM15.0001 8.125C15.0001 9.02784 14.8223 9.92184 14.4768 10.756C14.1313 11.5901 13.6248 12.348 12.9864 12.9864C12.348 13.6248 11.5901 14.1312 10.756 14.4767C9.92192 14.8222 9.02792 15 8.12508 15C7.22225 15 6.32825 14.8222 5.49414 14.4767C4.66002 14.1312 3.90213 13.6248 3.26373 12.9864C2.62532 12.348 2.11891 11.5901 1.77341 10.756C1.42791 9.92184 1.25008 9.02784 1.25008 8.125C1.25008 6.30164 1.97441 4.55296 3.26373 3.26364C4.55304 1.97433 6.30172 1.25 8.12508 1.25C9.94845 1.25 11.6971 1.97433 12.9864 3.26364C14.2758 4.55296 15.0001 6.30164 15.0001 8.125Z" fill="#1E1E1E"></path>
                                </g>
                                <defs>
                                    <clipPath id="clip0_250_225">
                                        <rect width="20" height="20" fill="white"></rect>
                                    </clipPath>
                                </defs>
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
            <h2>Nos Catégories de Produits</h2>
            <p>Trouvez ce que vous cherchez</p>
            <div class="categories-container">
            @foreach($categories as $category)
        <div class="categories">
        <div class="category">
                
                @if($category->image && Storage::disk('public')->exists('categories/'.basename($category->image)))
                    <img src="{{ asset('storage/categories/' . basename($category->image)) }}" 
                         class="img-cover"
                         alt="{{ $category->name }}">
                @else
                    <div class="d-flex align-items-center justify-content-center text-muted">
                        <i class="fas fa-image fa-4x opacity-25"></i>
                    </div>
                @endif
                
                <div class="card-body">
                    <h5 class="h5 card-title">{{ $category->name }}</h5>
                    <a href="{{ route('category.products', $category->id) }}" class="btn btn-primary">
                       <i class="fas fa-arrow-right me-2"></i>Voir les produits <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="15px" width="15px" class="icon"></svg>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
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