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
                                <br>Description : {{ $restaurant->description }}
                                <br><a href="{{ route('restaurants.show', $restaurant->id) }}" class="btn btn-info btn-sm mt-2">Voir</a>
                                <a href="{{ route('restaurants.edit', $restaurant->id) }}" class="btn btn-success btn-sm mt-2">Modifier</a>
                                <!-- Supprimer le restaurant -->
                                <button type="button" class="btn btn-danger btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#deleteRestaurantsModal" data-id="{{ $restaurant->id }}">Supprimer</button>
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
                                <br><small>{{ $a->created_at->diffForHumans() }}</small>

                                <!-- Supprimer l'avis -->
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAvisModal" data-id="{{ $a->id }}">Supprimer</button>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de confirmation pour supprimer un restaurant -->
    <div class="modal fade" id="deleteRestaurantsModal" tabindex="-1" aria-labelledby="deleteRestaurantsModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteRestaurantsModalLabel">Supprimer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer ce restaurant?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non, fermer</button>
                    <form id="confirmRestaurantsDeleteBtn" action="" method="POST" >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Avis Modal -->
    <div class="modal fade" id="deleteAvisModal" tabindex="-1" aria-labelledby="deleteAvisModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteAvisModalLabel">Supprimer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer cet avis?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non, fermer</button>
                    <form id="confirmAvisDeleteBtn" action="" method="POST" >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Oui, supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.btn-danger[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', function() {
                let itemId = this.getAttribute('data-id');
                let targetModal = this.getAttribute('data-bs-target');

                if (targetModal === "#deleteRestaurantsModal") {
                    let shopForm = document.getElementById('confirmRestaurantsDeleteBtn');
                    shopForm.action = '{{ route('restaurants.destroy', ':id') }}'.replace(':id', itemId);
                }

                //supression avis
                else if (targetModal === "#deleteAvisModal") {
                    let productForm = document.getElementById('confirmAvisDeleteBtn');
                    productForm.action = '{{ route('avis.destroy', ':id') }}'.replace(':id', itemId);
                }
            });
        });
    </script>
@endsection

@section('scripts')

@endsection
