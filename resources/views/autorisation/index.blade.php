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
                        <a class="nav-link" href="{{ route('autorisation.index') }}">Autorisation</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 content">
            <h1 class="mt-4 text-center text-primary">Règles et Autorisations de l'École</h1>
            <p class="lead text-center text-muted">Informations importantes pour les élèves et les parents.</p>
            <div class="row mt-4">
                @foreach($authorizations as $auth)
                    @php
                        $cardClass = '';
                        $iconClasses = '';
                        if ($auth['titre'] == 'Livres et Fournitures') {
                            $cardClass = 'border-primary';
                            $iconClasses = 'fas fa-book';
                        } elseif ($auth['titre'] == 'Habillement') {
                            $cardClass = 'border-success';
                            $iconClasses = 'fas fa-tshirt';
                        } elseif ($auth['titre'] == 'Comportement et Discipline') {
                            $cardClass = 'border-danger';
                            $iconClasses = 'fas fa-smile';
                        }
                    @endphp
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm {{ $cardClass }}">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="{{ $iconClasses }} fa-3x text-primary"></i>
                                </div>
                                <h5 class="card-title text-primary">{{ $auth['titre'] }}</h5>
                                <p class="card-text text-muted">{{ $auth['contenu'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</div>
@endsection