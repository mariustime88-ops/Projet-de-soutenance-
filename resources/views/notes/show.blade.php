@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 text-primary">Bulletin de Notes - {{ $enfant->prenom }} {{ $enfant->nom }}</h1>
                <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-chevron-left mr-2"></i> Retour à la sélection
                </a>
            </div>

            {{-- Carte d'informations de l'enfant --}}
            <div class="card shadow-lg mb-5 rounded-xl">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">Détails de l'enfant</h4>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <p class="font-weight-bold mb-0 text-secondary">Nom & Prénom:</p>
                            <p class="h5 text-dark">{{ $enfant->nom }} {{ $enfant->prenom }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="font-weight-bold mb-0 text-secondary">Classe:</p>
                            <p class="h5 text-dark">{{ $enfant->classe }}</p>
                        </div>
                        <div class="col-md-4">
                            <p class="font-weight-bold mb-0 text-secondary">Année Scolaire:</p>
                            <p class="h5 text-dark">{{ date('Y') - 1 }} / {{ date('Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tableau des Notes Détaillé --}}
            <div class="table-responsive">
                <table class="table table-hover table-bordered shadow-sm bg-white rounded-lg">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col" class="text-center" style="width: 25%;">Matière</th>
                            <th scope="col" class="text-center" style="width: 10%;">Coeff.</th>
                            <th scope="col" class="text-center" style="width: 20%;">Semestre 1 (S1)</th>
                            <th scope="col" class="text-center" style="width: 20%;">Semestre 2 (S2)</th>
                            <th scope="col" class="text-center" style="width: 25%;">Moyenne Annuelle Matière</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resultats as $id => $resultat)
                            <tr>
                                <td class="font-weight-bold">{{ $resultat['nom'] }}</td>
                                <td class="text-center text-primary">{{ $resultat['coeff'] }}</td>
                                
                                {{-- Note S1 : Couleur rouge si < 10 --}}
                                <td class="text-center @if(is_numeric($resultat['notes']['S1']) && $resultat['notes']['S1'] < 10) table-danger @endif">
                                    {{ $resultat['notes']['S1'] ?? 'N/A' }}
                                </td>
                                
                                {{-- Note S2 : Couleur rouge si < 10 --}}
                                <td class="text-center @if(is_numeric($resultat['notes']['S2']) && $resultat['notes']['S2'] < 10) table-danger @endif">
                                    {{ $resultat['notes']['S2'] ?? 'N/A' }}
                                </td>
                                
                                {{-- Moyenne Annuelle Matière : Couleur verte si >= 10, rouge sinon --}}
                                <td class="text-center font-weight-bold 
                                    @if(is_numeric($resultat['moyenne_annuelle']))
                                        @if($resultat['moyenne_annuelle'] < 10) text-danger @else text-success @endif
                                    @else 
                                        text-muted 
                                    @endif">
                                    {{ $resultat['moyenne_annuelle'] ?? 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                        
                        {{-- NOUVEAU : LIGNE DE CONDUITE, TOUJOURS EN BAS --}}
                        @if(isset($noteConduite))
                            @php
                                // Utilisation de la classe de couleur définie dans le modèle/contrôleur
                                $statutCouleur = $noteConduite['statut']['couleur'] ?? 'secondary';
                            @endphp
                            <tr class="table-danger fw-bold border-top border-dark border-3"> 
                                <td class="text-uppercase text-danger font-italic">
                                    {{ $noteConduite['nom'] }}
                                </td>
                                <td class="text-center text-danger">{{ $noteConduite['coeff'] }}</td>
                                
                                {{-- Note S1 Conduite --}}
                                <td class="text-center bg-{{ $statutCouleur }} text-white">
                                    {{ $noteConduite['notes']['S1'] ?? 'N/A' }}
                                </td>
                                
                                {{-- Note S2 Conduite --}}
                                <td class="text-center bg-{{ $statutCouleur }} text-white">
                                    {{ $noteConduite['notes']['S2'] ?? 'N/A' }}
                                </td>
                                
                                {{-- Moyenne Annuelle Conduite --}}
                                <td class="text-center bg-{{ $statutCouleur }} text-white">
                                    {{ $noteConduite['moyenne_annuelle'] ?? 'N/A' }}
                                </td>
                            </tr>
                        @endif
                        {{-- FIN LIGNE DE CONDUITE --}}
                        
                    </tbody>
                </table>
            </div>

            {{-- Cartes de Synthèse des Moyennes Générales --}}
            <h3 class="mt-5 mb-4 text-center text-secondary">Synthèse des Moyennes Générales (Pondérées par coefficient)</h3>
            <div class="row justify-content-center">
                
                {{-- Carte Moyenne S1 --}}
                <div class="col-md-4 mb-3">
                    <div class="card text-white shadow border-0 h-100" style="background-color: #007bff;">
                        <div class="card-body text-center">
                            <h5 class="card-title">Moyenne Générale S1</h5>
                            <p class="display-4 font-weight-bold mb-0">{{ $moyenneSemestre1 }}</p>
                            <p class="card-text">Statut du premier semestre</p>
                        </div>
                    </div>
                </div>

                {{-- Carte Moyenne S2 --}}
                <div class="col-md-4 mb-3">
                    <div class="card text-white shadow border-0 h-100" style="background-color: #ffc107;">
                        <div class="card-body text-center">
                            <h5 class="card-title">Moyenne Générale S2</h5>
                            <p class="display-4 font-weight-bold mb-0">{{ $moyenneSemestre2 }}</p>
                            <p class="card-text">Statut du second semestre</p>
                        </div>
                    </div>
                </div>

                {{-- Carte Moyenne Annuelle (Conduite incluse) --}}
                <div class="col-md-4 mb-3">
                    <div class="card text-white shadow border-0 h-100" style="background-color: #28a745;">
                        <div class="card-body text-center">
                            <h5 class="card-title">Moyenne Générale Annuelle</h5>
                            <p class="display-4 font-weight-bold mb-0">{{ $moyenneAnnuelleGenerale }}</p>
                            <p class="card-text">Moyenne finale des deux semestres (Conduite incluse)</p>
                        </div>
                    </div>
                </div>

            </div>
            
            <div class="my-5"></div>
        </main>
    </div>
</div>
@endsection
