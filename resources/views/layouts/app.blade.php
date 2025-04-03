<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Site E-commerce')</title>
    <!-- Inclure ici ton fichier CSS global -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<style>
    /* Style général du menu de navigation */
nav {
    background-color: #333;
    padding: 10px;
    text-align: center;
}

/* Liste non ordonnée contenant les éléments du menu */
nav ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    display: inline-flex;
}

/* Style des éléments de menu */
nav ul li {
    margin: 0 15px;
}

/* Style des liens du menu */
nav ul li a {
    color: white;
    text-decoration: none;
    font-size: 16px;
    padding: 8px 16px;
    display: inline-block;
    transition: background-color 0.3s ease;
}

/* Changement de couleur de fond au survol des liens */
nav ul li a:hover {
    background-color: #575757;
    border-radius: 4px;
}

/* Style des icônes dans les liens */
nav ul li a i {
    margin-right: 8px;
    font-size: 18px;
}

</style>
<body>

   <!-- Header -->
<header>
    <nav>
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
            <li><a href="{{ route('products.index') }}"> produits</a></li> <!-- Lien vers la page des produits -->
            <li><a href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart"></i> Panier</a></li>
            <li><a href="{{ route('favorites.index') }}"><i class="fas fa-heart"></i> Favoris</a></li>
        </ul>
    </nav>
</header>


    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer (optionnel) -->
    <footer>
        <p>&copy; 2025 Mon Site E-commerce. Tous droits réservés.</p>
    </footer>

    <!-- Scripts (si tu en as besoin) -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>