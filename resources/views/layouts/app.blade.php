<!DOCTYPE html>
<html lang="fr">
<style>
* {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
body {
    
    font-family: 'Montserrat', sans-serif;
    color: var(--text-color);
    background-color: #f5f7fa;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
} 
    /* Styles */

    /* Navigation */
    nav {
        display: flex;
        justify-content: space-between;
        height: 70px;
        margin: 0 auto;
        background: #274472;
        padding: 1rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    /* Logo */
    .logo {
        font-family: 'Harrington', fantasy;
        font-size: 28px;
        font-weight: 700;
        color: var(--text-color);
        letter-spacing: 1.5px;
        margin: 0;
        color: white;
    }
    
nav ul {
    display: flex;
    list-style-type: none;
    align-items: center;
    height: 100%;
    gap: 30px;
}
/* Style des éléments de menu */


/* Style des liens du menu */
    nav ul li a {
        text-decoration: none;
        color: #FFFFFF;
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
        color: aliceblue;
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

/* Style des icônes dans les liens */
    nav ul li a i {
        margin-right: 8px;
        font-size: 18px;
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
        
        /* Formulaire de déconnexion caché */
        #logout-form {
            display: none;
        }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Site E-commerce')</title>
    <!-- Inclure ici ton fichier CSS global -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <!-- Header -->
    <header>
        <nav>
                <h1 class="logo">dwira style</h1>
                <ul>
                @guest
                <li><a href="{{ route('login') }}">Se connecter</a></li>
                @else
                <li><a href="{{ route('profil.show') }}">Mon profil</a></li>
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Se déconnecter</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form>
                @endguest
                <li><a href="{{ route('home') }}">Accueil</a></li>
                <li><a href="{{ route('products.index') }}"><i class=""></i> Produits</a></li>

                <li><a href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart"></i> Panier</a></li>
                <li><a href="{{ route('favorites.index') }}"><i class="fas fa-heart"></i> Favoris</a></li>

            </ul>

        </nav>
    </header>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Scripts (si tu en as besoin) -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>