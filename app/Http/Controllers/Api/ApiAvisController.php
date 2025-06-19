<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Avis;

class ApiAvisController extends Controller
{
    /**
     * Retourne les avis laissés par un utilisateur, avec nom du restaurant et auteur.
     */
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
}
