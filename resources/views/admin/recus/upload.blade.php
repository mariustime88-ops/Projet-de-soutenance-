@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h4 class="mb-0">Upload et Attribution d'un Reçu</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('recus.upload.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Attribuer le Reçu à un Parent <span class="text-danger">*</span></label>
                            <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                <option value="">Sélectionner un Parent</option>
                                @foreach($parents as $parent)
                                    <option value="{{ $parent->id }}" {{ old('user_id') == $parent->id ? 'selected' : '' }}>
                                        {{ $parent->name }} ({{ $parent->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="fichier_recu" class="form-label">Sélectionner le Fichier du Reçu (PDF, JPG, PNG) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('fichier_recu') is-invalid @enderror" id="fichier_recu" name="fichier_recu" required>
                            @error('fichier_recu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="form-text text-muted">Taille maximale : 5 Mo.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nom_recu" class="form-label">Nom Affiché du Reçu (Ex: Reçu Frais de Scolarité Septembre 2025)</label>
                            <input type="text" class="form-control @error('nom_recu') is-invalid @enderror" id="nom_recu" name="nom_recu" value="{{ old('nom_recu') }}">
                            @error('nom_recu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-info btn-lg">
                                <i class="fas fa-upload"></i> Uploader et Attribuer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection