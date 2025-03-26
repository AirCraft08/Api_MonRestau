<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'MonRestau' }}</title>  <!-- Titre dynamique -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Navbar commune à toutes les pages -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">MonRestau</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('restaurants') ? 'active' : '' }}" href="{{ route('restaurants.index') }}">Restaurants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('carte.index') }}">Carte</a>
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
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Mon Profil</a></li>
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

<!-- Contenu dynamique de chaque page -->
<div class="container mt-4">
    @yield('content')
</div>


<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
