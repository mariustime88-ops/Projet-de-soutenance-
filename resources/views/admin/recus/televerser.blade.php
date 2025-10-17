@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Téléverser un Nouveau Reçu (Upload)</h4>
                </div>
                <div class="card-body">
                    {{-- L'action pointe vers la route 'admin.recuus.store' qui gère l'upload --}}
                    {{-- IMPORTANT : 'enctype="multipart/form-data"' est OBLIGATOIRE pour l'upload de fichiers --}}
                    <form method="POST" action="{{ route('admin.recuus.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- Élève --}}
                        <div class="mb-3">
                            <label for="enfant_id" class="form-label">Élève Concerné <span class="text-danger">*</span></label>
                            <select class="form-control @error('enfant_id') is-invalid @enderror" id="enfant_id" name="enfant_id" required>
                                <option value="">Sélectionnez l'élève</option>
                                @foreach ($enfants as $enfant)
                                    <option value="{{ $enfant->id }}" {{ old('enfant_id') == $enfant->id ? 'selected' : '' }}>
                                        {{ $enfant->nom }} {{ $enfant->prenom }} ({{ $enfant->matricule }})
                                    </option>
                                @endforeach
                            </select>
                            @error('enfant_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        {{-- Titre et Période --}}
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="titre" class="form-label">Titre du Reçu (Ex: Reçu Scolarité Trimestre 1) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}" required>
                                @error('titre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="periode" class="form-label">Période (Ex: 2024-2025)</label>
                                <input type="text" class="form-control @error('periode') is-invalid @enderror" id="periode" name="periode" value="{{ old('periode', date('Y')) }}">
                                @error('periode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Fichier (Champ d'Upload) --}}
                        <div class="mb-3">
                            <label for="fichier" class="form-label">Sélectionner le Fichier (PDF, JPG, PNG) <span class="text-danger">*</span></label>
                            {{-- L'attribut 'name="fichier"' correspond au nom attendu par le contrôleur --}}
                            <input type="file" class="form-control @error('fichier') is-invalid @enderror" id="fichier" name="fichier" required accept=".pdf, .jpg, .jpeg, .png">
                            @error('fichier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="form-text text-muted">Taille maximale : 5 Mo.</small>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.recuus.index') }}" class="btn btn-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-success">
                                Mettre en Ligne le Reçu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection