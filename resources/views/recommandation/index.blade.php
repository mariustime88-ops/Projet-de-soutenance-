@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('enfants.index') }}">Ses enfants</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('recommandation.index') }}">Recommandation</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 content">
            <h1 class="mt-4 text-center" style="color: #6a11cb;">Nos Recommandations Pédagogiques</h1>
            <p class="lead text-center text-muted">Découvrez des ressources pour enrichir l'apprentissage et le développement de vos enfants.</p>
            <div class="row mt-5">
                @foreach($recommandations as $reco)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 {{ $reco['effet'] }} border-0 rounded-lg overflow-hidden" style="transition: transform 0.3s ease-in-out;">
                            <div class="card-body">
                                <h5 class="card-title text-center text-primary font-weight-bold">{{ $reco['titre'] }}</h5>
                                <p class="card-text text-muted">{{ $reco['description'] }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="badge badge-pill badge-info">{{ $reco['categorie'] }}</span>
                                    <small class="text-muted">{{ $reco['auteur'] }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</div>
@endsection