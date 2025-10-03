@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
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



        
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 content d-flex justify-content-center align-items-center flex-column">
            <h1 class="mt-4 text-center text-info font-weight-bolder">Sélectionner l'enfant</h1>
            <p class="lead text-center text-muted mb-5">Choisissez un enfant pour consulter son bulletin de notes.</p>

            <div class="row w-75 justify-content-center">
                @forelse ($enfants as $enfant)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-lg border-primary rounded-xl" style="transition: transform 0.3s ease;">
                            <div class="card-body text-center p-4">
                                <i class="fas fa-user-graduate fa-4x text-primary mb-3"></i>
                                <h5 class="card-title font-weight-bold">{{ $enfant->prenom }} {{ $enfant->nom }}</h5>
                                <p class="card-text text-secondary">Classe : {{ $enfant->classe }}</p>
                                <a href="{{ route('notes.show', $enfant->id) }}" class="btn btn-primary mt-3 btn-block">
                                    <i class="fas fa-eye mr-2"></i> Voir le bulletin
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center mt-5">
                        <div class="alert alert-warning py-4" role="alert" style="border-left: 5px solid #ffc107; max-width: 600px; margin: auto;">
                            <i class="fas fa-exclamation-triangle fa-2x d-block mb-2"></i> 
                            <h4 class="alert-heading">Aucun enfant inscrit.</h4>
                            <p>Veuillez inscrire vos enfants pour voir leurs notes.</p>
                            <a href="{{ route('enfants.create') }}" class="btn btn-warning mt-2">Inscrire un enfant</a>
                        </div>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</div>
@endsection