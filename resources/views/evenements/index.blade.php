@extends('layouts.app') 

@section('content')
<div class="container py-5 animate__fadeInUp">
    
    <header class="text-center mb-5 header-fancy">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-chevron-left mr-2"></i> Retour à la sélection
                </a>
        <h1 class="display-4 text-primary fw-bold mb-1">
            <i class="fas fa-trophy me-2"></i> Événements Interclasses & Culturels
        </h1>
        <p class="lead text-muted">Vibrez au rythme des compétitions sportives et célébrez la richesse culturelle de notre établissement !</p>
    </header>

    {{-- SECTION JOURNÉE CULTURELLE --}}
    <h2 class="text-center text-warning fw-bold mb-4 animate__slideInDown">
        <i class="fas fa-palette me-2"></i> Programme des Journées Culturelles
    </h2>

    <div class="row mb-5 justify-content-center g-4">
        @forelse($evenementsCulturels as $evenement)
            <div class="col-lg-6">
                <div class="card shadow-lg border-warning border-3 card-culturel-effect h-100">
                    <div class="card-header bg-warning text-dark fw-bold text-center fs-5">
                        <i class="fas fa-sun me-2"></i> {{ $evenement->titre }}
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fs-5 text-dark"><i class="far fa-calendar-alt me-2"></i> **Date** : {{ $evenement->date_evenement->translatedFormat('l j F Y') }}</span>
                            <span class="badge bg-{{ $evenement->etat == 'Planifié' ? 'info' : ($evenement->etat == 'En Cours' ? 'success' : 'secondary') }} p-2">{{ $evenement->etat }}</span>
                        </div>
                        <p class="text-secondary">{{ $evenement->description_theme }}</p>
                        <h4 class="mt-4 text-primary">Programme des Activités :</h4>
                        <ul class="list-group list-group-flush">
                            @foreach(explode("\n", $evenement->programme_details) as $activite)
                                @if(trim($activite))
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-check-circle text-danger me-3"></i> {{ trim($activite) }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-lg-8"><div class="alert alert-info text-center shadow-sm">Le programme de la Journée Culturelle n'est pas encore planifié par l'administration. Restez connectés !</div></div>
        @endforelse
    </div>

    <hr class="my-5 divider-fancy">

    {{-- SECTION TOURNOI INTERCLASSE (Calendrier) --}}
    <h2 class="text-center text-danger fw-bold mb-5 animate__slideInDown">
        <i class="fas fa-futbol me-2"></i> Calendrier du Tournoi Interclasse
    </h2>

    @php
        // Vérifie si au moins un cycle contient des matchs
        $hasMatches = collect($cycles)->contains(fn($matchList) => $matchList->isNotEmpty());
    @endphp

    @if(!$hasMatches)
        <div class="alert alert-warning text-center">Aucun calendrier Interclasse n'est disponible pour le moment. L'administrateur n'a pas encore mis de matchs en ligne.</div>
    @else
        @foreach($cycles as $cycleKey => $matchList)
            {{-- N'affiche le bloc que s'il y a des matchs dans ce cycle --}}
            @if($matchList->isNotEmpty())
                @php
                    // Détermine le nom d'affichage et la couleur en fonction de la clé DB.
                    if ($cycleKey === '6 Première Cycle') {
                        $displayName = 'Secondaire (6ème à 3ème)';
                        $color = 'success';
                    } elseif ($cycleKey === '4 Secondaire') {
                        $displayName = 'Secondaire (2nde à Tle)';
                        $color = 'danger';
                    } else {
                        $displayName = 'Primaire (CI à CM2)';
                        $color = 'info';
                    }
                @endphp
                <div class="accordion mb-4 shadow-lg" id="accordion{{ str_replace(' ', '', $cycleKey) }}">
                    <div class="accordion-item border-{{ $color }} border-3">
                        <h2 class="accordion-header" id="heading{{ str_replace(' ', '', $cycleKey) }}">
                            <button class="accordion-button fs-4 fw-bold bg-{{ $color }} text-white" 
                                    type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#collapse{{ str_replace(' ', '', $cycleKey) }}" 
                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}" 
                                    aria-controls="collapse{{ str_replace(' ', '', $cycleKey) }}">
                                <i class="fas fa-users me-3"></i> Cycle {{ $displayName }} ({{ count($matchList) }} Matchs Planifiés)
                            </button>
                        </h2>
                        <div id="collapse{{ str_replace(' ', '', $cycleKey) }}" 
                            class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                            aria-labelledby="heading{{ str_replace(' ', '', $cycleKey) }}" 
                            data-bs-parent="#accordion{{ str_replace(' ', '', $cycleKey) }}">
                            <div class="accordion-body p-4">
                                <div class="row g-3">
                                    @foreach($matchList as $match)
                                        @php
                                            $matchEstPasse = $match->date_heure_match->isPast();
                                            $matchBadgeClass = $matchEstPasse ? 'bg-secondary' : 'bg-success';
                                            $matchStateText = $matchEstPasse ? 'Match Passé' : 'Match à Venir';
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="card h-100 card-match-effect border-top-{{ $color }} border-5">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                        <span class="badge bg-primary fs-6">{{ $match->phase }}</span>
                                                        <span class="text-muted small">
                                                            @if($match->poule_nom)
                                                                (Poule: {{ $match->poule_nom }}) -
                                                            @endif
                                                            <i class="fas fa-map-marker-alt me-1"></i> {{ $match->lieu }}
                                                        </span>
                                                    </div>
                                                    
                                                    <h5 class="text-center my-3 fw-bolder text-dark">
                                                        {{ $match->equipe_a }} <span class="text-danger mx-2">VS</span> {{ $match->equipe_b }}
                                                    </h5>
                                                    
                                                    <div class="text-center mb-3">
                                                        @if($match->score)
                                                            {{-- Score visible pour les matchs joués --}}
                                                            <span class="badge bg-success p-2 fs-5 animate__heartBeat">{{ $match->score }}</span>
                                                            <p class="text-success small mt-1">Résultat Final</p>
                                                            @if($match->gagnant)
                                                                <p class="text-muted small mt-1">Gagnant: <strong>{{ $match->gagnant }}</strong></p>
                                                            @endif
                                                        @else
                                                            {{-- Joie/Attente pour les matchs à venir --}}
                                                            <span class="badge bg-info p-2 fs-5 text-uppercase">🔥 Prêts au Duel ! 🔥</span>
                                                            <p class="text-primary small mt-1">Attente du coup d'envoi</p>
                                                        @endif
                                                    </div>

                                                    <p class="text-center text-secondary mb-0 fw-bold">
                                                        <span class="badge {{ $matchBadgeClass }} me-2">{{ $matchStateText }}</span>
                                                        <i class="fas fa-clock me-1"></i> 
                                                        {{ $match->date_heure_match->translatedFormat('l j F à H:i') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

</div> 

<style>
/* ------------------------------------- */
/* CSS pour rendre la vue TRES JOLIE (Conservé) */
/* ------------------------------------- */

/* Animations de base */
@keyframes fadeInUp { from { opacity: 0; transform: translate3d(0, 20px, 0); } to { opacity: 1; transform: translate3d(0, 0, 0); } }
.animate__fadeInUp { animation: fadeInUp 1s ease-out; }

/* Effet du header */
.header-fancy {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

/* Effet de la carte culturelle (Jaune) */
.card-culturel-effect {
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    border-radius: 15px;
}
.card-culturel-effect:hover {
    transform: scale(1.02);
    box-shadow: 0 15px 30px rgba(255, 193, 7, 0.4) !important;
}

/* Effet des cartes de match */
.card-match-effect {
    border-radius: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.card-match-effect:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

/* Séparateur stylisé */
.divider-fancy {
    border: 0;
    height: 3px;
    background-image: linear-gradient(to right, rgba(255, 0, 0, 0), rgba(253, 126, 20, 0.75), rgba(255, 0, 0, 0));
}

/* Animation du score (quand il est visible) */
@keyframes heartBeat { 
    0% { transform: scale(1); } 
    14% { transform: scale(1.1); } 
    28% { transform: scale(1); } 
    42% { transform: scale(1.1); } 
    70% { transform: scale(1); } 
}
.animate__heartBeat { animation: heartBeat 1.5s infinite; }

/* Styles pour les accordions de cycle */
.accordion-button.bg-info, .accordion-button.bg-success, .accordion-button.bg-danger {
    border-radius: 10px 10px 0 0 !important;
}
</style>
@endsection