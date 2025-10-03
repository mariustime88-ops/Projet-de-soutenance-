document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('toggle-dark-mode');
    const body = document.body;

    // Écoute le clic sur le bouton
    if (toggleButton) {
        toggleButton.addEventListener('click', function() {
            // Bascule entre la classe "dark-mode" et "light-mode"
            body.classList.toggle('dark-mode');
        });
    }
});