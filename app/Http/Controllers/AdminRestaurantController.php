<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminRestaurantController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();
        return view('admin.restaurants.index', compact('restaurants'));
    }

}
