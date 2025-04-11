<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Site E-commerce')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-color: #274472;
            --secondary-color: #5885AF;
            --accent-color: #C3E0E5;
            --text-color: #333;
            --light-text: #FFFFFF;
            --hover-color: #41729F;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text-color);
            background-color: white;
            line-height: 1.6;
        }
        
        /* Navigation Élégante */
        header {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
            background: #41729f;
            padding: 0 5%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        /* Logo Sophistiqué */
        .logo {
            font-family: 'Harrington', fantasy;
            font-size: 30px;
            font-weight: 700;
            color: var(--light-text);
            letter-spacing: 1.2px;
            position: relative;
        }
        
        .logo::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--accent-color);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        /* Menus */
        .nav-left, .nav-right {
            display: flex;
            list-style-type: none;
            align-items: center;
            height: 100%;
        }
        
        .nav-left {
            gap: 30px;
            margin-left: 40px;
        }
        
        .nav-right {
            gap: 25px;
        }
        
        /* Liens de navigation */
        nav ul li a {
            text-decoration: none;
            color: var(--light-text);
            font-weight: 500;
            font-size: 15px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            position: relative;
            height: 100%;
            padding: 0 5px;
        }
        
        /* Effet de survol élégant */
        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background-color: var(--accent-color);
            transition: width 0.3s ease;
        }
        
        nav ul li a:hover {
            color: var(--accent-color);
        }
        
        nav ul li a:hover::after {
            width: 100%;
        }
        
        /* Icônes */
        .nav-right li a i {
            font-size: 20px;
        }
        
        /* Style spécifique pour le panier */
        .cart-count {
            background: var(--accent-color);
            color: var(--primary-color);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            margin-left: 5px;
            font-weight: bold;
        }
        
        /* Barre de recherche stylée */
        .search-container {
            position: relative;
        }
        
        .search-container input {
            padding: 8px 15px 8px 35px;
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 30px;
            background: rgba(255,255,255,0.1);
            color: white;
            outline: none;
            transition: all 0.3s ease;
            width: 180px;
            height: 45px;
        }
        
        .search-container input::placeholder {
            color: rgba(255,255,255,0.7);
        }
        
        .search-container input:focus {
            width: 220px;
            background: rgba(255,255,255,0.2);
        }
        
        .search-container i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.7);
        }
        
        /* Tooltip pour les icônes */
        .nav-right li a[data-tooltip] {
            position: relative;
        }
        
        .nav-right li a[data-tooltip]::before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: -40px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--primary-color);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
        }
        
        .nav-right li a[data-tooltip]:hover::before {
            opacity: 1;
            visibility: visible;
            bottom: -35px;
        }
        /* Dans votre fichier CSS */
.search-results-section {
    padding: 40px 0;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px;
    margin-top: 30px;
}

.product-card {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.product-card .no-image {
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5f5f5;
    color: #ccc;
}

.product-card h3 {
    padding: 15px;
    margin: 0;
    font-size: 16px;
}

.product-card .price {
    padding: 0 15px 15px;
    font-weight: bold;
    color: var(--primary-color);
}
    </style>
</head>
<body>
    <!-- Header Élégant -->
    <header>
        <nav>
            <h1 class="logo">Dwira Style</h1>
            
            <ul class="nav-left">
         
    </li>
                <li><a href="{{ route('home') }}">Accueil</a></li>
                <li><a href="{{ route('products.index') }}">Produits</a></li>
                <li><a href="{{ route('aboutus') }}">À propos</a></li>
                <li><a href="{{ route('contact') }}">Contact</a></li>
                <li>
   
            </ul>
            
            <ul class="nav-right">
        
                <li><a href="{{ route('favorites.index') }}" data-tooltip="Favoris"><i class="fas fa-heart"></i></a></li>
                <li>
                    <a href="{{ route('cart.index') }}" data-tooltip="Panier">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </li>
                @guest
                <li><a href="{{ route('login') }}" data-tooltip="Connexion"><i class="fas fa-user"></i></a></li>
                @else
                <li><a href="{{ route('profil.show') }}" data-tooltip="Profil"><i class="fas fa-user-circle"></i></a></li>
                <li>
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       data-tooltip="Déconnexion">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @endguest
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts -->
    <script>
        // Animation pour la barre de recherche
        document.querySelector('.search-container input').addEventListener('focus', function() {
            this.parentElement.querySelector('i').style.color = 'var(--accent-color)';
        });
        
        document.querySelector('.search-container input').addEventListener('blur', function() {
            this.parentElement.querySelector('i').style.color = 'rgba(255,255,255,0.7)';
        });
    </script>
</body>
</html>