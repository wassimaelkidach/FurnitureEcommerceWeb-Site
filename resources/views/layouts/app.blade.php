<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mon Site E-commerce')</title>
    <!-- Inclure ici ton fichier CSS global -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
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
