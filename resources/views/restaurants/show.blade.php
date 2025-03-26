<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $restaurant->nom }} - Détails | MonRestau</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .restaurant-image {
            height: 400px;
            object-fit: cover;
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" width="30" class="d-inline-block align-text-top">
            MonRestau
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('restaurants.index') }}">Restaurants</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenu -->
<div class="container mt-5 mb-5">
    <a href="{{ route('restaurants.index') }}" class="btn btn-outline-secondary mb-4">← Retour à la liste</a>

    <div class="card shadow p-4">
        @if ($restaurant->photo)
            <img src="{{ asset('storage/' . $restaurant->photo) }}" class="restaurant-image w-100 mb-4" alt="{{ $restaurant->nom }}">
        @else
            <img src="{{ asset('images/default-restaurant.jpg') }}" class="restaurant-image w-100 mb-4" alt="Image par défaut">
        @endif

        <h1 class="mb-3">{{ $restaurant->nom }}</h1>

        <p class="lead">{{ $restaurant->description }}</p>

        <hr>

        <div class="row mb-3">
            <div class="col-md-6">
                <h5>📅 Date d'ouverture :</h5>
                <p>{{ \Carbon\Carbon::parse($restaurant->date_ouverture)->format('d/m/Y') }}</p>
            </div>
            <div class="col-md-6">
                <h5>💰 Prix moyen :</h5>
                <p>{{ $restaurant->prix_moyen }} €</p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <h5>📍 Localisation :</h5>
                <p>Lat : {{ $restaurant->latitude }}<br>Lng : {{ $restaurant->longitude }}</p>

                <h5 class="mt-4">📍 Emplacement sur la carte :</h5>
                <div id="map" style="height: 400px; border-radius: 8px; border: 1px solid #ccc;"></div>
            </div>
            <div class="col-md-6">
                <h5>👤 Contact :</h5>
                <p>{{ $restaurant->contact_nom }}<br>{{ $restaurant->contact_email }}</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let lat = {{ $restaurant->latitude }};
        let lng = {{ $restaurant->longitude }};

        let map = L.map('map').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup("{{ $restaurant->nom }}").openPopup();
    });
</script>


</body>
</html>
