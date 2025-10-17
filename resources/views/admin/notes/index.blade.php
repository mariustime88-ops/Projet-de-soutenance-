@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestion des Notes des Élèves</h2>
        <a href="{{ route('admin.notes.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Ajouter une Note
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Formulaire de Filtre --}}
    <div class="card shadow mb-4">
        <div class="card-header">
            Filtres de Recherche
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.notes.index') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label for="enfant_id" class="form-label">Filtrer par Élève</label>
                    <select name="enfant_id" id="enfant_id" class="form-control">
                        <option value="">-- Tous les Élèves --</option>
                        @foreach ($enfants as $enfant)
                            <option value="{{ $enfant->id }}" {{ request('enfant_id') == $enfant->id ? 'selected' : '' }}>
                                {{ $enfant->nom }} {{ $enfant->prenom }} ({{ $enfant->matricule }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label for="matiere_id" class="form-label">Filtrer par Matière</label>
                    <select name="matiere_id" id="matiere_id" class="form-control">
                        <option value="">-- Toutes les Matières --</option>
                        @foreach ($matieres as $matiere)
                            <option value="{{ $matiere->id }}" {{ request('matiere_id') == $matiere->id ? 'selected' : '' }}>
                                {{ $matiere->nom }} (Coeff: {{ $matiere->coefficient }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter"></i> Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead class="bg-info text-white">
                        <tr>
                            <th>Élève</th>
                            <th>Matière</th>
                            <th>Note</th>
                            <th>Coefficient</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($notes as $note)
                            <tr>
                                <td class="align-middle" style="width: 20%;">
                                    <span class="badge bg-primary text-white">{{ $note->enfant->matricule ?? 'N/A' }}</span>
                                    {{ $note->enfant->nom ?? 'Élève Supprimé' }} {{ $note->enfant->prenom ?? '' }}
                                </td>
                                <td class="align-middle">
                                    <strong>{{ $note->matiere->nom ?? 'Matière Supprimée' }}</strong>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="h5 {{ $note->note >= 10 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($note->note, 2) }} / 20
                                    </span>
                                </td>
                                <td class="align-middle text-center">{{ $note->matiere->coefficient ?? 'N/A' }}</td>
                                <td class="align-middle">{{ $note->type_evaluation }}</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($note->date_evaluation)->format('d/m/Y') }}</td>
                                <td class="align-middle" style="width: 150px;">
                                    <a href="{{ route('admin.notes.edit', $note) }}" class="btn btn-sm btn-warning mb-1 w-100">
                                        <i class="fas fa-edit"></i> Modifier
                                    </a>
                                    <form action="{{ route('admin.notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette note ?');">
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
                                <td colspan="7" class="text-center">Aucune note enregistrée ne correspond aux critères.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $notes->links() }}
    </div>
</div>
@endsection