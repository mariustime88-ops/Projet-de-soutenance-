@extends('layouts.app') 
{{-- NOTE : Ajustez 'layouts.app' si vous utilisez un autre fichier de mise en page --}}

@section('content')

<div class="container py-4">
   <center> <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-chevron-left mr-2"></i> Retour à la sélection
                </a></center>
    <h2 class="text-center mb-4 text-primary">Mes Reçus de Scolarité</h2>
    <p class="text-center text-muted">Téléchargez vos documents officiels en toute sécurité pour chaque enfant inscrit.</p>
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    {{-- Bouton TÉLÉCHARGER TOUS (ZIP) --}}
    <div class="text-center mb-5">
        <a href="{{ route('recus.download.all') }}" class="btn btn-success btn-lg shadow-sm" style="animation: pulse 1s infinite;">
            <i class="fas fa-download me-2"></i> TÉLÉCHARGER TOUS les Reçus (ZIP)
        </a>
    </div>

    {{-- GRILLE des Reçus Individuels --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        
        @forelse($recus as $recu)
        <div class="col">
            
            {{-- Effet d'animation simple au survol (utilisation de classes Bootstrap Card) --}}
            <div class="card h-100 shadow-sm border-info transform-on-hover">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-info"><i class="fas fa-file-pdf me-2"></i> Reçu : {{ $recu->tranche }}</h5>
                    <hr>
                    
                    {{-- Affichage des informations --}}
                    <p class="mb-1"><strong>Enfant :</strong> {{ optional($recu->enfant)->prenom }} {{ optional($recu->enfant)->nom }}</p>
                    <p class="mb-1"><strong>Date de Dépôt :</strong> {{ $recu->created_at ? $recu->created_at->format('d/m/Y') : 'Date non disponible' }}</p>
                    <p class="mb-3"><strong>Fichier :</strong> {{ $recu->nom_fichier }}</p>

                    {{-- Lien de Téléchargement Individuel (Fonctionnel avec la bonne DB) --}}
                    <div class="mt-auto text-center">
                        <a href="{{ route('recus.download.single', $recu->id) }}" class="btn btn-primary w-75">
                            <i class="fas fa-arrow-alt-circle-down me-1"></i> Télécharger le Reçu
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning text-center" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> Aucun reçu de scolarité n'est encore disponible pour vos enfants.
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
/* 🚨 Si vous utilisez Bootstrap, ces classes peuvent fonctionner */
.transform-on-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.transform-on-hover:hover {
    transform: translateY(-5px); /* Animation au survol */
    box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important; /* Ombre plus prononcée */
}
@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
    100% { box-shadow: 0 0 0 0 rgba(40, 167, 69, 0); }
}
</style>
@endsection