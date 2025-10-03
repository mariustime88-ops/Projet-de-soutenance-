@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <a href="{{ route('home') }}">Accueil</a>
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Menu Enfant</span>
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('enfants.index') }}">
                            <span data-feather="file-text"></span>
                            Ses enfants
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('enfants.create') }}">
                            <span data-feather="info"></span>
                            Inscription d'enfants
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 content">
            <h1 class="mt-4">Modifier les informations de l'enfant</h1>

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card-form mt-4">
                <form action="{{ route('enfants.update', $enfant->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="{{ $enfant->nom }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" value="{{ $enfant->prenom }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="age" class="form-label">Âge</label>
                            <input type="number" class="form-control" id="age" name="age" value="{{ $enfant->age }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="sexe" class="form-label">Sexe</label>
                            <select class="form-control" id="sexe" name="sexe" required>
                                <option value="">Sélectionner</option>
                                <option value="Masculin" {{ ($enfant->sexe == 'Masculin') ? 'selected' : '' }}>Masculin</option>
                                <option value="Féminin" {{ ($enfant->sexe == 'Féminin') ? 'selected' : '' }}>Féminin</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="classe" class="form-label">Classe</label>
                            <input type="text" class="form-control" id="classe" name="classe" value="{{ $enfant->classe }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lieu_naissance" class="form-label">Lieu de naissance</label>
                            <input type="text" class="form-control" id="lieu_naissance" name="lieu_naissance" value="{{ $enfant->lieu_naissance }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_naissance" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="{{ $enfant->date_naissance }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse du domicile</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" value="{{ $enfant->adresse }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contact_urgence_nom" class="form-label">Nom du contact d'urgence</label>
                            <input type="text" class="form-control" id="contact_urgence_nom" name="contact_urgence_nom" value="{{ $enfant->contact_urgence_nom }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contact_urgence_numero" class="form-label">Numéro du contact d'urgence</label>
                            <input type="text" class="form-control" id="contact_urgence_numero" name="contact_urgence_numero" value="{{ $enfant->contact_urgence_numero }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="allergies" class="form-label">Allergies (si applicable)</label>
                        <input type="text" class="form-control" id="allergies" name="allergies" value="{{ $enfant->allergies }}">
                    </div>
                    <div class="mb-3">
                        <label for="info_medicales" class="form-label">Informations médicales</label>
                        <textarea class="form-control" id="info_medicales" name="info_medicales" rows="3">{{ $enfant->info_medicales }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo de l'enfant (laissez vide pour garder l'actuelle)</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>
                    <button type="submit" class="btn btn-green w-100">Mettre à jour l'enfant</button>
                </form>
            </div>
        </main>
    </div>
</div>
@endsection