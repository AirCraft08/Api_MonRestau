<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestaurantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');

// 🍽️ Liste des restaurants
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');


// ➕ Créer un restaurant (accessible uniquement si connecté)
Route::middleware(['auth'])->group(function () {
    Route::get('/restaurants/create', [RestaurantController::class, 'create'])->name('restaurants.create');
    Route::post('/restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');
});

// 🔎 Détails d’un restaurant
Route::get('/restaurants/{id}', [RestaurantController::class, 'show'])->name('restaurants.show');

// 🔐 Authentification Laravel UI (générée avec --auth)
Auth::routes();
