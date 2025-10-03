@extends('layouts.app')
<style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 20px;
        }
        .sidebar a {
            color: #f8f9fa;
            padding: 15px;
            text-decoration: none;
            display: block;
        }
        .sidebar a:hover {
            background-color: #495057;
            text-decoration: none;
        }
        .content {
            padding: 20px;
        }
        .card-form {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
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
                        <a class="nav-link" href="{{ route('td.index') }}">TD des enfants</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 content">
            <h1 class="mt-4 text-center" style="color: red;">Programme de TD pour l'année scolaire</h1>

            <div class="card p-4 mt-4 shadow-sm" style="border-left: 5px solid green;">
                <h2 class="card-title" style="color: green;">TD pour les élèves de Terminale</h2>
                <div class="list-group">
                    @forelse($tdsTerminale as $td)
                        @php
                            $bgColor = 'green';
                            $textColor = 'white';
                            if ($td['titre'] == 'TD de Français - La dissertation') {
                                $bgColor = 'yellow';
                                $textColor = 'black';
                            } elseif ($td['titre'] == 'TD de Physique - Électricité') {
                                $bgColor = 'red';
                                $textColor = 'white';
                            }
                        @endphp
                        <div class="list-group-item list-group-item-action mb-2 rounded shadow-sm" style="background-color: {{ $bgColor }}; color: {{ $textColor }};">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1" style="color: {{ $textColor }};">{{ $td['titre'] }}</h5>
                                <span class="badge" style="background-color: {{ $bgColor }}; color: {{ $textColor }};">{{ $td['date'] }}</span>
                            </div>
                            <p class="mb-1" style="color: {{ $textColor }};">{{ $td['description'] }}</p>
                        </div>
                    @empty
                        <div class="alert alert-info">Aucun TD disponible pour les élèves de Terminale.</div>
                    @endforelse
                </div>
            </div>

            <div class="card p-4 mt-5 shadow-sm" style="border-left: 5px solid red;">
                <h2 class="card-title" style="color: red;">TD pour les élèves de Troisième</h2>
                <div class="list-group">
                    @php
                        $colors = ['#FF6347', '#4682B4', '#DAA520']; // Tomate, Acier Bleu, Doré
                        $i = 0;
                    @endphp
                    @forelse($tdsTroisieme as $td)
                        @php
                            $color = $colors[$i % count($colors)];
                            $i++;
                        @endphp
                        <div class="list-group-item list-group-item-action mb-2 rounded shadow-sm" style="background-color: {{ $color }}; color: white;">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1" style="color: white;">{{ $td['titre'] }}</h5>
                                <span class="badge" style="background-color: {{ $color }}; color: white;">{{ $td['date'] }}</span>
                            </div>
                            <p class="mb-1" style="color: white;">{{ $td['description'] }}</p>
                        </div>
                    @empty
                        <div class="alert alert-info">Aucun TD disponible pour les élèves de Troisième.</div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</div>
@endsection