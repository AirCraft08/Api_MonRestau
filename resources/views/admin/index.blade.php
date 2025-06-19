@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="text-center">Tableau de bord Admin</h2>
        <p class="text-center">Gérez les restaurants et les avis depuis cette page.</p>

        <!-- Gestion des Restaurants -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Gestion des Restaurants</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom du Restaurant</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($restaurants as $restaurant)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $restaurant->nom }}</td>
                                    <td>{{ $restaurant->description }}</td>
                                    <td>
                                        <!-- Lien pour voir le restaurant -->
                                        <a href="{{ route('restaurants.show', $restaurant->id) }}" class="btn btn-info btn-sm">Voir</a>

                                        <!-- Lien pour modifier le restaurant -->
                                        <a href="{{ route('admin.restaurant.edit', $restaurant->id) }}" class="btn btn-warning btn-sm">Modifier</a>

                                        <!-- Formulaire pour supprimer le restaurant -->
                                        <form action="{{ route('admin.restaurant.delete', $restaurant->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gestion des Avis -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Gestion des Avis</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Restaurant</th>
                                <th>Note</th>
                                <th>Commentaire</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($avis as $a)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $a->restaurant->nom }}</td>
                                    <td>{{ $a->note }} ⭐</td>
                                    <td>{{ $a->commentaire }}</td>
                                    <td>
                                        <!-- Delete button (open modal) -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteOrderModal" data-id="{{ $a->id }}">Supprimer</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <!-- Delete Order Modal -->
                        <div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="deleteOrderModalLabel">Supprimer</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer cet avis ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non, fermer</button>
                                        <!-- Confirm Delete Button -->
                                        <button type="submit" class="btn btn-danger" id="confirmOrderDeleteBtn">Oui, supprimer</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Toasts-->
                        <div class="toast-container position-fixed bottom-0 end-0 p-3">
                            <!-- Valid Toast -->
                            <div class="toast text-bg-success border-0" id="validToast"  role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay='5000'>
                                <div class="d-flex">
                                    <div class="toast-body" id="validToastText">
                                        Message
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>

                            <!-- Error Toast -->
                            <div class="toast text-bg-danger border-0" id="errorToast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay='5000'>
                                <div class="d-flex">
                                    <div class="toast-body" id="errorToastText">
                                        Message
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        function showValid(message) {
            let toast = document.getElementById('validToast');
            let p = document.getElementById('validToastText');
            p.innerHTML = message;
            bootstrap.Toast.getOrCreateInstance(toast).show();
        }

        function showError(message) {
            let toast = document.getElementById('errorToast');
            let p = document.getElementById('errorToastText');
            p.innerHTML = 'Error: ' + message;
            bootstrap.Toast.getOrCreateInstance(toast).show();
        }

        let itemId;

        document.querySelectorAll('.btn-danger[data-bs-toggle="modal"]').forEach(button => {
            button.addEventListener('click', function() {
                itemId = this.getAttribute('data-id');
            });
        });

        document.getElementById('confirmOrderDeleteBtn').addEventListener('click', function() {
            if(!itemId) return;

            let url = "{{ route('admin.avis.delete', ':id') }}".replace(':id', itemId);
            fetch(url, {
                method: 'DELETE',
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    id: itemId
                })
            })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        document.querySelector(`[data-id='${itemId}']`).closest('.order-card').remove();
                        bootstrap.Modal.getInstance(document.getElementById('deleteOrderModal')).hide();
                        showValid(data.message)
                        itemId = undefined;
                    } else {
                        bootstrap.Modal.getInstance(document.getElementById('deleteOrderModal')).hide();
                        showError(data.message)
                        itemId = undefined;
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Something went wrong.");
                    showError(error + ', Something went wrong.')
                    itemId = undefined;
                });
        });
    </script>

@endsection
