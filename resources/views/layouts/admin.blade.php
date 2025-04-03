<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - @yield('title')</title>

  <!-- Bootstrap pour le design -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color:rgb(207, 210, 226);
      overflow-x: hidden;
    }
    
    /* Sidebar fixe à gauche */
    .sidebar {
      min-height: 100vh;
      background-color: #2c3e50;
      padding-top: 20px;
      position: fixed;
      width: 260px;
      left: 0;
      top: 0;
      bottom: 0;
      z-index: 1100;
      box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
      transition: all 0.3s;
    }
    
    /* En-tête de la sidebar */
    .sidebar-header {
      padding: 10px 0;
      border-bottom: 1px solid rgba(255,255,255,0.2);
    }
    
    .sidebar .nav-link {
      font-size: 15px;
      color:rgb(247, 247, 247);
      padding: 12px 15px;
      margin: 5px 10px;
      border-radius: 5px;
      display: flex;
      align-items: center;
      transition: all 0.2s;
    }
    
    .sidebar .nav-link i {
      width: 25px;
      margin-right: 10px;
      text-align: center;
    }
    
    .sidebar .nav-link:hover {
      background-color: #3498db;
      color: white;
      transform: translateX(5px);
    }
    
    .sidebar .nav-link.active {
      background-color: #2980b9;
      color: white;
      font-weight: 500;
    }
    
    /* Navbar supérieure fixe, à droite de la sidebar */
    .top-navbar {
      position: fixed;
      top: 0;
      left: 260px;
      width: calc(100% - 260px);
      height: 60px;
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      z-index: 1050;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
    }
    
    .top-navbar .navbar-brand {
      display: flex;
      align-items: center;
    }
    
    /* Contenu principal placé en dessous de la navbar */
    .main-content {
      margin-left: 260px;
      margin-top: 60px;
      padding: 20px;
      width: calc(100% - 260px);
      min-height: calc(100vh - 60px);
      transition: all 0.3s;
    }
    
    .content-section {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
    
    /* Styles pour le menu utilisateur */
    .user-dropdown {
      position: relative;
      display: flex;
      align-items: center;
    }
    
    .user-trigger {
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
      padding: 5px 10px;
      border-radius: 50px;
      transition: all 0.3s ease;
    }
    
    .user-trigger:hover {
      background: #f5f7fa;
    }
    
    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #e0e6ed;
    }
    
    .user-name {
      font-weight: 600;
      color: #2d3748;
      margin-right: 5px;
    }
    
    .dropdown-arrow {
      font-size: 0.8rem;
      color: #718096;
      transition: transform 0.3s ease;
    }
    
    .user-dropdown-menu {
      position: absolute;
      right: 0;
      top: 100%;
      width: 280px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      padding: 1rem 0;
      opacity: 0;
      visibility: hidden;
      transform: translateY(10px);
      transition: all 0.3s ease;
      z-index: 1000;
    }
    
    .user-dropdown.active .user-dropdown-menu {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    
    .user-dropdown.active .dropdown-arrow {
      transform: rotate(180deg);
    }
    
    .dropdown-header {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 0 1rem 1rem;
      border-bottom: 1px solid #f1f5f9;
    }
    
    .dropdown-avatar {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid #e0e6ed;
    }
    
    .dropdown-header h4 {
      margin: 0;
      font-size: 1rem;
      color: #2d3748;
    }
    
    .dropdown-header small {
      color: #718096;
      font-size: 0.8rem;
    }
    
    .dropdown-divider {
      height: 1px;
      background: #f1f5f9;
      margin: 0.5rem 0;
    }
    
    .dropdown-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 0.75rem 1.5rem;
      color: #4a5568;
      text-decoration: none;
      transition: all 0.2s ease;
    }
    
    .dropdown-item i {
      width: 20px;
      text-align: center;
      color: #718096;
    }
    
    .dropdown-item:hover {
      background: #f8fafc;
      color: #4361ee;
    }
    
    .dropdown-item:hover i {
      color: #4361ee;
    }
    
    /* Responsive pour petits écrans */
    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
      }
      
      .top-navbar {
        left: 70px;
        width: calc(100% - 70px);
      }
      
      .main-content {
        margin-left: 70px;
        width: calc(100% - 70px);
      }
      
      .user-name {
        display: none;
      }
      
      .user-dropdown-menu {
        width: 250px;
        right: -10px;
      }
    }
  </style>
</head>
<body>
  <!-- Sidebar -->
  <nav class="sidebar">
    <!-- En-tête de la sidebar avec le nom du site et une icône -->
    <div class="sidebar-header text-center mb-4">
      <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center justify-content-center text-decoration-none">
        <i class="fas fa-store fa-2x text-white me-2"></i>
        <span class="text-white h4 mb-0">DWIRE STYLE</span>
      </a>
    </div>
    
    <ul class="nav flex-column">
      <li><a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> <span>Tableau de bord</span></a></li>
      <li><a class="nav-link" href="{{ route('admin.categories.index') }}"><i class="fas fa-list"></i> <span>Catégories</span></a></li>
      <li><a class="nav-link" href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> <span>Produits</span></a></li>
      <li><a class="nav-link"><i class="fas fa-users"></i> <span>Utilisateurs</span></a></li>
      <li><a class="nav-link"><i class="fas fa-credit-card"></i> <span>Paiements</span></a></li>
      <li><a class="nav-link"><i class="fas fa-shopping-cart"></i> <span>Commandes</span></a></li>
    </ul>
  </nav>
  
  <!-- Navbar supérieure fixe -->
  <nav class="top-navbar">
    <span class="ms-3 fw-bold"></span>
    
    <!-- Menu utilisateur -->
    <div class="user-dropdown" id="userDropdown">
      <div class="user-trigger" id="userDropdownTrigger">
        <img src="{{ Auth::user()->photo_url ?? asset('images/default-avatar.png') }}" 
             alt="Admin Photo" class="user-avatar">
        <span class="user-name">{{ Auth::user()->name }}</span>
        <i class="fas fa-chevron-down dropdown-arrow"></i>
      </div>
      
      <div class="user-dropdown-menu" id="userDropdownMenu">
        <div class="dropdown-header">
          <img src="{{ Auth::user()->photo_url ?? asset('images/default-avatar.png') }}" 
               alt="Admin Photo" class="dropdown-avatar">
          <div>
            <h4>{{ Auth::user()->name }}</h4>
            <small>{{ Auth::user()->email }}</small>
          </div>
        </div>
        
        <div class="dropdown-divider"></div>
        
        <a href="{{ route('profil.show') }}" class="dropdown-item">
          <i class="fas fa-user-cog"></i> Mon profil
        </a>
        <a href="#" class="dropdown-item">
          <i class="fas fa-cog"></i> Paramètres
        </a>
        
        <div class="dropdown-divider"></div>
        
        <a href="{{ route('logout') }}" class="dropdown-item"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i> Déconnexion
        </a>
      </div>
    </div>
  </nav>
  
  <!-- Contenu principal -->
  <div class="main-content">
    <div class="content-section">
      @yield('content')
    </div>
  </div>
  
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
  </form>
  
  <!-- Scripts Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const dropdownTrigger = document.getElementById('userDropdownTrigger');
      const dropdown = document.getElementById('userDropdown');
      
      // Ouvrir/fermer le menu
      dropdownTrigger.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('active');
      });
      
      // Fermer le menu quand on clique ailleurs
      document.addEventListener('click', function() {
        dropdown.classList.remove('active');
      });
      
      // Empêcher la fermeture quand on clique dans le menu
      document.getElementById('userDropdownMenu').addEventListener('click', function(e) {
        e.stopPropagation();
      });
    });
  </script>
</body>
</html>