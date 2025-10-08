@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4 text-primary"><i class="fas fa-users me-2"></i> Concernant les Candidats</h1>
    <p class="text-center lead text-muted">Veuillez prendre connaissance des conditions d'éligibilité et des documents requis pour l'inscription.</p>

    <div class="row justify-content-center mt-5">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-info card-hover-effect animate__fadeInUp">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Documents et Procédures</h4>
                </div>
                <div class="card-body">
                    <h5 class="text-info mb-3"><i class="fas fa-file-alt me-2"></i> Liste des Documents Requis</h5>
                    <ul class="list-group list-group-flush mb-4">
                        @foreach($documentsRequis as $doc)
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle me-3 text-success"></i> {{ $doc }}
                            </li>
                        @endforeach
                    </ul>
                    
                    <h5 class="text-info mb-3"><i class="fas fa-clipboard-list me-2"></i> Critères d'Admissibilité</h5>
                    <p>
                        L'enfant doit avoir une note de conduite annuelle supérieure à 12/20.
                    </p>
                    <div class="alert alert-warning text-center mt-4">
                        <i class="fas fa-exclamation-triangle me-2"></i> **Important :** Toute omission de document entraîne le rejet de la candidature.
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('examens.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Retour aux Infos Examens
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles d'animation basiques (à conserver) */
.card-hover-effect { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.card-hover-effect:hover { transform: translateY(-5px); box-shadow: 0 0.8rem 2rem rgba(0, 0, 0, 0.15) !important; }
.animate__fadeInUp { animation: fadeInUp 1s ease-out; }
@keyframes fadeInUp {
  from { opacity: 0; transform: translate3d(0, 20px, 0); }
  to { opacity: 1; transform: translate3d(0, 0, 0); }
}
</style>
@endsection