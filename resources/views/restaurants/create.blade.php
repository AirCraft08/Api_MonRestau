<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter un restaurant - MonRestau</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
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

<!-- Formulaire -->
<div class="container mt-5">
    <h2 class="text-center mb-4">🍴 Ajouter un nouveau restaurant</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Erreurs :</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('restaurants.store') }}" enctype="multipart/form-data" class="row g-3">
        @csrf

        <div class="col-md-6">
            <label for="nom" class="form-label">Nom du restaurant *</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="date_ouverture" class="form-label">Date d'ouverture *</label>
            <input type="date" name="date_ouverture" class="form-control" required>
        </div>

        <div class="col-md-12">
            <label for="description" class="form-label">Description *</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="col-md-4">
            <label for="prix_moyen" class="form-label">Prix moyen (€) *</label>
            <input type="number" name="prix_moyen" class="form-control" required>
        </div>

        <div class="col-md-12">
            <label class="form-label">Localisation *</label>
            <div id="map" style="height: 400px; border: 1px solid #ccc; border-radius: 8px;"></div>
        </div>

        <div class="col-md-6">
            <label for="latitude" class="form-label">Latitude *</label>
            <input type="text" id="latitude" name="latitude" class="form-control" required readonly>
        </div>

        <div class="col-md-6">
            <label for="longitude" class="form-label">Longitude *</label>
            <input type="text" id="longitude" name="longitude" class="form-control" required readonly>
        </div>


        <div class="col-md-6">
            <label for="contact_nom" class="form-label">Nom du contact *</label>
            <input type="text" name="contact_nom" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label for="contact_email" class="form-label">Email du contact *</label>
            <input type="email" name="contact_email" class="form-control" required>
        </div>

        <div class="col-md-12">
            <label for="photo" class="form-label">Photo du restaurant</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-success px-4">✅ Ajouter le restaurant</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let map = L.map('map').setView([45.75, 4.85], 12); // Centré sur Lyon

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        let marker;

        map.on('click', function (e) {
            const lat = e.latlng.lat.toFixed(6);
            const lng = e.latlng.lng.toFixed(6);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }
        });
    });
</script>


</body>
</html>
