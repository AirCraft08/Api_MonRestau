<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;
use App\Models\Avis;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $restaurants = Restaurant::where('user_id', $user->id)->get();
        $avis = Avis::where('user_id', $user->id)->get();

        return view('profile.show', compact('user', 'restaurants', 'avis'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return back()->with('success', 'Vos informations ont été mises à jour.');
    }

    public function destroyRestaurant($id)
    {
        $restaurant = Restaurant::findOrFail($id);

        // Vérifie si l'utilisateur est le créateur du restaurant
        if ($restaurant->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Supprime le restaurant
        $restaurant->delete();

        return back()->with('success', 'Restaurant supprimé avec succès.');
    }

    public function destroyAvis($id)
    {
        $avis = Avis::findOrFail($id);

        // Vérifie si l'avis appartient à l'utilisateur
        if ($avis->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Supprime l'avis
        $avis->delete();

        return back()->with('success', 'Avis supprimé avec succès.');
    }


}
