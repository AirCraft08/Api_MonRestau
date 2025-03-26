@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center mb-4">Mon Profil</h2>

        <!-- Formulaire pour modifier les informations personnelles -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4>Modifier mes informations</h4>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Laissez vide si vous ne souhaitez pas changer votre mot de passe">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                    <button type="submit" class="btn btn-primary">Mettre à jour mes informations</button>
                </form>
            </div>
        </div>

        <!-- Section des restaurants créés -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4>Mes restaurants créés</h4>
                @if($restaurants->isEmpty())
                    <p>Vous n'avez pas encore créé de restaurant.</p>
                @else
                    <ul class="list-group">
                        @foreach($restaurants as $restaurant)
                            <li class="list-group-item">
                                <strong>{{ $restaurant->nom }}</strong>
                                <br>Prix moyen : {{ $restaurant->prix_moyen }} €
                                <br><a href="{{ route('restaurants.show', $restaurant->id) }}" class="btn btn-info btn-sm mt-2">Voir</a>

                                <!-- Formulaire de suppression avec confirmation JS -->
                                <form action="{{ route('profile.destroyRestaurant', $restaurant->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce restaurant ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mt-2">Supprimer</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <!-- Section des avis laissés par l'utilisateur -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4>Mes avis</h4>
                @if($avis->isEmpty())
                    <p>Vous n'avez pas encore laissé d'avis.</p>
                @else
                    <ul class="list-group">
                        @foreach($avis as $a)
                            <li class="list-group-item">
                                <strong>Restaurant : {{ $a->restaurant->nom }}</strong> - {{ $a->note }} ⭐
                                <br>{{ $a->commentaire }}
                                <br><small>Le {{ $a->created_at->diffForHumans() }}</small>

                                <!-- Formulaire de suppression de l'avis avec confirmation JS -->
                                <form action="{{ route('profile.destroyAvis', $a->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mt-2">Supprimer</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
