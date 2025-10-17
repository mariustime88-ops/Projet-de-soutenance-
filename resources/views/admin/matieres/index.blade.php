@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
     <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.enfants.index') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Retour
        </a>
        <h2>Gestion des Matières</h2>
        <a href="{{ route('admin.matieres.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Ajouter une Matière
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th>ID</th>
                            <th>Nom de la Matière</th>
                            <th>Coefficient</th>
                            <th>Date de Création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($matieres as $matiere)
                            <tr>
                                <td class="align-middle" style="width: 50px;">{{ $matiere->id }}</td>
                                <td class="align-middle"><strong>{{ $matiere->nom }}</strong></td>
                                <td class="align-middle">{{ $matiere->coefficient }}</td>
                                <td class="align-middle">{{ $matiere->created_at->format('d/m/Y') }}</td>
                                <td class="align-middle" style="width: 150px;">
                                    <a href="{{ route('admin.matieres.edit', $matiere) }}" class="btn btn-sm btn-warning mb-1 w-100">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <form action="{{ route('admin.matieres.destroy', $matiere) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer la matière {{ $matiere->nom }} ? Toutes les notes liées seront aussi supprimées.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Aucune matière n'a été trouvée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $matieres->links() }}
    </div>
</div>
@endsection