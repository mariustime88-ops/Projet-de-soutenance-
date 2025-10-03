@extends('layouts.app')

{{-- Inclure FontAwesome pour les icônes et ajouter quelques styles personnalisés pour l'esthétique --}}
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Effet de survol sur les cartes */
        .card:hover {
            transform: translateY(-5px) !important;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        /* Style du bouton d'action principal (télécharger tout) */
        .main-action-button {
            transition: all 0.3s ease;
            background-color: #28a745; /* Vert Success */
            border-color: #28a745;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-weight: bold;
        }
        .main-action-button:hover {
            transform: scale(1.05);
            background-color: #218838;
            border-color: #1e7e34;
            box-shadow: 0 8px 12px rgba(40, 167, 69, 0.4);
        }
    </style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Barre latérale (conservée de votre code original, mais commentée si votre layout principal la gère) --}}
        {{-- Si vous utilisez un layout Bootstrap standard, la sidebar pourrait être redondante ici, mais je la garde pour la structure. --}}
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('recus.index') }}">Prendre son reçu</a>
                    </li>
                </ul>
            </div>
        </nav>

        {{-- Contenu principal --}}
        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 content d-flex justify-content-center align-items-center flex-column">
            
            <h1 class="mt-4 text-center text-primary font-weight-bolder">Mes Reçus de Scolarité</h1>
            <p class="lead text-center text-secondary mb-5">
                <i class="fas fa-lock text-success mr-2"></i> Téléchargez vos documents officiels en toute sécurité.
            </p>

            {{-- Affichage des messages flash (Succès/Erreur) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show w-75 mx-auto" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show w-75 mx-auto" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- BOUTON PRINCIPAL POUR TOUT TÉLÉCHARGER (Visible seulement s'il y a des reçus) --}}
            @if ($recus->isNotEmpty())
                <div class="mb-5 w-100 text-center">
                    <a href="{{ route('recus.download.all') }}" class="btn btn-success btn-lg main-action-button text-white">
                        <i class="fas fa-file-archive mr-2"></i> Télécharger TOUS les Reçus (ZIP)
                    </a>
                </div>
            @endif


            <div class="row mt-4 w-100 justify-content-center">
                @forelse ($recus as $recu)
                    {{-- Utilisation de col-md-4 pour un affichage sur 3 colonnes sur desktop --}}
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 shadow border-success rounded-lg" style="transition: transform 0.3s ease-in-out;">
                            <div class="card-body d-flex flex-column align-items-center p-4">
                                <div class="mb-3 text-center">
                                    {{-- Icône PDF en rouge --}}
                                    <i class="fas fa-file-pdf fa-5x text-danger"></i>
                                </div>
                                <h5 class="card-title text-center text-dark font-weight-bold mb-1">
                                    {{-- Affichage de la tranche --}}
                                    Reçu : {{ $recu->tranche }}
                                </h5>
                                <p class="card-text text-muted text-center mb-3 small">
                                    Fichier: {{ $recu->nom_fichier }}
                                </p>
                                <p class="card-text text-secondary text-center mb-4 small">
                                    Date de dépôt: {{ $recu->created_at?->format('d/m/Y') ?? 'N/A' }}
                                </p>
                                <a href="{{ route('recus.download', ['recu' => $recu->id]) }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-download mr-1"></i> Télécharger la {{ $recu->tranche }}
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Message si aucun reçu n'est disponible --}}
                    <div class="col-12 text-center mt-5">
                        <div class="alert alert-info py-4" role="alert" style="border-left: 5px solid #007bff; max-width: 600px; margin: auto;">
                            <i class="fas fa-info-circle fa-2x d-block mb-2"></i> 
                            <h4 class="alert-heading">Aucun reçu disponible pour le moment.</h4>
                            <p>Dès qu'un reçu de scolarité sera téléversé pour votre compte, il apparaîtra ici.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </main>
    </div>
</div>
@endsection
