<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carte des restaurants – MonRestau</title>

    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body>

<!-- Navbar identique à la page d’accueil -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" width="30" class="d-inline-block align-text-top">
            MonRestau
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <!-- Tous les liens à droite -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 d-flex align-items-center gap-2">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('restaurants') ? 'active' : '' }}" href="{{ route('restaurants.index') }}">Restaurants</a>
                </li>
                <li>
                    <a class="nav-link {{ Request::is('carte') ? 'active' : '' }}" href="{{ route('carte.index') }}">Carte</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Mon compte
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                        @guest
                            <li><a class="dropdown-item" href="{{ route('login') }}">Se connecter</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">S'inscrire</a></li>
                        @else
                            <li><span class="dropdown-item-text">👋 Bonjour {{ Auth::user()->name }}</span></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">Mon Profil</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Déconnexion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                            </li>
                        @endguest
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>

<!-- Carte -->
<div class="container mt-4">
    <h2 class="text-center mb-4">📍 Tous nos restaurants sur la carte</h2>
    <div id="map" class="mb-5" style="height: 600px; border: 1px solid #ccc; border-radius: 8px;"></div>
</div>

<!-- JS Bootstrap + Leaflet -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const map = L.map('map').setView([45.75, 4.85], 12); // Centré sur Lyon

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        @foreach($restaurants as $restaurant)
        @if($restaurant->latitude && $restaurant->longitude)
        L.marker([{{ $restaurant->latitude }}, {{ $restaurant->longitude }}])
            .addTo(map)
            .bindPopup(`
                        <strong>{{ $restaurant->nom }}</strong><br>
                        {{ $restaurant->prix_moyen }} € / repas<br>
                        <a href='{{ route('restaurants.show', $restaurant->id) }}'>Voir détails</a>
                    `);
        @endif
        @endforeach
    });
</script>

</body>
</html>
