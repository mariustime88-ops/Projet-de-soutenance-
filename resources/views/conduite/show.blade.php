@extends('layouts.app') 

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h1 class="display-4 fw-bold text-primary">
                Fiche de Conduite de {{ $enfant->prenom }} {{ $enfant->nom }} 
            </h1>
            <p class="lead">Synthèse du comportement et des sanctions pour l'année {{ $enfant->annee_scolaire }}</p>
            <a href="{{ route('conduite.index') }}" class="btn btn-outline-secondary btn-sm mt-3">
                Retour à la sélection
            </a>
        </div>
    </div>

    @php
        $statut = $enfant->statut_conduite;
        $note = $enfant->note_finale_conduite;
        $colle = $enfant->heures_colle;
        // Nouvelle propriété pour obtenir la déduction réelle (1 point par 2h)
        $deduction = $enfant->deduction_points; 
    @endphp

    <div class="row g-4 mb-5 justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg border-0 bg-{{ $statut['couleur'] }} text-white animate__animated animate__fadeInDown">
                <div class="card-body text-center py-4">
                    <h5 class="card-title fw-light opacity-75">Note de Conduite Annuelle (Max: 18)</h5>
                    <div class="display-1 fw-bold mb-3">
                        @if ($note !== null)
                            {{ number_format($note, 2) }} / 18
                        @else
                            N/A
                        @endif
                    </div>
                    <p class="card-text fs-4 text-uppercase">Statut : {{ $statut['texte'] }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-lg border-0 bg-info text-white animate__animated animate__fadeInDown delay-1s">
                <div class="card-body text-center py-4">
                    <h5 class="card-title fw-light opacity-75">Sanctions : Heures de Colle</h5>
                    <div class="display-1 fw-bold mb-3">
                        {{ $colle ?? 0 }}h
                    </div>
                    <p class="card-text fs-4 text-uppercase">
                        @if ($colle > 0)
                            Déduction : -{{ number_format($deduction, 1) }} point(s)
                        @else
                            Aucune heure de colle
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp">
                <div class="card-header bg-light text-dark fw-bold">
                    Règlement Scolaire Relatif à la Conduite
                </div>
                <div class="card-body">
                    <h6 class="text-primary mb-3">Règles de Notation :</h6>
                    <ul>
                        <li>La note de conduite est initialement fixée à **18/18** en début d'année.</li>
                        <li class="fw-bold text-danger">Chaque tranche de **2 heures de colle** entraîne une déduction de **1 point** de la note de conduite.</li>
                        <li>La note est visible en temps réel par les parents.</li>
                    </ul>

                    <h6 class="text-danger mt-4 mb-3">Conséquences en cas de Conduite Insuffisante :</h6>
                    <div class="p-3 bg-light-{{ $statut['couleur'] }} border border-{{ $statut['couleur'] }} rounded">
                        <p class="mb-1 fw-bold">Seuil d'Exclusion :</p>
                        <p class="mb-0">Toute note de conduite **strictement inférieure à 10/18** entraînera une procédure d'exclusion définitive du Collège, conformément au règlement intérieur.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection