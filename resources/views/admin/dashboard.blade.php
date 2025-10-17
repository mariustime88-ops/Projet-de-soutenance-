@extends('admin.layouts.app') 
{{-- IMPORTANT : Assurez-vous d'utiliser le nouveau layout admin.layouts.app --}}

@section('content')
<h1 class="mt-4 mb-4 text-primary">Tableau de Bord Administrateur</h1>

<div class="alert alert-info shadow-sm" role="alert">
    Bienvenue, Administrateur {{ Auth::user()->name }} ! 
    Ceci est l'espace de gestion sécurisé. Utilisez le menu latéral ou les cartes ci-dessous pour naviguer.
</div>

<hr>

<div class="row g-4">
    
    <div class="col-lg-4 col-md-6">
        <a href="{{ route('admin.enfants.index') }}" class="text-decoration-none">
            <div class="card stat-card bg-primary text-white shadow-lg">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="fs-4 fw-bold">Gestion des Élèves</div>
                            <div class="text-white-50">Ajouter, modifier ou supprimer des fiches d'élèves.</div>
                        </div>
                        <i class="fas fa-user-graduate fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    Voir les détails
                    <i class="fas fa-arrow-circle-right"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-4 col-md-6">
        <a href="{{ route('admin.recuus.index') }}" class="text-decoration-none">
            <div class="card stat-card bg-success text-white shadow-lg">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="fs-4 fw-bold">Mise en Ligne des Reçus</div>
                            <div class="text-white-50">Téléverser et gérer les reçus de scolarité.</div>
                        </div>
                        <i class="fas fa-receipt fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    Gérer les reçus
                    <i class="fas fa-arrow-circle-right"></i>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-4 col-md-6">
        <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
            <div class="card stat-card bg-warning text-dark shadow-lg">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="fs-4 fw-bold">Utilisateurs (Parents)</div>
                            <div class="text-black-50">Gérer les accès et les comptes parents.</div>
                        </div>
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    Voir la liste
                    <i class="fas fa-arrow-circle-right"></i>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-lg-4 col-md-6">
        <a href="#" class="text-decoration-none">
            <div class="card stat-card bg-info text-white shadow-lg">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="fs-4 fw-bold">Emploi du Temps</div>
                            <div class="text-white-50">Gestion des horaires et des interclasses.</div>
                        </div>
                        <i class="fas fa-clock fa-3x"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    Accéder au module
                    <i class="fas fa-arrow-circle-right"></i>
                </div>
            </div>
        </a>
    </div>

</div>

<div class="mt-5">
    <h3 class="text-secondary">Statistiques et Logs</h3>
    <div class="row">
        <div class="col-lg-12">
             <div class="card shadow-sm p-4">
                <p class="text-muted">Espace réservé pour les graphiques de connexion, les derniers uploads ou les logs d'activité.</p>
             </div>
        </div>
    </div>
</div>

@endsection