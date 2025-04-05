<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>

    <!-- Bootstrap pour le design -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- FontAwesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- CSS Admin intégré -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }

        .sidebar .nav-link {
            font-size: 16px;
            color: white;
            padding: 10px;
            display: block;
        }

        .sidebar .nav-link.active, 
        .sidebar .nav-link:hover {
            background-color: #007bff;
            color: white;
        }

        .navbar {
            background-color: #212529 !important;
        }

        .navbar a {
            color: white !important;
        }

        .container-fluid {
            margin-top: 20px;
        }
    </style>

</head>
<body>

    <!-- Barre de navigation -->
    <nav class="navbar navbar-dark p-3">
        <a class="navbar-brand ms-3" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-user-shield"></i> Admin Dashboard
        </a>
        <a class="btn btn-danger me-3" href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Admin -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar">
    <div class="position-sticky">
        <ul class="nav flex-column">
            <!-- Tableau de bord -->
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-home"></i> Tableau de bord
                </a>
            </li>
            
            <!-- Gérer les catégories -->
            <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.categories.index') }}">
        <i class="fas fa-list"></i> Gérer les catégories
    </a>
</li>

            <!-- Gérer les produits -->
            <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.products.index') }}">
    <i class="fas fa-box"></i> Gérer les produits
</a>

            </li>

            <!-- Gérer les utilisateurs -->
            <li class="nav-item">
                <a class="nav-link" >
                    <i class="fas fa-users"></i> Gérer les utilisateurs
                </a>
            </li>

            <!-- Gérer les paiements -->
            <li class="nav-item">
                <a class="nav-link" >
                    <i class="fas fa-credit-card"></i> Gérer les paiements
                </a>
            </li>

            <!-- Gérer les commandes -->
            <li class="nav-item">
                <a class="nav-link" >
                    <i class="fas fa-shopping-cart"></i> Gérer les commandes
                </a>
            </li>
        </ul>
    </div>
</nav>

            <!-- Contenu principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Formulaire de déconnexion -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</body>
</html>