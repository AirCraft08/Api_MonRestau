<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MonRestau</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <style>
        #restaurants-map {
            height: 400px;
            border-radius: 8px;
            margin-bottom: 2rem;
            border: 1px solid #ccc;
        }
    </style>


    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1.2s ease-out forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
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



<!-- Présentation -->
<div class="container mt-5 text-center">
    <h1 class="mb-3">Bienvenue sur MonRestau 🍽️</h1>
    <p class="lead">Découvrez les meilleurs restaurants de Lyon, leurs spécialités, leurs prix et les avis d'autres gourmets.</p>
</div>

<!-- Cartes de restaurants -->
<div class="container mt-5">
    <h2 class="mb-4 text-center">🍽️ Derniers restaurants ajoutés</h2>

    @if($restaurants->isEmpty())
        <div class="alert alert-info text-center">Aucun restaurant pour le moment.</div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($restaurants as $restaurant)
                <div class="col fade-in">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $restaurant->photo ? asset('storage/' . $restaurant->photo) : asset('images/default-restaurant.jpg') }}"
                             class="card-img-top" alt="{{ $restaurant->nom }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $restaurant->nom }}</h5>
                            <p class="card-text">{{ Str::limit($restaurant->description, 80) }}</p>
                            <a href="{{ route('restaurants.show', $restaurant->id) }}" class="btn btn-outline-primary mt-3">Voir détails</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-4 mb-3">
            <a href="{{ route('restaurants.index') }}" class="btn btn-primary px-4 py-2">Voir plus de restaurants</a>
        </div>
    @endif

</div>


<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
