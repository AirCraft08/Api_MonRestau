<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;

class RestaurantApiController extends Controller
{
    // GET /api/restaurants — Liste de tous les restaurants (simple)
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

    // GET /api/restaurants/{id} — Détails + avis
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
    
}
