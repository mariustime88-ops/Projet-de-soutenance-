<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - {{ config('app.name', 'Laravel') }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* Styles CSS pour les effets demandés */
        :root {
            --sidebar-width: 250px;
            --main-blue: #0d6efd; /* Primary */
            --light-bg: #f8f9fa; /* Light */
        }

        body {
            background-color: var(--light-bg);
            padding-top: 56px; /* Espace pour la barre de navigation fixe */
        }
        
        /* Conteneur principal avec espace pour la barre latérale */
        #wrapper {
            display: flex;
        }

        /* Barre latérale */
        #sidebar-wrapper {
            width: var(--sidebar-width);
            min-height: 100vh;
            margin-left: -var(--sidebar-width);
            transition: margin 0.3s ease-in-out;
            background-color: #2c3e50; /* Couleur sombre agréable */
            position: fixed;
            top: 56px; /* Sous la navbar */
            left: 0;
            z-index: 1000;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        #page-content-wrapper {
            flex-grow: 1;
            padding: 20px;
            margin-left: 0; /* Par défaut, occupe toute la largeur */
            transition: margin 0.3s ease-in-out;
            width: 100%;
        }

        /* Quand la barre latérale est ouverte (via JS) */
        body.sb-sidenav-toggled #wrapper #sidebar-wrapper {
            margin-left: 0;
        }
        body.sb-sidenav-toggled #wrapper #page-content-wrapper {
            margin-left: var(--sidebar-width);
        }
        
        /* Style des liens de navigation */
        .list-group-item-action {
            color: #ecf0f1;
            padding: 15px 20px;
            border-radius: 0;
            transition: background-color 0.2s, transform 0.2s;
            border: none;
        }
        .list-group-item-action:hover {
            background-color: #34495e; /* Légèrement plus clair au survol */
            transform: translateX(5px);
            color: white;
        }
        .sidebar-heading {
            padding: 10px 20px;
            font-size: 1.1em;
            color: #bdc3c7;
            border-bottom: 1px solid #34495e;
            font-weight: bold;
        }
        
        /* Styles d'animation des cartes (Dashboard) */
        .stat-card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            cursor: pointer;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <button class="btn btn-primary" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand ms-3" href="{{ route('admin.dashboard') }}">Administration</a>
            
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name ?? 'Admin' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('home') }}"><i class="fas fa-home me-2"></i> Vue Parent/Accueil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="wrapper">
        
        <div id="sidebar-wrapper">
            <div class="list-group list-group-flush pt-3">
                
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action bg-transparent">
                    <i class="fas fa-tachometer-alt me-2"></i> Tableau de Bord
                </a>
                
                <div class="sidebar-heading">Gestion Scolaire</div>
                <a href="{{ route('admin.enfants.index') }}" class="list-group-item list-group-item-action bg-transparent">
                    <i class="fas fa-user-graduate me-2"></i> Élèves (Enfants)
                </a>
                <a href="{{ route('admin.recuus.index') }}" class="list-group-item list-group-item-action bg-transparent">
                    <i class="fas fa-receipt me-2"></i> Reçus & Paiements
                </a>
                
                <div class="sidebar-heading">Administration</div>
                <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action bg-transparent">
                    <i class="fas fa-users me-2"></i> Utilisateurs (Parents)
                </a>
                
                <div class="sidebar-heading">Paramètres</div>
                <a href="#" class="list-group-item list-group-item-action bg-transparent">
                    <i class="fas fa-cogs me-2"></i> Configuration
                </a>
            </div>
        </div>
        <div id="page-content-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sidebarToggle = document.getElementById('sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function (event) {
                    event.preventDefault();
                    document.body.classList.toggle('sb-sidenav-toggled');
                });
            }
        });
    </script>
</body>
</html>