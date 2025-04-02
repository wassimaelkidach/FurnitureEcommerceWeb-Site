<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dwira Style - Buy Your Dream Furniture</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Harrington&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #B3AC9D;
            --secondary-color: #7A7568;
            --text-color: white;
            --hover-color: #D9D5CC;
            --background-light: #F5F3EE;
        }
        
        /* Reset complet */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text-color);
            background-color: #FFFFFF;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        header {
            background-color: var(--primary-color);
            padding: 0 40px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            height: 70px;
        }
        
        /* Logo */
        .logo {
            font-family: 'Harrington', fantasy;
            font-size: 28px;
            font-weight: 700;
            color: var(--text-color);
            letter-spacing: 1.5px;
            margin: 0;
        }
        
        /* Navigation */
        nav ul {
            display: flex;
            list-style: none;
            gap: 30px;
            align-items: center;
            height: 100%;
        }
        
        nav ul li a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            position: relative;
            height: 100%;
            padding: 8px 0;
        }
        
        nav ul li a:hover {
            color: var(--hover-color);
        }
        
        nav ul li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background-color: var(--text-color);
            transition: width 0.3s ease;
        }
        
        nav ul li a:hover::after {
            width: 100%;
        }
        
        /* Icônes */
        .fas {
            margin-right: 8px;
            font-size: 15px;
        }
        
        /* Badge panier */
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -12px;
            background-color: var(--secondary-color);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Contenu principal */
        main {
            flex: 1;
            width: 100%;
        }
        
        /* Footer */
        footer {
            background-color: var(--primary-color);
            text-align: center;
            padding: 20px 0;
            width: 100%;
        }
        
        footer p {
            font-size: 14px;
        }
        
        /* Formulaire logout caché */
        #logout-form {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav>
            <h1 class="logo">dwira style</h1>
            <ul>
                <li><a href="{{ route('home') }}">Accueil</a></li>
                @guest
                    <li><a href="{{ route('login') }}">Se connecter</a></li>
                @else
                    <li><a href="{{ route('profil.show') }}">Mon profil</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Se déconnecter</a></li>
                @endguest
                <li>
                    <a href="{{ route('cart.index') }}" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i> Panier
                        <span class="cart-badge">0</span>
                    </a>
                </li>
                <li><a href="#"><i class="fas fa-heart"></i> Favoris</a></li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Dwira Style. Tous les droits sont réservés.</p>
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>