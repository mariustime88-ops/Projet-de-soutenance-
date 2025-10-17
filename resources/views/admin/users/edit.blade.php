@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Modification de l'Utilisateur : {{ $user->name }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom Complet</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="is_admin" class="form-label">Rôle de l'Utilisateur</label>
                            <select class="form-select @error('is_admin') is-invalid @enderror" id="is_admin" name="is_admin" required>
                                <option value="0" {{ old('is_admin', $user->is_admin) == 0 ? 'selected' : '' }}>0 - Parent/Utilisateur Standard</option>
                                <option value="1" {{ old('is_admin', $user->is_admin) == 1 ? 'selected' : '' }}>1 - Administrateur</option>
                            </select>
                            @error('is_admin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if(Auth::id() == $user->id)
                                <small class="form-text text-danger">Attention : Modifier votre propre rôle peut verrouiller votre accès si vous supprimez le statut 'Administrateur'.</small>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-warning btn-lg">Mettre à jour l'Utilisateur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection