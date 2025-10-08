{{-- Ce fichier est chargé par AJAX dans emploi_du_temps/index.blade.php --}}

<div class="card shadow-lg border-0 animate__animated animate__fadeInUp">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Emploi du Temps : **{{ $classe }}**</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover mb-0 text-center">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 15%;">Jour</th>
                        <th style="width: 25%;">Heure</th>
                        <th>Matière</th>
                        <th style="width: 20%;">Salle</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        // Définir les jours de la semaine si l'EDT n'est pas complet
                        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
                    @endphp

                    @foreach($jours as $jour)
                        @if(isset($emploiDuTemps[$jour]) && count($emploiDuTemps[$jour]) > 0)
                            {{-- Compte le nombre de lignes (cours) pour ce jour --}}
                            @php $rowCount = count($emploiDuTemps[$jour]); @endphp

                            @foreach($emploiDuTemps[$jour] as $key => $cours)
                                <tr>
                                    {{-- Afficher le jour seulement sur la première ligne --}}
                                    @if($key === 0)
                                        <td rowspan="{{ $rowCount }}" class="align-middle fw-bold bg-light text-primary">
                                            {{ $jour }}
                                        </td>
                                    @endif
                                    
                                    {{-- Détails du cours --}}
                                    <td class="align-middle">{{ $cours['heure'] }}</td>
                                    <td class="align-middle text-dark fw-medium">{{ $cours['matiere'] }}</td>
                                    <td class="align-middle">{{ $cours['salle'] }}</td>
                                </tr>
                            @endforeach
                        @else
                            {{-- Jour sans cours (ou données manquantes) --}}
                            <tr>
                                <td class="align-middle fw-bold bg-light text-primary">{{ $jour }}</td>
                                <td colspan="3" class="text-muted fst-italic">Pas de cours planifié ce jour.</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>