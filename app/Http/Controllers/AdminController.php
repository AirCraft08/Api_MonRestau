<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Avis;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Constructeur pour vérifier si l'utilisateur est un administrateur
    public function __construct()
    {
        $this->middleware('role:admin'); // On utilise un middleware pour vérifier le rôle
    }

    /**
     * Afficher tous les restaurants et avis.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $restaurants = Restaurant::all();
        $avis = Avis::all();

        return view('admin.index', compact('restaurants', 'avis'));
    }

    /**
     * Modifier un restaurant.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\View\View
     */
    public function editRestaurant(Restaurant $restaurant)
    {
        return view('admin.editRestaurant', compact('restaurant'));
    }

    /**
     * Mettre à jour un restaurant.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRestaurant(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $restaurant->nom = $request->input('nom');
        $restaurant->description = $request->input('description');
        $restaurant->save();

        return redirect()->route('admin.index')->with('success', 'Restaurant mis à jour avec succès.');
    }

    /**
     * Supprimer un restaurant.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteRestaurant(Restaurant $restaurant)
    {
        $restaurant->delete();

        return redirect()->route('admin.index')->with('success', 'Restaurant supprimé avec succès.');
    }

    /**
     * Modifier un avis.
     *
     * @param  \App\Models\Avis  $avis
     * @return \Illuminate\View\View
     */
    public function editAvis(Avis $avis)
    {
        return view('admin.editAvis', compact('avis'));
    }

    /**
     * Mettre à jour un avis.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Avis  $avis
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateAvis(Request $request, Avis $avis)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
        ]);

        $avis->note = $request->input('note');
        $avis->commentaire = $request->input('commentaire');
        $avis->save();

        return redirect()->route('admin.index')->with('success', 'Avis mis à jour avec succès.');
    }

    /**
     * Supprimer un avis.
     *
     * @param  \App\Models\Avis  $avis
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteAvis(Avis $avis)
    {
        $avis->delete();

        return redirect()->route('admin.index')->with('success', 'Avis supprimé avec succès.');
    }
}
