<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Avis;
use Illuminate\Http\Request;

class ApiAvisController extends Controller
{
    public function getAvisByUserId($userId)
    {
        $avis = Avis::with(['user', 'restaurant'])
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($a) {
                return [
                    'id' => $a->id,
                    'note' => $a->note,
                    'commentaire' => $a->commentaire,
                    'auteur' => $a->user ? $a->user->name : 'Anonyme',
                    'restaurant_nom' => $a->restaurant ? $a->restaurant->nom : 'Inconnu',
                    'created_at' => $a->created_at ? $a->created_at->diffForHumans() : '',
                ];
            });

        return response()->json($avis);
    }

    public function update(Request $request, $id)
    {
        $avis = Avis::findOrFail($id);

        $validated = $request->validate([
            'note' => 'required|integer|min:1|max:5',
            'commentaire' => 'nullable|string',
        ]);

        $avis->update($validated);

        return response()->json([
            'message' => 'Avis mis à jour avec succès',
            'avis' => $avis,
        ]);
    }
}
