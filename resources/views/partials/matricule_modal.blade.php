<div class="modal fade" id="matriculeModal" tabindex="-1" aria-labelledby="matriculeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="matriculeModalLabel">Numéros Matricules de Vos Enfants</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <p class="text-muted">Cliquez sur le nom de l'enfant pour révéler son numéro matricule.</p>
                
                @if (!empty($enfants) && $enfants->count() > 0)
                    @foreach ($enfants as $enfant)
                        {{-- **IMPORTANT:** Utiliser la classe matricule-clickable-item pour le ciblage JS --}}
                        <div class="d-flex justify-content-between align-items-center p-3 border-bottom matricule-clickable-item"
                            style="cursor: pointer;"
                            data-matricule="{{ $enfant->matricule ?? 'Matricule non assigné' }}"
                            data-nom-complet="{{ $enfant->nom }} {{ $enfant->prenom }}">
                            
                            {{-- Affichage du nom/prénom --}}
                            <span class="h5 mb-0 text-decoration-none">
                                <i class="fas fa-user-graduate me-2 text-primary"></i> 
                                {{ $enfant->nom }} {{ $enfant->prenom }}
                            </span>
                            
                            {{-- Zone du bouton/statut CLIQUER --}}
                            <span class="matricule-result badge bg-secondary p-2"> 
                                CLIQUER
                            </span>
                        </div>
                    @endforeach
                @else
                    <p class="text-danger">Aucun enfant trouvé pour votre compte.</p>
                @endif
                
                <div id="info-alert" class="alert alert-info mt-3" role="alert">
                    Le numéro matricule est un identifiant unique à conserver.
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

{{-- ---------------------------------------------------------------- --}}
{{-- SCRIPT JAVASCRIPT : Placé ici pour une exécution garantie (Solution de contournement si @push ne marche pas) --}}
{{-- ---------------------------------------------------------------- --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const clickableItems = document.querySelectorAll('.matricule-clickable-item');
        const infoAlert = document.getElementById('info-alert');

        // Gérer le clic sur le nom de l'enfant
        clickableItems.forEach(item => {
            item.addEventListener('click', function() {
                const matricule = this.getAttribute('data-matricule');
                const nomComplet = this.getAttribute('data-nom-complet');
                
                // Réinitialisation de la surbrillance
                clickableItems.forEach(i => i.classList.remove('bg-light'));
                this.classList.add('bg-light');

                // Récupération du span qui affiche "CLIQUER"
                const matriculeSpan = this.querySelector('.matricule-result');
                
                // Vérification et Affichage
                if (matricule && matricule !== 'Matricule non assigné' && matricule !== 'N/A') {
                    // 1. Alerte pop-up demandée
                    alert(`Le matricule de ${nomComplet} est : ${matricule}`);

                    // 2. Mise à jour du badge à côté du nom
                    if (matriculeSpan) {
                         matriculeSpan.textContent = matricule;
                         matriculeSpan.classList.remove('bg-secondary');
                         matriculeSpan.classList.add('bg-success');
                    }

                    // 3. Mise à jour de l'alerte principale
                    infoAlert.classList.remove('alert-info', 'alert-danger');
                    infoAlert.classList.add('alert-success');
                    infoAlert.innerHTML = `<strong>Matricule affiché :</strong> ${matricule} (${nomComplet}).`;

                } else {
                    alert(`Attention ! Le matricule pour ${nomComplet} n'est pas disponible.`);
                    
                    // Mise à jour du badge
                    if (matriculeSpan) {
                         matriculeSpan.textContent = 'Non trouvé';
                         matriculeSpan.classList.remove('bg-secondary');
                         matriculeSpan.classList.add('bg-danger');
                    }
                    
                    // Mise à jour de l'alerte principale
                    infoAlert.classList.remove('alert-info', 'alert-success');
                    infoAlert.classList.add('alert-danger');
                    infoAlert.innerHTML = `<strong>Erreur :</strong> Matricule non assigné pour ${nomComplet}. Veuillez vérifier la base de données.`;
                }
            });
        });
        
        // Gérer la réinitialisation de la modale à la fermeture (pour le prochain affichage)
        const matriculeModal = document.getElementById('matriculeModal');
        if (matriculeModal) {
            // Utilisation de l'événement natif de Bootstrap 5
            matriculeModal.addEventListener('hidden.bs.modal', function () {
                infoAlert.classList.remove('alert-success', 'alert-danger');
                infoAlert.classList.add('alert-info');
                infoAlert.innerHTML = `Le numéro matricule est un identifiant unique à conserver.`;
                
                clickableItems.forEach(i => {
                    i.classList.remove('bg-light');
                    const span = i.querySelector('.matricule-result');
                    if(span) {
                        span.textContent = 'CLIQUER';
                        span.classList.remove('bg-success', 'bg-danger');
                        span.classList.add('bg-secondary');
                    }
                });
            });
        }
    });
</script>