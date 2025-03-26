<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Avis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    // Afficher tous les restaurants avec la note moyenne
    public function index()
    {
        $restaurants = Restaurant::with('avis') // Charger les avis avec chaque restaurant
        ->get()
            ->map(function($restaurant) {
                // Calcul de la note moyenne
                $restaurant->moyenne_note = $restaurant->avis->avg('note');
                return $restaurant;
            });

        return view('restaurants.index', compact('restaurants'));
    }

    // Afficher les détails d'un restaurant
    public function show($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('restaurants.show', compact('restaurant'));
    }

    // Afficher le formulaire de création du restaurant
    public function create(): \Illuminate\View\View
    {
        return view('restaurants.create');
    }

    // Enregistrer un restaurant dans la base de données
    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'date_ouverture' => 'required|date',
            'prix_moyen' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'contact_nom' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'photo' => 'nullable|image|max:2048', // Ou validation si tu utilises une image
        ]);

        // Créer un nouveau restaurant
        $restaurant = new Restaurant();
        $restaurant->nom = $request->nom;
        $restaurant->description = $request->description;
        $restaurant->date_ouverture = $request->date_ouverture;
        $restaurant->prix_moyen = $request->prix_moyen;
        $restaurant->latitude = $request->latitude;
        $restaurant->longitude = $request->longitude;
        $restaurant->contact_nom = $request->contact_nom;
        $restaurant->contact_email = $request->contact_email;
        $restaurant->photo = $request->photo;

        // Associer l'utilisateur actuellement connecté
        $restaurant->user_id = Auth::id(); // Ajoute l'ID de l'utilisateur connecté

        $restaurant->save(); // Sauvegarde le restaurant

        return redirect()->route('restaurants.index')->with('success', 'Restaurant créé avec succès.');
    }

    // Afficher le formulaire de modification d'un restaurant
    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);

        // Vérifie si l'utilisateur est le créateur du restaurant
        if ($restaurant->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('restaurants.edit', compact('restaurant'));
    }

    // Mettre à jour un restaurant dans la base de données
    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);

        // Vérifie si l'utilisateur est le créateur du restaurant
        if ($restaurant->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Valide les données du formulaire
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix_moyen' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Met à jour le restaurant
        $restaurant->update($request->all());

        return redirect()->route('restaurants.index')->with('success', 'Restaurant modifié avec succès.');
    }

    // Supprimer un restaurant de la base de données
    public function destroy($id)
    {
        $restaurant = Restaurant::findOrFail($id);

        // Vérifie si l'utilisateur est le créateur du restaurant
        if ($restaurant->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Supprime le restaurant
        $restaurant->delete();

        return redirect()->route('restaurants.index')->with('success', 'Restaurant supprimé avec succès.');
    }
}
