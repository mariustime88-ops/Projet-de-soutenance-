@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestion des Reçus (Uploads)</h2>
        {{-- Lien vers le formulaire de téléversement --}}
        <a href="{{ route('admin.recuus.create') }}" class="btn btn-success">
            <i class="fas fa-upload"></i> Mettre un Reçu en Ligne
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
                            <th>Titre du Reçu</th>
                            <th>Élève Concerné</th>
                            <th>Période</th>
                            <th>Date Upload</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recus as $recu)
                            <tr>
                                <td class="align-middle"><strong>{{ $recu->titre }}</strong></td>
                                <td class="align-middle">
                                    {{ $recu->enfant->nom ?? 'N/A' }} {{ $recu->enfant->prenom ?? '' }} 
                                    ({{ $recu->enfant->matricule ?? 'Matricule Indisponible' }})
                                </td>
                                <td class="align-middle">{{ $recu->periode ?? 'Non spécifiée' }}</td>
                                <td class="align-middle">{{ $recu->created_at ? $recu->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                <td class="align-middle" style="width: 200px;">
                                    {{-- Lien de téléchargement --}}
                                    <a href="{{ route('admin.recuus.download', $recu) }}" class="btn btn-sm btn-info mb-1" target="_blank">
                                        <i class="fas fa-download"></i> Télécharger
                                    </a>
                                    {{-- Formulaire de suppression --}}
                                    <form action="{{ route('admin.recuus.destroy', $recu) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer ce reçu et le fichier associé ?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Aucun reçu n'a été mis en ligne.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $recus->links() }}
    </div>
</div>
@endsection