<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class ApiRestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::with('avis')->get()->map(function ($restaurant) {
            return [
                'id' => $restaurant->id,
                'nom' => $restaurant->nom,
                'description' => $restaurant->description,
                'date_ouverture' => $restaurant->date_ouverture,
                'prix_moyen' => $restaurant->prix_moyen,
                'latitude' => $restaurant->latitude,
                'longitude' => $restaurant->longitude,
                'contact_nom' => $restaurant->contact_nom,
                'contact_email' => $restaurant->contact_email,
                'photo' => $restaurant->photo,
                'moyenne_note' => round($restaurant->avis->avg('note') ?? 0, 1),
            ];
        });

        return response()->json($restaurants);
    }

    public function show($id)
    {
        $restaurant = Restaurant::with(['avis.user'])->findOrFail($id);

        return response()->json([
            'restaurant' => [
                'id' => $restaurant->id,
                'nom' => $restaurant->nom,
                'description' => $restaurant->description,
                'date_ouverture' => $restaurant->date_ouverture,
                'prix_moyen' => $restaurant->prix_moyen,
                'latitude' => $restaurant->latitude,
                'longitude' => $restaurant->longitude,
                'contact_nom' => $restaurant->contact_nom,
                'contact_email' => $restaurant->contact_email,
                'photo' => $restaurant->photo,
                'moyenne_note' => round($restaurant->avis->avg('note') ?? 0, 1),
                'avis' => $restaurant->avis->map(function ($a) {
                    return [
                        'id' => $a->id,
                        'note' => $a->note,
                        'commentaire' => $a->commentaire,
                        'auteur' => $a->user->name ?? 'Anonyme',
                        'created_at' => $a->created_at->diffForHumans(),
                    ];
                }),
            ]
        ]);
    }

    public function getRestaurantsByUserId($userId)
    {
        $restaurants = Restaurant::where('user_id', $userId)->get();

        return response()->json($restaurants);
    }

    public function update(Request $request, $id)
    {
        $restaurant = Restaurant::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'prix_moyen' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'contact_nom' => 'required|string|max:255',
            'contact_email' => 'required|email',
        ]);

        $restaurant->update($validated);

        return response()->json([
            'message' => 'Restaurant mis à jour avec succès',
            'restaurant' => $restaurant,
        ]);
    }
}
