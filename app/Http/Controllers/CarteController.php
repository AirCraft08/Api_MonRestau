<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;

class CarteController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('carte.index', compact('restaurants'));
    }
}
