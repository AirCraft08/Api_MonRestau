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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Accueil</a></li>
                <li class="nav-item"><a class="nav-link active" href="{{ route('restaurants.index') }}">Restaurants</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('restaurants.create') }}">Ajouter</a></li>
            </ul>
        </div>
    </div>
</nav>

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
