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
                        <a class="nav-link" href="{{ route('paiement.index') }}">Payé la scolarité</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('settings.index') }}">Paramètres</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 content">
            <h1 class="mt-4 text-center text-secondary">Paiement de la Scolarité</h1>
            <p class="lead text-center text-muted">Instructions pour le paiement par Mobile Money.</p>

            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Paiement via Mobile Money (MoMo)</h5>
                </div>
                <div class="card-body">
                    <p>Pour payer la scolarité, veuillez suivre ces instructions :</p>
                    <ol>
                        <li>Composez le code USSD de votre opérateur (par exemple, `*145#` pour Moov ou `*500#` pour MTN).</li>
                        <li>Sélectionnez l'option de transfert d'argent.</li>
                        <li>Entrez le numéro du bénéficiaire : <strong>0146853227</strong>.</li>
                        <li>Entrez le montant de la scolarité.</li>
                        <li>Confirmez la transaction avec votre code PIN.</li>
                        <li>Ecrivez nous sur WhatsApp au numéro <strong> 0146853227 </strong> afin de nous montrez votre ID de translation,les informations de l'étudiant et prendre votre reçu après .</li>
                    </ol>
                    <hr>
                    <p class="text-info"><i class="fas fa-info-circle"></i> Une fois le paiement effectué, veuillez conserver la confirmation de transaction (SMS) comme preuve de paiement pour l'envoyer et ensuite recevoir votre reçcu .</p>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection