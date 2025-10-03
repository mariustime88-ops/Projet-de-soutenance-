@extends('layouts.app') 

@section('content')
<div class="container mt-5">
     
    <div class="text-center mb-5 animate__animated animate__fadeInDown">
         <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-chevron-left mr-2"></i> Retour à la sélection
                </a>
        <h1 class="display-4 fw-bold text-primary">Calendrier des Compositions 🗓️</h1>
        <p class="lead text-muted">Sélectionnez l'étape scolaire de votre enfant pour consulter les dates des examens.</p>
    </div>

    {{-- Utilisation des Onglets Bootstrap pour la navigation --}}
    <ul class="nav nav-pills nav-fill mb-4 shadow-sm bg-white rounded-pill p-1 animate__animated animate__fadeInUp" id="compositionTabs" role="tablist">
        <li class="nav-item" role="presentation">
            {{-- Le lien actif par défaut --}}
            <a class="nav-link active rounded-pill" id="maternelle-tab" data-bs-toggle="tab" href="#maternelle" role="tab" aria-controls="maternelle" aria-selected="true">
                <i class="fas fa-baby me-2"></i> Maternelle
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link rounded-pill" id="primaire-tab" data-bs-toggle="tab" href="#primaire" role="tab" aria-controls="primaire" aria-selected="false">
                <i class="fas fa-school me-2"></i> Primaire
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link rounded-pill" id="secondaire-tab" data-bs-toggle="tab" href="#secondaire" role="tab" aria-controls="secondaire" aria-selected="false">
                <i class="fas fa-graduation-cap me-2"></i> Secondaire
            </a>
        </li>
    </ul>

    <div class="tab-content" id="compositionTabsContent">
        
        {{-- TAB 1 : MATERNELLE --}}
        <div class="tab-pane fade show active animate__animated animate__fadeIn" id="maternelle" role="tabpanel" aria-labelledby="maternelle-tab">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Calendrier - Étape Maternelle</h4>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" style="width: 30%;">Date de Composition</th>
                                <th scope="col">Matière</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($maternelle as $item)
                                <tr class="table-row-hover">
                                    <td><i class="far fa-calendar-alt text-primary me-2"></i> {{ \Carbon\Carbon::parse($item['date'])->isoFormat('DD MMMM YYYY') }}</td>
                                    <td>{{ $item['matiere'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Aucune date de composition n'est encore planifiée pour la Maternelle.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TAB 2 : PRIMAIRE --}}
        <div class="tab-pane fade animate__animated animate__fadeIn" id="primaire" role="tabpanel" aria-labelledby="primaire-tab">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Calendrier - Étape Primaire</h4>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" style="width: 30%;">Date de Composition</th>
                                <th scope="col">Matière</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($primaire as $item)
                                <tr class="table-row-hover">
                                    <td><i class="far fa-calendar-alt text-warning me-2"></i> {{ \Carbon\Carbon::parse($item['date'])->isoFormat('DD MMMM YYYY') }}</td>
                                    <td>{{ $item['matiere'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Aucune date de composition n'est encore planifiée pour le Primaire.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- TAB 3 : SECONDAIRE --}}
        <div class="tab-pane fade animate__animated animate__fadeIn" id="secondaire" role="tabpanel" aria-labelledby="secondaire-tab">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Calendrier - Étape Secondaire</h4>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col" style="width: 30%;">Date de Composition</th>
                                <th scope="col">Matière</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($secondaire as $item)
                                <tr class="table-row-hover">
                                    <td><i class="far fa-calendar-alt text-danger me-2"></i> {{ \Carbon\Carbon::parse($item['date'])->isoFormat('DD MMMM YYYY') }}</td>
                                    <td>{{ $item['matiere'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center text-muted">Aucune date de composition n'est encore planifiée pour le Secondaire.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- Style et Script pour l'esthétique et les animations --}}
<style>
    /* Assurez-vous d'avoir Bootstrap 5 et Font Awesome (fa-...) importés dans votre layouts.app */
    .nav-pills .nav-link {
        color: #007bff; /* Couleur des liens non sélectionnés */
        font-weight: 600;
        transition: background-color 0.3s, color 0.3s;
    }
    .nav-pills .nav-link.active, .nav-pills .nav-link:hover {
        background-color: #007bff; /* Couleur principale */
        color: white;
        transform: translateY(-2px);
    }
    .card-header h4 {
        font-weight: 700;
    }
    .table-row-hover {
        transition: transform 0.2s, background-color 0.2s;
    }
    .table-row-hover:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
        cursor: pointer;
    }
    .animate__animated {
        /* CSS pour l'animation (nécessite l'importation de la librairie Animate.css) */
        --animate-duration: 0.8s;
    }
</style>

{{-- Note Importante pour les Animations : --}}
{{-- Pour que les classes 'animate__animated' fonctionnent, vous devez inclure la librairie Animate.css dans votre <head> ou avant </body> : --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/> --}}

@endsection