<!DOCTYPE html>
<html lang="fr">
<style>
    /* Styles améliorés */
      
    .shadow-hover {
        transition: all 0.3s ease;
        box-shadow: 0 2px 15px rgba(0,0,0,0.1);
    }
    .shadow-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    .img-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .ratio-4x3 {
        aspect-ratio: 4 / 3;
    }
    /* Navigation */
    nav {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 0 auto;
        height: 70px;
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
    margin: 0;
    padding: 0;
    gap: 30px;
    align-items: center;
    height: 100%;
}
/* Style des éléments de menu */
nav ul li {
    margin: 0 15px;
}

/* Style des liens du menu */
    nav ul li a {
        text-decoration: none;
        color: #FFFFFF;
        transition: all 0.3s ease;
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
    }
    nav ul li a:hover {
        color: aliceblue;
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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