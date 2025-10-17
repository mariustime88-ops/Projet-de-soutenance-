@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Ajouter une Nouvelle Matière</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.matieres.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de la Matière <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom') }}" required>
                            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="coefficient" class="form-label">Coefficient <span class="text-danger">*</span></label>
                            <input type="number" step="0.5" class="form-control @error('coefficient') is-invalid @enderror" id="coefficient" name="coefficient" value="{{ old('coefficient', 1) }}" required min="0.5" max="10">
                            @error('coefficient')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="form-text text-muted">Ex: 1, 1.5, 2, 3, etc. Max 10.</small>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.matieres.index') }}" class="btn btn-secondary">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-success">
                                Enregistrer la Matière
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection