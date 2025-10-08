@extends('layouts.app')

@section('content')
<div class="container mt-5">
    
    <div class="text-center mb-5 animate__animated animate__fadeInDown">
        <h1 class="display-4 fw-bold text-secondary">Paramètres de l'Application ⚙️</h1>
        <p class="lead text-muted">Gérez votre compte, vos préférences et les notifications.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeIn mb-4 shadow" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card shadow-lg border-0 animate__animated animate__fadeInUp">
        <div class="card-body p-0">
            
            <ul class="list-group list-group-flush">
                
                {{-- SECTION 1: Compte et Profil --}}
                <li class="list-group-item list-item-effect d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#profileModal">
                    <div>
                        <i class="fas fa-user-circle fa-lg text-primary me-3"></i>
                        <span class="fw-bold">Compte</span>
                        <p class="mb-0 text-muted small">Nom d'utilisateur, changer le mot de passe, informations personnelles.</p>
                    </div>
                    <i class="fas fa-chevron-right text-muted"></i>
                </li>

                {{-- SECTION 2: Thème (Discussion/Affichage) --}}
                <li class="list-group-item list-item-effect d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#themeModal">
                    <div>
                        <i class="fas fa-palette fa-lg text-secondary me-3"></i>
                        <span class="fw-bold">Affichage & Thème</span>
                        <p class="mb-0 text-muted small">Mode clair/sombre, taille du texte.</p>
                    </div>
                    <i class="fas fa-chevron-right text-muted"></i>
                </li>

                {{-- SECTION 3: Notifications --}}
                <li class="list-group-item list-item-effect d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-bell fa-lg text-warning me-3"></i>
                        <span class="fw-bold">Notifications</span>
                        <p class="mb-0 text-muted small">Sonneries, alertes de nouvelles notes ou de composition.</p>
                    </div>
                    <div class="form-check form-switch me-2">
                        <input class="form-check-input" type="checkbox" id="notificationSwitch" checked>
                        <label class="form-check-label visually-hidden" for="notificationSwitch">Activer/Désactiver</label>
                    </div>
                </li>

                {{-- SECTION 4: Langue --}}
                <li class="list-group-item list-item-effect d-flex justify-content-between align-items-center" data-bs-toggle="modal" data-bs-target="#langueModal">
                    <div>
                        <i class="fas fa-language fa-lg text-info me-3"></i>
                        <span class="fw-bold">Langue de l'Application</span>
                        <p class="mb-0 text-muted small">Français (Langue du système).</p>
                    </div>
                    <i class="fas fa-chevron-right text-muted"></i>
                </li>

            </ul>
            
        </div>
    </div>
</div>

{{-- ========================================================== --}}
{{-- MODALS pour les actions --}}
{{-- ========================================================== --}}

{{-- Modal 1: Compte / Changer Mot de Passe (INCHANGÉ) --}}
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content animate__animated animate__zoomIn">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="profileModalLabel"><i class="fas fa-key me-2"></i> Modifier le Mot de Passe</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('parametres.update.password') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required minlength="8">
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal 2: Thème (CORRIGÉ ET FONCTIONNEL) --}}
<div class="modal fade" id="themeModal" tabindex="-1" aria-labelledby="themeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content animate__animated animate__zoomIn">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title" id="themeModalLabel"><i class="fas fa-palette me-2"></i> Choisir le Thème</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-theme" data-theme="light" id="theme-light">
                        <i class="fas fa-sun me-1"></i> Mode Clair
                    </button>
                    <button type="button" class="btn btn-theme" data-theme="dark" id="theme-dark">
                        <i class="fas fa-moon me-1"></i> Mode Sombre
                    </button>
                </div>
                <p class="mt-3 text-muted">Le thème choisi sera conservé pour vos prochaines visites.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal 3: Langue (SIMULATION) --}}
<div class="modal fade" id="langueModal" tabindex="-1" aria-labelledby="langueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content animate__animated animate__zoomIn">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="langueModalLabel"><i class="fas fa-language me-2"></i> Changer la Langue</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <select class="form-select">
                    <option selected>Français (Système)</option>
                    <option>Anglais</option>
                </select>
                <p class="mt-2 text-muted small">L'implémentation de la langue nécessite la configuration d'Internationalisation de Laravel.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styles pour simuler l'interface mobile */
    .list-group-item {
        padding: 15px 20px;
        cursor: pointer;
    }
    .list-item-effect {
        transition: background-color 0.2s, transform 0.2s;
        border-left: 5px solid transparent;
    }
    .list-item-effect:hover {
        background-color: var(--bs-light); 
        transform: translateX(5px);
        border-left: 5px solid var(--bs-primary);
    }
    
    /* Styles pour les boutons de thème */
    .btn-theme {
        flex-grow: 1;
        border: 1px solid var(--bs-secondary);
        color: var(--bs-secondary);
        background-color: transparent;
    }
    .btn-theme.active {
        background-color: var(--bs-primary);
        color: var(--bs-white);
        border-color: var(--bs-primary);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggles = document.querySelectorAll('.btn-theme');
        const htmlElement = document.documentElement;

        // 1. Fonction pour appliquer le thème
        function applyTheme(theme) {
            if (theme === 'dark') {
                htmlElement.setAttribute('data-bs-theme', 'dark');
            } else {
                htmlElement.removeAttribute('data-bs-theme'); // Revient au mode light/par défaut
            }
            localStorage.setItem('theme', theme);
            updateThemeButtons(theme);
        }
        
        // 2. Fonction pour mettre à jour l'état des boutons dans le modal
        function updateThemeButtons(currentTheme) {
            themeToggles.forEach(btn => {
                btn.classList.remove('active');
                if (btn.getAttribute('data-theme') === currentTheme) {
                    btn.classList.add('active');
                }
            });
        }

        // 3. Charger le thème sauvegardé au démarrage
        const savedTheme = localStorage.getItem('theme') || 'light'; 
        applyTheme(savedTheme);

        // 4. Écouteur d'événement pour le clic sur les boutons de thème
        themeToggles.forEach(button => {
            button.addEventListener('click', function() {
                const newTheme = this.getAttribute('data-theme');
                applyTheme(newTheme);
            });
        });
        
        // 5. Appliquer la classe 'active' quand le modal est ouvert (pour s'assurer que l'état est correct)
        const themeModal = document.getElementById('themeModal');
        themeModal.addEventListener('show.bs.modal', function() {
            const currentTheme = localStorage.getItem('theme') || 'light';
            updateThemeButtons(currentTheme);
        });

        // Gestion des erreurs de validation (si le mot de passe est incorrect)
        @if ($errors->any())
            const profileModal = new bootstrap.Modal(document.getElementById('profileModal'));
            profileModal.show();
        @endif
    });
</script>
@endsection