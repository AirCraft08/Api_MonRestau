<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MonRestau</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" width="30" class="d-inline-block align-text-top">
            MonRestau
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('restaurants.index') }}">Restaurants</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Login</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Autre action</a></li>
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
<div class="container mt-4">
    <h2 class="mb-4">Nos restaurants recommandés</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <!-- Carte 1 -->
        <div class="col">
            <div class="card h-100">
                <img src="{{ asset('images/chezmomo.jpg') }}" class="card-img-top" alt="Chez Momo">
                <div class="card-body">
                    <h5 class="card-title">Chez Momo</h5>
                    <p class="card-text">🍜 Spécialités orientales<br>📍 12 Rue de Marseille, Lyon<br>💰 20€ / repas</p>
                </div>
            </div>
        </div>
        <!-- Carte 2 -->
        <div class="col">
            <div class="card h-100">
                <img src="{{ asset('images/petitbouchon.jpg') }}" class="card-img-top" alt="Le Petit Bouchon">
                <div class="card-body">
                    <h5 class="card-title">Le Petit Bouchon</h5>
                    <p class="card-text">🥘 Cuisine lyonnaise<br>📍 7 Quai de Saône, Lyon<br>💰 30€ / repas</p>
                </div>
            </div>
        </div>
        <!-- Carte 3 -->
        <div class="col">
            <div class="card h-100">
                <img src="{{ asset('images/sushizen.jpg') }}" class="card-img-top" alt="Sushi Zen">
                <div class="card-body">
                    <h5 class="card-title">Sushi Zen</h5>
                    <p class="card-text">🍣 Japonais raffiné<br>📍 22 Rue Paul Bert, Lyon<br>💰 25€ / repas</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
