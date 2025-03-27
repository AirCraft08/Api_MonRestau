<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Avis;

class AvisController extends Controller
{
    public function store(Request $request, $restaurant_id)
    {
        $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
        ]);

        Avis::create([
            'user_id' => Auth::id(),
            'restaurant_id' => $restaurant_id,
            'note' => $request->note,
            'commentaire' => $request->commentaire,
        ]);

        return back()->with('success', 'Merci pour votre avis !');
    }

    public function destroy(string $id)
    {
        $avis = Avis::findOrFail($id);
        $avis->delete();

        return back()->with('success', "L'avis à bien été suprimé");
    }

}
