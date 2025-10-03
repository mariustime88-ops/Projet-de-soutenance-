<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prospectus de l'École Élite</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card.card-maternelle { background-color: #d4edda; border-color: #c3e6cb; }
        .card.card-primaire { background-color: #fff3cd; border-color: #ffeeba; }
        .card.card-secondaire { background-color: #f8d7da; border-color: #f5c6cb; }
        .school-logo { display: flex; align-items: center; justify-content: center; gap: 10px; }
        .school-logo-icon { font-size: 2rem; color: #007bff; }
        .school-logo-text { font-family: 'Georgia', serif; font-size: 1.5rem; font-weight: bold; color: #343a40; }
        body { font-family: 'Arial', sans-serif; color: #495057; }
        .bg-primary { background-color: #007bff !important; }
        .bg-light { background-color: #f8f9fa !important; }
        .bg-dark { background-color: #343a40 !important; }
        section { padding: 60px 0; }
        .card { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important; }
        .img-fluid.rounded { border-radius: 15px !important; }
        .sm\:fixed { position: fixed; }
        .sm\:top-0 { top: 0px; }
        .sm\:right-0 { right: 0px; }
        .p-6 { padding: 1.5rem; }
        .text-right { text-align: right; }
        .z-10 { z-index: 10; }
        .font-semibold { font-weight: 600; }
        .text-gray-600 { color: #4b5563; }
        .hover\:text-gray-900:hover { color: #111827; }
        .focus\:outline:focus { outline-style: solid; }
        .focus\:outline-2:focus { outline-width: 2px; }
        .focus\:rounded-sm:focus { border-radius: 0.125rem; }
        .focus\:outline-red-500:focus { outline-color: #ef4444; }
        .ml-4 { margin-left: 1rem; }
    </style>
</head>
<body>

    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen">
        <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
            @auth
                <a href="{{ url('/home') }}" class="btn btn-primary font-semibold">Accueil</a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="ml-4 btn btn-danger font-semibold">Déconnexion</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-danger font-semibold">Connexion</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 btn btn-danger font-semibold">S'inscrire</a>
                @endif
            @endauth
        </div>

        <div class="w-100">
            <header class="bg-primary text-white text-center py-5">
                <div class="container">
                    <div class="school-logo mb-3">
                        <span class="school-logo-icon">&#x1F393;</span>
                        <span class="school-logo-text">École Élite</span>
                    </div>
                    <h1 class="display-4">Bienvenue à l'École Marius Pythagore</h1>
                    <p class="lead">Découvrez un environnement d'apprentissage exceptionnel où l'excellence et la créativité se rencontrent.</p>
                </div>
            </header>

            <section class="py-5">
                <div class="container">
                    <h2 class="text-center mb-4">Notre Mission</h2>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <img src="{{ asset('etudiant.png') }}" class="img-fluid rounded shadow-sm" alt="Image de la vie étudiante">
                        </div>
                        <div class="col-md-6 d-flex align-items-center">
                            <p class="text-muted">
                                L'École Marius Pythagore s'engage à fournir une éducation de haute qualité qui dépasse largement l'acquisition de connaissances. Notre mission principale est de stimuler la curiosité et de développer l'esprit critique de chaque élève, les préparant ainsi à devenir des penseurs autonomes et créatifs. Nous croyons fermement en une approche holistique, où la réussite académique est indissociable de l'épanouissement personnel. Notre programme combine une rigueur intellectuelle avec un large éventail d'opportunités pour le développement des talents artistiques et sportifs. Que ce soit à travers des ateliers de robotique, des cours de musique ou des compétitions sportives, nous offrons un environnement où chaque enfant peut explorer ses passions, découvrir son potentiel et grandir en confiance. Nous visons à former non seulement des élèves performants, mais aussi des individus équilibrés et responsables, prêts à relever les défis du monde de demain. Un engagement communautaire : Comment l'école prépare les élèves à être des citoyens responsables, par le biais de projets de bénévolat .
                                Le développement personnel : Les activités parascolaires comme les clubs de débat, les cours de théâtre ou la robotique qui sont mentionnées dans votre texte, on pourrait les détailler davantage.
                                De plus, nos salles de classe sont conçues pour encourager la collaboration et la créativité, offrant un environnement moderne et stimulant où les idées peuvent s'épanouir librement. Nous visons à former non seulement des élèves performants, mais aussi des individus équilibrés et responsables, prêts à relever les défis du monde de demain et à y apporter un impact positif.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="bg-light py-5">
                <div class="container">
                    <h2 class="text-center mb-5">Nos Programmes Académiques</h2>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm card-maternelle">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Maternelle</h5>
                                    <p class="card-text text-muted">Éveil et découverte pour les plus petits. Un programme ludique et stimulant pour un départ réussi.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm card-primaire">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Primaire</h5>
                                    <p class="card-text text-muted">Fondations solides en lecture, écriture et mathématiques, avec une approche interactive et créative.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm card-secondaire">
                                <div class="card-body text-center">
                                    <h5 class="card-title">Secondaire</h5>
                                    <p class="card-text text-muted">Préparation à l'avenir, avec un large éventail de matières et un accompagnement personnalisé.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-5">
                <div class="container">
                    <h2 class="text-center mb-5">Galerie de l'École</h2>
                    <div class="row g-4">
                        <div class="col-lg-3 col-md-6">
                            <img src="{{ asset('PLO.png') }}" class="img-fluid rounded shadow-sm" alt="Salle de classe connectée">
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <img src="{{ asset('sport.png') }}" class="img-fluid rounded shadow-sm" alt="Activité sportive">
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <img src="{{ asset('promo.png') }}" class="img-fluid rounded shadow-sm" alt="Laboratoire de sciences">
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <img src="{{ asset('excusion.png') }}" class="img-fluid rounded shadow-sm" alt="Excursion pédagogique">
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p>&copy; 2024 École Marius Pythagore. Tous droits réservés.</p>
            <p>Ma Rue de la Réussite, Ville - Pays | Téléphone : 01 23 45 67 89 | Email : mariustime88@gmail.com</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>