@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Modifier le restaurant : {{ $restaurant->nom }}</h2>

        <form method="POST" action="{{ route('restaurants.update', $restaurant->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="{{ $restaurant->nom }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $restaurant->description }}</textarea>
            </div>

            <div class="mb-3">
                <label for="prix_moyen" class="form-label">Prix moyen</label>
                <input type="number" class="form-control" id="prix_moyen" name="prix_moyen" value="{{ $restaurant->prix_moyen }}" required>
            </div>

            <div class="mb-3">
                <label for="latitude" class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" value="{{ $restaurant->latitude }}" required>
            </div>

            <div class="mb-3">
                <label for="longitude" class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" value="{{ $restaurant->longitude }}" required>
            </div>

            <div class="mb-3">
                <label for="contact_nom" class="form-label">Nom du contact</label>
                <input type="text" class="form-control" id="contact_nom" name="contact_nom" value="{{ $restaurant->contact_nom }}" required>
            </div>

            <div class="mb-3">
                <label for="contact_email" class="form-label">Email du contact</label>
                <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ $restaurant->contact_email }}" required>
            </div>

            <div class="mb-3">
                <label for="photo" class="form-label">Photo du restaurant</label>
                <input type="file" class="form-control" id="photo" name="photo">
                <small class="form-text text-muted">Laissez vide si vous ne souhaitez pas changer la photo.</small>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>
    </div>
@endsection
