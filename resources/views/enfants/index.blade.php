<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Enfants</title>
    <!-- Inclure Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: #f8f9fa;
            padding: 15px;
            text-decoration: none;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
            text-decoration: none;
        }
        .content {
            padding: 20px;
        }
        .card-form {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Barre latérale à gauche -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <a href="{{ url('home') }}">Accueil</a>
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Menu Enfant</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('enfants.index') }}">
                            <span data-feather="file-text"></span>
                            Ses enfants
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('enfants.create') }}">
                            <span data-feather="info"></span>
                            Inscription d'enfants
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Contenu principal à droite -->
        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 content">
            <div class="container mt-4">
                <h1>Liste des Enfants Inscrits</h1>

                @if(session('success'))
                    <div class="alert alert-success mt-3" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nom & Prénom</th>
                                <th>Âge</th>
                                <th>Classe</th>
                                <th>Sexe</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enfants as $enfant)
                                <tr>
<td>
    <a href="{{ route('enfants.show', $enfant->id) }}">
        {{ $enfant->nom }} {{ $enfant->prenom }}
    </a>
</td>                                    <td>{{ $enfant->age }} ans</td>
                                    <td>{{ $enfant->classe }}</td>
                                    <td>{{ $enfant->sexe }}</td>
                                    <td>
                                        <a href="{{ route('enfants.edit', $enfant->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                        <form action="{{ route('enfants.destroy', $enfant->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
<form action="{{ route('enfants.destroy', $enfant->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enfant ?');">Supprimer</button>
</form>                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Inclure Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>