@extends('layouts.app') 

@section('content')
<div class="container py-5">
    
    <div class="text-center mb-5">
         <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Retour à l'Accueil
                </a>
        <h1 class="display-4 text-primary animate__fadeInDown">
            <i class="fas fa-graduation-cap me-3"></i> Informations et Frais des Examens
        </h1>
        <p class="lead text-muted animate__fadeInUp">
            Gérez et consultez les détails importants pour les examens officiels (CM2, 3ème et Tle).
        </p>
    </div>
    
    <div class="row g-5">
        
        {{-- BLOC 1 : CONCERNANT LES CANDIDATS / ÉLIGIBILITÉ --}}
        <div class="col-lg-6 animate__fadeInLeft">
            <div class="card h-100 shadow-lg border-primary card-hover-effect">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="fas fa-user-check fa-2x me-3"></i>
                    <h3 class="mb-0">Candidats et Procédures d'Inscription</h3>
                </div>
                <div class="card-body d-flex flex-column">
                    <p class="card-text text-muted">
                        Vérifiez les conditions d'éligibilité et les documents nécessaires pour la participation aux examens officiels.
                    </p>
                    
                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Date limite d'inscription :
                            <span class="badge bg-danger rounded-pill pulse-animation">30 Novembre 2025</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Examen(s) concerné(s) :
                            <span class="badge bg-secondary">CEPE, BEPC & BAC</span>
                        </li>
                    </ul>

                    <div class="mt-auto text-center">
                        <a href="{{ route('examens.candidats') }}" class="btn btn-outline-primary btn-lg w-75">
                            <i class="fas fa-search me-2"></i> Consulter l'éligibilité
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- BLOC 2 : FRAIS ET PAIEMENTS (MAJ avec CM2) --}}
        <div class="col-lg-6 animate__fadeInRight">
            <div class="card h-100 shadow-lg border-success card-hover-effect">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="fas fa-money-check-alt fa-2x me-3"></i>
                    <h3 class="mb-0">Gestion des Frais d'Examens</h3>
                </div>
                {{-- ... Bloc Gestion des Frais d'Examens ... --}}

<div class="card-body d-flex flex-column">
    <p class="card-text text-muted">
        Détails des montants et statut de paiement pour les examens (CM2, 3ème, Tle).
    </p>
    
    <table class="table table-sm table-borderless table-responsive mb-4">
        <thead class="bg-light">
            <tr>
                <th>Examen</th>
                <th>Montant</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fraisExamens as $frais)
            <tr>
                <td>**{{ $frais['examen'] }}**</td>
                <td class="fw-bold text-info">{{ number_format($frais['montant'], 0, ',', ' ') }} F CFA</td>
                <td>
                    {{-- 🚨 LOGIQUE MISE À JOUR POUR LA COULEUR DU STATUT --}}
                    @php
                        $badgeClass = 'secondary';
                        if ($frais['statut'] == 'Payé') {
                            $badgeClass = 'success';
                        } elseif ($frais['statut'] == 'Doit être payé') {
                            $badgeClass = 'danger'; // Rouge pour l'action requise
                        } else {
                            $badgeClass = 'warning text-dark'; // Jaune pour "En Attente" ou autre
                        }
                    @endphp
                    <span class="badge bg-{{ $badgeClass }} {{ $frais['statut'] == 'Doit être payé' ? 'pulse-animation' : '' }}">
                        {{ $frais['statut'] }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="mt-auto text-center">
         <a href="{{ route('examens.frais') }}" class="btn btn-success btn-lg w-75">
            <i class="fas fa-hand-holding-usd me-2"></i> Gérer/Payer les Frais
        </a>
    </div>
</div>

{{-- ... Reste de la vue ... --}}
    {{-- Section Documents de Référence (MAJ pour afficher par classe) --}}
    <div class="row mt-5 animate__fadeInUp">
        <div class="col-12">
             <h3 class="text-secondary mb-3 border-bottom pb-2">
                <i class="fas fa-folder-open me-2"></i> Documents à Constituer par Examen
            </h3>
            
            <div class="accordion" id="accordionDocuments">
                @foreach($documentsParExamen as $examen => $documents)
                <div class="accordion-item shadow-sm mb-2">
                    <h2 class="accordion-header" id="heading{{ Str::slug($examen) }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ Str::slug($examen) }}" aria-expanded="false" aria-controls="collapse{{ Str::slug($examen) }}">
                            <i class="fas fa-file-pdf me-3 text-{{ $loop->first ? 'primary' : ($loop->last ? 'danger' : 'success') }}"></i> Dossier {{ $examen }}
                        </button>
                    </h2>
                    <div id="collapse{{ Str::slug($examen) }}" class="accordion-collapse collapse" aria-labelledby="heading{{ Str::slug($examen) }}" data-bs-parent="#accordionDocuments">
                        <div class="accordion-body">
                            <ul class="list-group list-group-flush">
                                @foreach($documents as $doc)
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-dot-circle me-3 text-muted"></i> {{ $doc }}
                                    </li>
                                @endforeach
                            </ul>
                            <div class="mt-3 text-end">
                                <a href="#" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-download me-1"></i> Télécharger la Fiche d'Infos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
/* Styles et Animations (maintenus) */
.card-hover-effect { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.card-hover-effect:hover { transform: translateY(-8px); box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.2) !important; }
.pulse-animation { animation: pulse 2s infinite; }
@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4); }
    70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
    100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
}
/* Styles d'animation simulés */
.animate__fadeInDown { animation: fadeInDown 1s ease-out; }
.animate__fadeInUp { animation: fadeInUp 1s ease-out; }
.animate__fadeInLeft { animation: fadeInLeft 1s ease-out; }
.animate__fadeInRight { animation: fadeInRight 1s ease-out; }

@keyframes fadeInDown { from { opacity: 0; transform: translate3d(0, -20px, 0); } to { opacity: 1; transform: translate3d(0, 0, 0); } }
@keyframes fadeInUp { from { opacity: 0; transform: translate3d(0, 20px, 0); } to { opacity: 1; transform: translate3d(0, 0, 0); } }
@keyframes fadeInLeft { from { opacity: 0; transform: translate3d(-20px, 0, 0); } to { opacity: 1; transform: translate3d(0, 0, 0); } }
@keyframes fadeInRight { from { opacity: 0; transform: translate3d(20px, 0, 0); } to { opacity: 1; transform: translate3d(0, 0, 0); } }
</style>

@endsection