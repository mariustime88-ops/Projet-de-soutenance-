@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Ajouter une Nouvelle Note</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.notes.store') }}">
                        @csrf
                        
                        <div class="row">
                            {{-- Élève --}}
                            <div class="col-md-6 mb-3">
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

                            {{-- Matière --}}
                            <div class="col-md-6 mb-3">
                                <label for="matiere_id" class="form-label">Matière <span class="text-danger">*</span></label>
                                <select class="form-control @error('matiere_id') is-invalid @enderror" id="matiere_id" name="matiere_id" required>
                                    <option value="">Sélectionnez la matière</option>
                                    @foreach ($matieres as $matiere)
                                        <option value="{{ $matiere->id }}" {{ old('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                            {{ $matiere->nom }} (Coeff: {{ $matiere->coefficient }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('matiere_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Note --}}
                            <div class="col-md-4 mb-3">
                                <label for="note" class="form-label">Note / 20 <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" max="20" class="form-control @error('note') is-invalid @enderror" id="note" name="note" value="{{ old('note') }}" required>
                                @error('note')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Type d'Évaluation --}}
                            <div class="col-md-4 mb-3">
                                <label for="type_evaluation" class="form-label">Type d'Évaluation <span class="text-danger">*</span></label>
                                <select class="form-control @error('type_evaluation') is-invalid @enderror" id="type_evaluation" name="type_evaluation" required>
                                    <option value="">Sélectionner un type</option>
                                    @foreach (['Interrogation', 'Devoir', 'Examen', 'Projet', 'Autre'] as $type)
                                        <option value="{{ $type }}" {{ old('type_evaluation') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('type_evaluation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            {{-- Date d'Évaluation --}}
                            <div class="col-md-4 mb-3">
                                <label for="date_evaluation" class="form-label">Date d'Évaluation <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date_evaluation') is-invalid @enderror" id="date_evaluation" name="date_evaluation" value="{{ old('date_evaluation', date('Y-m-d')) }}" required>
                                @error('date_evaluation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Commentaire --}}
                        <div class="mb-3">
                            <label for="commentaire" class="form-label">Commentaire (Facultatif)</label>
                            <textarea class="form-control @error('commentaire') is-invalid @enderror" id="commentaire" name="commentaire" rows="3">{{ old('commentaire') }}</textarea>
                            @error('commentaire')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.notes.index') }}" class="btn btn-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-success">
                                Enregistrer la Note
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection