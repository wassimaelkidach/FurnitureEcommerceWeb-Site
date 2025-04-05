<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dwira Style - Achetez vos meubles de rêve</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Harrington&family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6E9996;
            --secondary-color: #518581;
            --text-color: white;
            --hover-color: #A8C2C0;
            --background-light: #DCE7E6;
        }
        
        /* Réinitialisation complète */
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
        
        
        /* Contenu principal */
        main {
            flex: 1;
            width: 100%;
        }
        
        /* Pied de page */
        footer {
            background-color: var(--primary-color);
            text-align: center;
            padding: 20px 0;
            width: 100%;
        }
        
        footer p {
            font-size: 14px;
        }
        
        /* Formulaire de déconnexion caché */
        #logout-form {
            display: none;
        }
    </style>
</head>
<body>
    <!-- En-tête -->
    <header>
        <nav>
            <h1 class="logo">dwira style</h1>
            <ul>
                <li><a href="{{ route('home') }}">Accueil</a></li>
                @guest
                    <li><a href="{{ route('login') }}">Connexion</a></li>
                @else
                    <li><a href="{{ route('profil.show') }}">Mon Profil</a></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a></li>
                @endguest
                <li>
                    <a href="{{ route('cart.index') }}" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i> Panier
                    </a>
                </li>
                <li><a href="{{route('favorites.index')}}"><i class="fas fa-heart"></i> Favoris</a></li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
        </nav>
    </header>

    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>