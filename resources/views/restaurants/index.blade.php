<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Liste des Restaurants - MonRestau</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
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


<div class="text-end mb-4">
    <a href="{{ route('restaurants.create') }}" class="btn btn-success">➕ Ajouter un restaurant</a>
</div>


<!-- Contenu -->
<div class="container mt-5">
    <h2 class="mb-4 text-center">🍽️ Nos Restaurants</h2>

    @if($restaurants->isEmpty())
        <div class="alert alert-warning text-center">Aucun restaurant trouvé.</div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach($restaurants as $restaurant)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $restaurant->photo ? asset('storage/' . $restaurant->photo) : asset('images/default-restaurant.jpg') }}"
                             class="card-img-top" alt="{{ $restaurant->nom }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $restaurant->nom }}</h5>
                            <p class="card-text">{{ Str::limit($restaurant->description, 100) }}</p>
                            <a href="{{ route('restaurants.show', $restaurant->id) }}" class="btn btn-outline-primary mt-3">Voir détails</a>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">📍 {{ $restaurant->latitude }}, {{ $restaurant->longitude }}</li>
                            <li class="list-group-item">💰 {{ $restaurant->prix_moyen }} € / repas</li>
                            <li class="list-group-item">👤 {{ $restaurant->contact_nom }} – 📧 {{ $restaurant->contact_email }}</li>
                            <li class="list-group-item">📅 Ouvert depuis le {{ \Carbon\Carbon::parse($restaurant->date_ouverture)->format('d/m/Y') }}</li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
