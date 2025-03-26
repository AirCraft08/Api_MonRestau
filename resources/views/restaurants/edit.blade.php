<div class="container">
    <h2>Modifier le restaurant : {{ $restaurant->nom }}</h2>

    <form method="POST" action="{{ route('restaurants.update', $restaurant->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="{{ $restaurant->nom }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" required>{{ $restaurant->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="prix_moyen" class="form-label">Prix moyen</label>
            <input type="number" class="form-control" id="prix_moyen" name="prix_moyen" value="{{ $restaurant->prix_moyen }}" required>
        </div>

        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="number" step="0.000001" class="form-control" id="latitude" name="latitude" value="{{ $restaurant->latitude }}" required>
        </div>

        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="number" step="0.000001" class="form-control" id="longitude" name="longitude" value="{{ $restaurant->longitude }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Sauvegarder</button>
    </form>

    <form method="POST" action="{{ route('restaurants.destroy', $restaurant->id) }}" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Supprimer le restaurant</button>
    </form>
</div>
