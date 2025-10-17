@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
                                <button><a href="{{ url('home') }}">Accueil</a></button>

        <h1 class="display-5 text-danger animate__fadeInDown">
            <i class="fas fa-calendar-alt me-2"></i> Programme Hebdomadaire des Travaux Dirigés (TD)
        </h1>
        <p class="lead text-muted animate__fadeInUp">
            Séances intensives de révision se tenant **chaque samedi matin**.
        </p>
    </div>

    {{-- ACCORDION PRINCIPAL POUR SÉPARER LES CYCLES --}}
    <div class="accordion" id="tdProgramAccordion">
        
        {{-- BLOC 1 : CYCLE PRIMAIRE (CI à CM2) --}}
        <div class="accordion-item shadow-lg mb-4 animate__fadeInLeft">
            <h2 class="accordion-header" id="headingPrimaire">
                <button class="accordion-button bg-info text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePrimaire" aria-expanded="true" aria-controls="collapsePrimaire">
                    <i class="fas fa-school me-3"></i> 
                    CYCLE PRIMAIRE (CI au CM2) - **Samedi : 08h00 à 12h00**
                </button>
            </h2>
            <div id="collapsePrimaire" class="accordion-collapse collapse show" aria-labelledby="headingPrimaire" data-bs-parent="#tdProgramAccordion">
                <div class="accordion-body p-4">
                    <div class="row g-4">
                        @forelse($tdsPrimaire as $td)
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 border-info border-3 card-hover-effect-primary">
                                    <div class="card-header bg-info text-white fw-bold d-flex justify-content-between align-items-center">
                                        {{ $td->matiere }} <span class="badge bg-light text-dark">{{ $td->classe_niveau }}</span>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-info">{{ $td->titre }}</h5>
                                        <p class="card-text text-muted">{{ $td->description }}</p>
                                        <div class="mt-auto pt-3 border-top">
                                            <p class="mb-1 fw-bold"><i class="fas fa-calendar-alt me-2"></i> {{ $td->jour }}</p>
                                            <p class="mb-0 fw-bold text-success"><i class="fas fa-clock me-2"></i> {{ $td->heure }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12"><div class="alert alert-info">Aucun TD programmé pour les classes Primaires ce samedi.</div></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        {{-- BLOC 2 : CYCLE SECONDAIRE (Troisième et Terminale) --}}
        <div class="accordion-item shadow-lg animate__fadeInRight">
            <h2 class="accordion-header" id="headingSecondaire">
                <button class="accordion-button collapsed bg-danger text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecondaire" aria-expanded="false" aria-controls="collapseSecondaire">
                    <i class="fas fa-graduation-cap me-3"></i> 
                    CYCLE SECONDAIRE (3ème & Tle) - **Samedi : 08h00 à 13h00**
                </button>
            </h2>
            <div id="collapseSecondaire" class="accordion-collapse collapse" aria-labelledby="headingSecondaire" data-bs-parent="#tdProgramAccordion">
                <div class="accordion-body p-4">
                    <div class="row g-4">
                        @forelse($tdsSecondaire as $td)
                            @php
                                $color = $td->classe_niveau === 'Tle' ? 'danger' : 'success'; 
                                $icon = $td->classe_niveau === 'Tle' ? 'fa-rocket' : 'fa-certificate';
                            @endphp
                            <div class="col-md-6">
                                <div class="card h-100 border-{{ $color }} border-3 card-hover-effect-secondary">
                                    <div class="card-header bg-{{ $color }} text-white fw-bold d-flex justify-content-between align-items-center">
                                        <i class="fas {{ $icon }} me-2"></i> {{ $td->matiere }} 
                                        <span class="badge bg-light text-dark">{{ $td->classe_niveau }} (Filière(s) : {{ $td->filiere }})</span>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-{{ $color }}">{{ $td->titre }}</h5>
                                        <p class="card-text text-muted">{{ $td->description }}</p>
                                        <div class="mt-auto pt-3 border-top">
                                            <p class="mb-1 fw-bold"><i class="fas fa-calendar-alt me-2"></i> {{ $td->jour }}</p>
                                            <p class="mb-0 fw-bold text-primary"><i class="fas fa-clock me-2"></i> {{ $td->heure }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12"><div class="alert alert-info">Aucun TD programmé pour les classes Secondaires ce samedi.</div></div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div> {{-- Fin Accordion Principal --}}

    <div class="text-center mt-5">
        <p class="text-secondary small">
            <i class="fas fa-info-circle me-1"></i> Les TD sont obligatoires. Le programme est mis à jour chaque semaine par l'administration.
        </p>
    </div>
</div>

<style>
/* ------------------------------------- */
/* CSS pour les Animations (Effets Jolis) */
/* (Inclus pour la complétude de la vue) */
/* ------------------------------------- */

/* Animation de base pour l'entrée */
.animate__fadeInDown { animation: fadeInDown 1s ease-out; }
.animate__fadeInUp { animation: fadeInUp 1s ease-out; }
.animate__fadeInLeft { animation: fadeInLeft 1s ease-out; }
.animate__fadeInRight { animation: fadeInRight 1s ease-out; }

@keyframes fadeInDown { from { opacity: 0; transform: translate3d(0, -20px, 0); } to { opacity: 1; transform: translate3d(0, 0, 0); } }
@keyframes fadeInUp { from { opacity: 0; transform: translate3d(0, 20px, 0); } to { opacity: 1; transform: translate3d(0, 0, 0); } }
@keyframes fadeInLeft { from { opacity: 0; transform: translate3d(-20px, 0, 0); } to { opacity: 1; transform: translate3d(0, 0, 0); } }
@keyframes fadeInRight { from { opacity: 0; transform: translate3d(20px, 0, 0); } to { opacity: 1; transform: translate3d(0, 0, 0); } }

/* Effet de survol des cartes */
.card-hover-effect-primary, .card-hover-effect-secondary { 
    transition: transform 0.3s ease, box-shadow 0.3s ease; 
    border-radius: 12px;
}
.card-hover-effect-primary:hover { 
    transform: translateY(-5px); 
    box-shadow: 0 0.5rem 1rem rgba(0, 123, 255, 0.4) !important; /* Ombre bleue */
}
.card-hover-effect-secondary:hover { 
    transform: translateY(-5px); 
    box-shadow: 0 0.5rem 1rem rgba(220, 53, 69, 0.4) !important; /* Ombre rouge */
}

/* Styles pour l'accordion */
.accordion-button {
    font-weight: bold;
    font-size: 1.15rem;
    border-radius: 12px !important;
}
.accordion-item {
    border: none;
    border-radius: 12px;
}
</style>
@endsection