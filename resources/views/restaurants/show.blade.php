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

    @if($restaurant->avis->count())
        <p class="fw-bold" style="padding-top: 1rem">Note moyenne : {{ number_format($restaurant->avis->avg('note'), 1) }} ⭐</p>
    @endif

    @foreach($restaurant->avis as $avis)
        <div class="border rounded p-2 mb-2">
            <strong>{{ $avis->user->name }}</strong> – {{ $avis->note }} ⭐
            <p class="mb-0">{{ $avis->commentaire }}</p>
            <small class="text-muted">{{ $avis->created_at->diffForHumans() }}</small>
        </div>
    @endforeach


@auth
        <form method="POST" action="{{ route('avis.store', $restaurant->id) }}" class="mb-4">
            @csrf
            <div class="mb-2">
                <label for="note" style="padding-top: 1rem">Note :</label>
                <select name="note" id="note" class="form-select" required>
                    <option value="">-- Sélectionner une note --</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">{{ $i }} ⭐</option>
                    @endfor
                </select>
            </div>
            <div class="mb-2">
                <label for="commentaire">Avis :</label>
                <textarea name="commentaire" class="form-control" rows="3"></textarea>
            </div>
            <button class="btn btn-primary">Laisser un avis</button>
        </form>
    @endauth

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Leaflet CSS & JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        let lat = {{ $restaurant->latitude }};
        let lng = {{ $restaurant->longitude }};

        let map = L.map('map').setView([lat, lng], 16);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup("{{ $restaurant->nom }}").openPopup();
    });
</script>


</body>
</html>
