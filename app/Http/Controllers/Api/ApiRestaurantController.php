<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;

class ApiRestaurantController extends Controller
{
    /**
     * Retourne les restaurants créés par un utilisateur donné.
     */
    public function getRestaurantsByUserId($userId)
    {
        $restaurants = Restaurant::where('user_id', $userId)->get();

        return response()->json($restaurants);
    }
}
