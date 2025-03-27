<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Avis;

class UserController extends Controller
{
    /**
     * Afficher le profil de l'utilisateur.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        // Récupérer l'utilisateur authentifié
        $user = auth()->user();

        // Récupérer les restaurants de l'utilisateur, ou une collection vide s'il n'en a pas
        $restaurants = $user->restaurants ?? collect();

        // Récupérer les avis laissés par l'utilisateur, ou une collection vide s'il n'en a pas
        $avis = $user->avis ?? collect();

        // Retourner la vue avec les données de l'utilisateur, des restaurants et des avis
        return view('profile.show', compact('user', 'restaurants', 'avis'));
    }

    /**
     * Mettre à jour les informations du profil de l'utilisateur.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
            'password' => 'nullable|confirmed|min:8',
        ]);

        // Récupérer l'utilisateur authentifié
        $user = auth()->user();

        // Mettre à jour les informations de l'utilisateur
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        if ($request->filled('password')) {
            // Si un nouveau mot de passe est fourni, le hasher et le mettre à jour
            $user->password = bcrypt($validatedData['password']);
        }

        // Sauvegarder les modifications
        $user->save();

        // Rediriger vers le profil avec un message de succès
        return redirect()->route('user.show')->with('success', 'Profil mis à jour avec succès!');
    }
}
