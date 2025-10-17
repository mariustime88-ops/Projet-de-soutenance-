@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm">
    <i class="fas fa-chevron-left mr-2"></i> Retour au tableau de bord
</a>
 <a href="{{ route('admin.matieres.index') }}" class="btn btn-outline-secondary btn-sm">
    <i class="fas fa-chevron-left mr-2"></i> Aller au Matière 
</a>
        <h2>Gestion de Tous les Élèves</h2>
        <a href="{{ route('admin.enfants.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Ajouter un Élève
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.enfants.index') }}" class="row g-3">
                <div class="col-md-10">
                    <input type="search" 
                           name="search" 
                           class="form-control form-control-lg" 
                           placeholder="Rechercher par Matricule, Nom ou Prénom..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-search"></i> Rechercher
                    </button>
                </div>
            </form>
            @if(request('search'))
                <div class="mt-2">
                    <a href="{{ route('admin.enfants.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times"></i> Annuler la recherche
                    </a>
                    <span class="text-muted ms-3">Résultats pour: <strong>"{{ request('search') }}"</strong></span>
                </div>
            @endif
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>Photo</th>
                            <th>Nom & Prénom</th>
                            <th>Matricule / Classe</th>
                            <th>Parent Lié</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enfants as $enfant)
                            <tr>
                                <td class="align-middle">
                                    {{-- ... Photo de profil ... --}}
                                </td>
                                <td class="align-middle">
                                    <strong>{{ $enfant->nom }} {{ $enfant->prenom }}</strong><br>
                                    <small>Né(e) le: {{ \Carbon\Carbon::parse($enfant->date_naissance)->format('d/m/Y') }} ({{ \Carbon\Carbon::parse($enfant->date_naissance)->age }} ans)</small>
                                </td>
                                <td class="align-middle">
                                    Matricule: <strong>{{ $enfant->matricule }}</strong><br>
                                    Classe: {{ $enfant->classe }}
                                </td>
                                <td class="align-middle">
                                    {{ $enfant->user->name ?? 'N/A' }} <br>
                                    <small>{{ $enfant->user->email ?? 'Compte supprimé' }}</small>
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('admin.enfants.edit', $enfant) }}" class="btn btn-sm btn-warning mb-1">Modifier</a>
                                    <form action="{{ route('admin.enfants.destroy', $enfant) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet enfant ?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    Aucun enfant trouvé. 
                                    @if(request('search'))
                                        Veuillez vérifier les critères de recherche ({{ request('search') }}).
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $enfants->appends(['search' => request('search')])->links() }}
    </div>

</div>
@endsection