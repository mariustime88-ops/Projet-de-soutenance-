@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Modification de l'Élève : {{ $enfant->prenom }} {{ $enfant->nom }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.enfants.update', $enfant) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Section 1: Informations de Base de l'Élève -->
                            <div class="col-md-6 border-end">
                                <h5>Informations de l'Élève</h5>
                                <hr>

                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Parent Lié <span class="text-danger">*</span></label>
                                    <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}" {{ old('user_id', $enfant->user_id) == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->name }} ({{ $parent->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="matricule" class="form-label">Matricule</label>
                                    <input type="text" class="form-control @error('matricule') is-invalid @enderror" id="matricule" name="matricule" value="{{ old('matricule', $enfant->matricule) }}">
                                    @error('matricule')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="nom" class="form-label">Nom <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $enfant->nom) }}" required>
                                        @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="prenom" class="form-label">Prénom <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ old('prenom', $enfant->prenom) }}" required>
                                        @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <label for="date_naissance" class="form-label">Date de Naissance <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $enfant->date_naissance) }}" required>
                                        @error('date_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label for="lieu_naissance" class="form-label">Lieu de Naissance <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('lieu_naissance') is-invalid @enderror" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance', $enfant->lieu_naissance) }}" required>
                                        @error('lieu_naissance')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4 mb-3">
                                        <label for="age" class="form-label">Âge <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('age') is-invalid @enderror" id="age" name="age" value="{{ old('age', $enfant->age) }}" min="1" max="18" required>
                                        @error('age')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="sexe" class="form-label">Sexe <span class="text-danger">*</span></label>
                                        <select class="form-select @error('sexe') is-invalid @enderror" id="sexe" name="sexe" required>
                                            <option value="M" {{ old('sexe', $enfant->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                                            <option value="F" {{ old('sexe', $enfant->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                                            <option value="Autre" {{ old('sexe', $enfant->sexe) == 'Autre' ? 'selected' : '' }}>Autre</option>
                                        </select>
                                        @error('sexe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label for="classe" class="form-label">Classe <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('classe') is-invalid @enderror" id="classe" name="classe" value="{{ old('classe', $enfant->classe) }}" required>
                                        @error('classe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="adresse" class="form-label">Adresse de l'Élève</label>
                                    <input type="text" class="form-control @error('adresse') is-invalid @enderror" id="adresse" name="adresse" value="{{ old('adresse', $enfant->adresse) }}">
                                    @error('adresse')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="photo" class="form-label">Nouvelle Photo d'identité (Max 2Mo)</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo">
                                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    @if ($enfant->photo_url)
                                        <small class="form-text text-muted">Photo actuelle : <a href="{{ Storage::url($enfant->photo_url) }}" target="_blank">Voir l'image</a></small>
                                    @endif
                                </div>
                            </div>

                            <!-- Section 2: Informations Médicales & Urgence -->
                            <div class="col-md-6">
                                <h5>Informations Médicales & Urgence</h5>
                                <hr>

                                <div class="mb-3">
                                    <label for="allergies" class="form-label">Allergies (Si aucune, laisser vide)</label>
                                    <textarea class="form-control @error('allergies') is-invalid @enderror" id="allergies" name="allergies" rows="2">{{ old('allergies', $enfant->allergies) }}</textarea>
                                    @error('allergies')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="info_medicales" class="form-label">Informations Médicales Spécifiques (Traitements, conditions)</label>
                                    <textarea class="form-control @error('info_medicales') is-invalid @enderror" id="info_medicales" name="info_medicales" rows="3">{{ old('info_medicales', $enfant->info_medicales) }}</textarea>
                                    @error('info_medicales')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                
                                <h5 class="mt-4">Contact d'Urgence</h5>
                                <hr>

                                <div class="mb-3">
                                    <label for="contact_urgence_nom" class="form-label">Nom du Contact d'Urgence</label>
                                    <input type="text" class="form-control @error('contact_urgence_nom') is-invalid @enderror" id="contact_urgence_nom" name="contact_urgence_nom" value="{{ old('contact_urgence_nom', $enfant->contact_urgence_nom) }}">
                                    @error('contact_urgence_nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contact_urgence_numero" class="form-label">Numéro de Téléphone d'Urgence</label>
                                    <input type="text" class="form-control @error('contact_urgence_numero') is-invalid @enderror" id="contact_urgence_numero" name="contact_urgence_numero" value="{{ old('contact_urgence_numero', $enfant->contact_urgence_numero) }}">
                                    @error('contact_urgence_numero')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('admin.enfants.index') }}" class="btn btn-secondary">
                                Annuler et Retour à la Liste
                            </a>
                            <button type="submit" class="btn btn-warning btn-lg">
                                Mettre à jour l'Élève
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
