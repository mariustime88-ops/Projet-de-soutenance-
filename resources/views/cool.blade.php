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
            <h1 class="mt-4">Inscription d'un nouvel enfant</h1>

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card-form mt-4">
                <form action="{{ route('enfants.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" name="nom" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="prenom" name="prenom" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="age" class="form-label">Âge</label>
                            <input type="number" class="form-control" id="age" name="age" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="sexe" class="form-label">Sexe</label>
                            <select class="form-control" id="sexe" name="sexe" required>
                                <option value="">Sélectionner</option>
                                <option value="Masculin">Masculin</option>
                                <option value="Féminin">Féminin</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="classe" class="form-label">Classe</label>
                            <input type="text" class="form-control" id="classe" name="classe" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="lieu_naissance" class="form-label">Lieu de naissance</label>
                            <input type="text" class="form-control" id="lieu_naissance" name="lieu_naissance" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_naissance" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="date_naissance" name="date_naissance" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse du domicile</label>
                        <input type="text" class="form-control" id="adresse" name="adresse" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="contact_urgence_nom" class="form-label">Nom du contact d'urgence</label>
                            <input type="text" class="form-control" id="contact_urgence_nom" name="contact_urgence_nom" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="contact_urgence_numero" class="form-label">Numéro du contact d'urgence</label>
                            <input type="text" class="form-control" id="contact_urgence_numero" name="contact_urgence_numero" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="allergies" class="form-label">Allergies (si applicable)</label>
                        <input type="text" class="form-control" id="allergies" name="allergies">
                    </div>
                    <div class="mb-3">
                        <label for="info_medicales" class="form-label">Informations médicales</label>
                        <textarea class="form-control" id="info_medicales" name="info_medicales" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="photo" class="form-label">Photo de l'enfant</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                        <div class="mt-2" id="photo-preview-container" style="display: none;">
                            <img id="photo-preview" src="#" alt="Prévisualisation de la photo" style="max-width: 150px; max-height: 150px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-green w-100">Enregistrer l'enfant</button>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
    document.getElementById('photo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const photoPreview = document.getElementById('photo-preview');
                const photoPreviewContainer = document.getElementById('photo-preview-container');
                photoPreview.src = e.target.result;
                photoPreviewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection