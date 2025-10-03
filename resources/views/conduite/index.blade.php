@extends('layouts.app') 

@section('content')

<div class="container py-5 text-center">
                <a href="{{ url('home') }}">Accueil</a>
    
    <h1 class="text-info mb-4">Sélectionner l'enfant</h1>
    <p class="lead text-secondary">
        Choisissez un enfant pour consulter sa fiche de conduite.
    </p>

    <div class="row justify-content-center g-4 mt-4">
        @foreach($enfants as $enfant)
        <div class="col-md-4">
            <div class="card shadow-lg border-danger" style="border-width: 3px !important;"> 
                <div class="card-body">
                    <h5 class="card-title fw-bold text-dark">{{ $enfant->prenom }} {{ $enfant->nom }}</h5>
                    <p class="card-text text-muted">Classe : {{ $enfant->classe }}</p>
                    
                    <a href="{{ route('conduite.show', $enfant->id) }}" class="btn btn-danger btn-lg mt-3 shadow">
                        Voir la Conduite 
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection