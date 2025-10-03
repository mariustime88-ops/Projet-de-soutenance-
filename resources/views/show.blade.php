@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <a href="{{ route('home') }}">Accueil</a>
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
        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 content">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Profil de {{ $enfant->prenom }} {{ $enfant->nom }}</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="{{ route('enfants.edit', $enfant->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('enfants.destroy', $enfant->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enfant ?');">Supprimer</button>
                    </form>
                </div>
            </div>

            <div class="row profile-card mt-4">
                <div class="col-md-4 text-center">
                    {{-- CORRECTION 1 : On vérifie si le chemin de la photo existe dans la DB --}}
                    @if($enfant->photo_url)
                        {{-- CORRECTION 2 : Utilisation de asset('storage/'...) pour afficher l'image --}}
                        {{-- Laravel convertit 'storage/photos/nom_fichier.jpg' en une URL publique. --}}
                        <img src="{{ asset('storage/' . $enfant->photo_url) }}" 
                             alt="Photo de {{ $enfant->prenom }}" 
                             class="img-fluid rounded" 
                             style="max-width: 200px; max-height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light p-5 rounded">
                            <i class="fa fa-user-circle fa-5x text-muted"></i> 
                            <p class="mt-2">Pas de photo disponible</p>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <div class="info-card mb-3">
                        <h5 class="card-title">Informations Personnelles</h5>
                        <p class="card-text"><strong>Nom :</strong> {{ $enfant->nom }}</p>
                        <p class="card-text"><strong>Prénom :</strong> {{ $enfant->prenom }}</p>
                        <p class="card-text"><strong>Âge :</strong> {{ $enfant->age }} ans</p>
                        <p class="card-text"><strong>Sexe :</strong> {{ $enfant->sexe }}</p>
                        <p class="card-text"><strong>Classe :</strong> {{ $enfant->classe }}</p>
                    </div>

                    <div class="info-card mb-3">
                        <h5 class="card-title">Coordonnées & Naissance</h5>
                        <p class="card-text"><strong>Lieu de naissance :</strong> {{ $enfant->lieu_naissance }}</p>
                        <p class="card-text"><strong>Date de naissance :</strong> {{ $enfant->date_naissance }}</p>
                        <p class="card-text"><strong>Adresse :</strong> {{ $enfant->adresse }}</p>
                    </div>

                    <div class="info-card mb-3">
                        <h5 class="card-title">Informations d'Urgence & Médicales</h5>
                        <p class="card-text"><strong>Nom du contact d'urgence :</strong> {{ $enfant->contact_urgence_nom }}</p>
                        <p class="card-text"><strong>Numéro du contact d'urgence :</strong> {{ $enfant->contact_urgence_numero }}</p>
                        <p class="card-text"><strong>Allergies :</strong> {{ $enfant->allergies ?? 'Aucune' }}</p>
                        <p class="card-text"><strong>Informations médicales :</strong> {{ $enfant->info_medicales ?? 'Aucune' }}</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection
