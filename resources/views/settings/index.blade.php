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
                        <a class="nav-link" href="{{ route('settings.index') }}">Paramètres</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 content">
            <h1 class="mt-4 text-center text-secondary">Paramètres de l'Application</h1>
            <p class="lead text-center text-muted">Personnalisez votre expérience utilisateur.</p>

            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Préférences générales</h5>
                </div>
                <div class="card-body">
                    <form action="#" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="language">Langue de l'application</label>
                            <select class="form-control" id="language" name="language">
                                <option value="fr">Français</option>
                                <option value="en">Anglais</option>
                                 <option value="all">Allemand</option>
                                 <option value="ch">Chinois</option>
                                 <option value="es">Espagnol</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="theme">Thème de l'interface</label>
                            <select class="form-control" id="theme" name="theme">
                                <option value="light">Clair</option>
                                <option value="dark">Sombre</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Enregistrer les préférences</button>
                    </form>
                </div>
            </div>

            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Notifications</h5>
                </div>
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="notificationsEmail">
                        <label class="form-check-label" for="notificationsEmail">
                            Recevoir les notifications par email
                        </label>
                    </div>
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" value="" id="notificationsPush">
                        <label class="form-check-label" for="notificationsPush">
                            Recevoir les notifications sur mon téléphone
                        </label>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection