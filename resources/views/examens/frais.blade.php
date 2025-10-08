@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4 text-success"><i class="fas fa-wallet me-2"></i> Frais des Examens</h1>
    <p class="text-center lead text-muted">Consultez le statut de paiement des frais d'examens pour chaque enfant.</p>

    <div class="row justify-content-center mt-5">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg border-success card-hover-effect animate__fadeInUp">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Statut des Frais par Examen</h4>
                </div>
                <div class="card-body">
                    
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Examen</th>
                                <th>Montant (F CFA)</th>
                                <th>Date Limite</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fraisExamens as $frais)
                            <tr>
                                <td class="fw-bold">{{ $frais['examen'] }}</td>
                                <td>{{ number_format($frais['montant'], 0, ',', ' ') }}</td>
                                <td>{{ \Carbon\Carbon::parse($frais['date_limite'])->format('d/m/Y') }}</td>
                                <td>
                                    @if($frais['statut'] == 'Payé')
                                        <span class="badge bg-success"><i class="fas fa-check-circle"></i> Payé</span>
                                    @else
                                        <span class="badge bg-danger pulse-animation-red"><i class="fas fa-exclamation-circle"></i> {{ $frais['statut'] }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($frais['statut'] != 'Payé')
                                        <a href="#" class="btn btn-sm btn-primary">Payer</a>
                                    @else
                                        <a href="#" class="btn btn-sm btn-outline-secondary">Reçu</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle me-2"></i> Les paiements en ligne sont sécurisés. Le reçu est disponible immédiatement après la validation.
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('examens.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Retour aux Infos Examens
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles d'animation basiques (à conserver) */
.card-hover-effect { transition: transform 0.3s ease, box-shadow 0.3s ease; }
.card-hover-effect:hover { transform: translateY(-5px); box-shadow: 0 0.8rem 2rem rgba(0, 0, 0, 0.15) !important; }
.animate__fadeInUp { animation: fadeInUp 1s ease-out; }
@keyframes fadeInUp {
  from { opacity: 0; transform: translate3d(0, 20px, 0); }
  to { opacity: 1; transform: translate3d(0, 0, 0); }
}
.pulse-animation-red {
    animation: pulse-red 1.5s infinite;
}
@keyframes pulse-red {
    0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4); } /* Rouge danger */
    70% { box-shadow: 0 0 0 8px rgba(220, 53, 69, 0); }
    100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
}
</style>
@endsection