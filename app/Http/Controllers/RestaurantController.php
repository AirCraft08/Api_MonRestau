<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    public function create(): \Illuminate\View\View
    {
        return view('restaurants.create');
    }



    public function index(): \Illuminate\View\View
    {
        $restaurants = Restaurant::all(); // ou paginate() si tu veux une pagination
        return view('restaurants.index', compact('restaurants'));
    }

    public function show($id): \Illuminate\View\View
    {
        $restaurant = Restaurant::findOrFail($id);
        return view('restaurants.show', compact('restaurant'));
    }



    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'date_ouverture' => 'required|date',
            'prix_moyen' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'contact_nom' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Sauvegarde du fichier photo
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Restaurant::create($validated);

        return redirect()->route('restaurants.create')->with('success', 'Restaurant ajouté avec succès !');
    }
}
