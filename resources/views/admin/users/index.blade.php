@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestion des Utilisateurs (Parents & Admins)</h2>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover table-bordered">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Enfants Liés</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="align-middle">{{ $user->id }}</td>
                            <td class="align-middle">{{ $user->name }}</td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">
                                @if ($user->is_admin)
                                    <span class="badge bg-danger">Administrateur</span>
                                @else
                                    <span class="badge bg-success">Parent/Utilisateur</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                {{ $user->enfants->count() }}
                            </td>
                            <td class="align-middle" style="width: 150px;">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning mb-1 w-100">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('ATTENTION : Voulez-vous vraiment supprimer ce compte ? Ceci supprimera aussi les enfants liés.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100" @if(Auth::id() == $user->id) disabled title="Vous ne pouvez pas supprimer votre propre compte." @endif>
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-3">
        {{ $users->links() }}
    </div>
</div>
@endsection