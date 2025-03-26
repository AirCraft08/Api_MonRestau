<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('index');

// 🍽️ Liste des restaurants
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');

// Carte
Route::get('/carte', [CarteController::class, 'index'])->name('carte.index');

// ➕ Créer un restaurant (accessible uniquement si connecté)
Route::middleware(['auth'])->group(function () {
    Route::get('/restaurants/create', [RestaurantController::class, 'create'])->name('restaurants.create');
    Route::post('/restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');
});

// 🔎 Détails d’un restaurant
Route::get('/restaurants/{id}', [RestaurantController::class, 'show'])->name('restaurants.show');

// Avis d'un restaurant
Route::post('/restaurants/{id}/avis', [AvisController::class, 'store'])->name('avis.store')->middleware('auth');

// 🔐 Authentification Laravel UI (générée avec --auth)
Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Modifier un restaurant
    Route::get('/restaurants/{id}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');
    Route::put('/restaurants/{id}', [RestaurantController::class, 'update'])->name('restaurants.update');

    // Supprimer un restaurant
    Route::delete('/restaurants/{id}', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Page de profil de l'utilisateur
    Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
});


Route::middleware(['auth'])->group(function () {
    // Supprimer un restaurant
    Route::delete('/profile/restaurant/{id}', [UserController::class, 'destroyRestaurant'])->name('profile.destroyRestaurant');

    // Supprimer un avis
    Route::delete('/profile/avis/{id}', [UserController::class, 'destroyAvis'])->name('profile.destroyAvis');
});
