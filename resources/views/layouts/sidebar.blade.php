{{-- ... --}}

{{-- Liens du Menu principal --}}

<a class="nav-link" href="{{ route('home') }}">
    <i class="fas fa-home me-2"></i> Accueil
</a>

<a class="nav-link" href="{{ route('enfants.index') }}">
    <i class="fas fa-users me-2"></i> Ses enfants
</a>

{{-- 🚨 Le lien "Prendre son reçu" --}}
<a class="nav-link" href="{{ route('recus.index') }}">
    <i class="fas fa-receipt me-2"></i> Prendre son reçu
</a>

<a class="nav-link" href="{{ route('notes.index') }}">
    <i class="fas fa-chart-line me-2"></i> Notes de ses enfants
</a>

{{-- ... --}}