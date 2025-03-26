<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class HomeController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        $restaurants = Restaurant::latest()->take(3)->get();
        return view('index', compact('restaurants'));
    }

}
