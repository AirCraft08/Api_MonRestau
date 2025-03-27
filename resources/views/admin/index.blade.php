@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <!-- Titre principal de la page admin -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="text-center">Tableau de bord Admin</h2>
                <p class="text-center">Gérez les restaurants et les avis depuis cette page.</p>
            </div>
        </div>

        <!-- Section Restaurants -->
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
                                        <a href="{{ route('admin.restaurant.edit', $restaurant->id) }}" class="btn btn-warning btn-sm">Modifier</a>
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

        <!-- Section Avis -->
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
                                        <a href="{{ route('admin.avis.edit', $a->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                                        <form action="{{ route('admin.avis.delete', $a->id) }}" method="POST" style="display:inline;">
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

    </div>
@endsection
