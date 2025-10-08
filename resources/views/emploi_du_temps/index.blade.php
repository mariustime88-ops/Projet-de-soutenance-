@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="text-center mb-5 animate__animated animate__fadeInDown">
                        <button><a href="{{ url('home') }}">Accueil</a></button>

        <h1 class="display-4 fw-bold text-info">Emploi du Temps 📅</h1>
        <p class="lead text-muted">Sélectionnez le niveau et la classe pour consulter le planning de cours.</p>
    </div>

    {{-- Utilisation des Onglets Bootstrap pour les Niveaux --}}
    <ul class="nav nav-tabs nav-fill mb-4 shadow bg-white rounded-top p-1" id="edtTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="primaire-tab" data-bs-toggle="tab" data-bs-target="#primaire-content" type="button" role="tab" aria-controls="primaire-content" aria-selected="true">
                <i class="fas fa-school me-2"></i> Primaire
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="secondaire-tab" data-bs-toggle="tab" data-bs-target="#secondaire-content" type="button" role="tab" aria-controls="secondaire-content" aria-selected="false">
                <i class="fas fa-university me-2"></i> Secondaire
            </button>
        </li>
    </ul>

    <div class="tab-content border border-top-0 p-4 bg-light shadow-lg" id="edtTabsContent">
        
        {{-- Contenu des Onglets --}}
        @foreach($classes as $niveau => $listeClasses)
            <div class="tab-pane fade @if($loop->first) show active @endif" id="{{ strtolower($niveau) }}-content" role="tabpanel" aria-labelledby="{{ strtolower($niveau) }}-tab">
                <div class="row align-items-center mb-4">
                    <div class="col-md-4">
                        <label for="{{ strtolower($niveau) }}_select" class="form-label fw-bold">Choisir la Classe :</label>
                    </div>
                    <div class="col-md-8">
                        {{-- Liste déroulante pour la sélection de la classe --}}
                        <select class="form-select classe-select" id="{{ strtolower($niveau) }}_select" data-placeholder="Sélectionnez une classe...">
                            <option value="">Sélectionnez une classe...</option>
                            @foreach($listeClasses as $classe)
                                <option value="{{ $classe }}">{{ $classe }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Conteneur où le tableau de l'EDT sera chargé --}}
                <div id="edt_container_{{ strtolower($niveau) }}" class="edt-container mt-4">
                    <div class="alert alert-info text-center">
                        Veuillez choisir une classe pour afficher son emploi du temps.
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>

{{-- Nécessite jQuery et Bootstrap JS pour le bon fonctionnement des onglets et d'AJAX --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Gérer le changement de classe dans les listes déroulantes
        $('.classe-select').on('change', function() {
            var selectedClass = $(this).val();
            // Déterminer le conteneur cible (primaire-content ou secondaire-content)
            var targetContainer = $(this).closest('.tab-pane').find('.edt-container');
            
            if (selectedClass) {
                // Afficher un loader pendant le chargement
                targetContainer.html('<div class="text-center p-5"><div class="spinner-border text-info" role="status"><span class="visually-hidden">Chargement...</span></div><p class="mt-2 text-info">Chargement de l\'emploi du temps...</p></div>');
                
                // Requête AJAX pour charger le tableau de l'emploi du temps
                $.ajax({
                    url: "{{ route('emploi_du_temps.show') }}", // Route vers la méthode show
                    method: 'GET',
                    data: { classe: selectedClass },
                    success: function(response) {
                        // Charger le tableau reçu dans le conteneur
                        targetContainer.html(response);
                    },
                    error: function(xhr) {
                        targetContainer.html('<div class="alert alert-danger">Erreur lors du chargement. Veuillez réessayer.</div>');
                        console.error('Erreur AJAX:', xhr);
                    }
                });
            } else {
                // Si aucune classe n'est sélectionnée, remettre le message par défaut
                targetContainer.html('<div class="alert alert-info text-center">Veuillez choisir une classe pour afficher son emploi du temps.</div>');
            }
        });
    });
</script>
@endsection