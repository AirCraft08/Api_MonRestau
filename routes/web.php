<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminRestaurantController;
use App\Http\Controllers\AdminController;

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


// restaurants
Route::middleware(['auth'])->group(function () {
    // Route pour afficher le formulaire de modification d'un restaurant
    Route::get('/restaurants/{id}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');
    // Route pour mettre à jour un restaurant
    Route::put('/restaurants/{id}', [RestaurantController::class, 'update'])->name('restaurants.update');
    // Supprimer un restaurant
    Route::delete('/restaurants/{id}/delete', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');
});

//avis
Route::middleware(['auth'])->group(function () {
    // Route pour supprimer un avis
    Route::delete('/avis/{id}/delete', [AvisController::class, 'destroy'])->name('avis.destroy');
});


Route::middleware(['auth'])->group(function () {
    // Page de profil de l'utilisateur
    Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
});



Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/restaurant/{restaurant}/edit', [AdminController::class, 'editRestaurant'])->name('admin.restaurant.edit');
    Route::put('/admin/restaurant/{restaurant}', [AdminController::class, 'updateRestaurant'])->name('admin.restaurant.update');
    Route::delete('/admin/restaurant/{restaurant}', [AdminController::class, 'deleteRestaurant'])->name('admin.restaurant.delete');
    Route::get('/admin/avis/{avis}/edit', [AdminController::class, 'editAvis'])->name('admin.avis.edit');
    Route::put('/admin/avis/{avis}', [AdminController::class, 'updateAvis'])->name('admin.avis.update');
    Route::delete('/admin/avis/{avis}', [AdminController::class, 'deleteAvis'])->name('admin.avis.delete');
});



