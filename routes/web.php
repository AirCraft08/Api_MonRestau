<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminRestaurantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\ApiRestaurantController;
use App\Http\Controllers\Api\ApiAvisController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('index');

// Liste des restaurants
Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');

// Carte
Route::get('/carte', [CarteController::class, 'index'])->name('carte.index');

// Création restaurant - accessible uniquement si connecté
Route::middleware(['auth'])->group(function () {
    Route::get('/restaurants/create', [RestaurantController::class, 'create'])->name('restaurants.create');
    Route::post('/restaurants', [RestaurantController::class, 'store'])->name('restaurants.store');
});

// Détails d’un restaurant
Route::get('/restaurants/{id}', [RestaurantController::class, 'show'])->name('restaurants.show');

// Ajouter un avis (auth obligatoire)
Route::post('/restaurants/{id}/avis', [AvisController::class, 'store'])->name('avis.store')->middleware('auth');

// Authentification Laravel UI
Auth::routes();

// Modification/Suppression restaurants - connecté uniquement
Route::middleware(['auth'])->group(function () {
    Route::get('/restaurants/{id}/edit', [RestaurantController::class, 'edit'])->name('restaurants.edit');
    Route::put('/restaurants/{id}', [RestaurantController::class, 'update'])->name('restaurants.update');
    Route::delete('/restaurants/{id}/delete', [RestaurantController::class, 'destroy'])->name('restaurants.destroy');
});

// Suppression avis - connecté uniquement
Route::middleware(['auth'])->group(function () {
    Route::delete('/avis/{id}/delete', [AvisController::class, 'destroy'])->name('avis.destroy');
});

// Profil utilisateur
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');
});

// Admin routes - accès admin uniquement
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/restaurant/{restaurant}/edit', [AdminRestaurantController::class, 'editRestaurant'])->name('admin.restaurant.edit');
    Route::put('/admin/restaurant/{restaurant}', [AdminRestaurantController::class, 'updateRestaurant'])->name('admin.restaurant.update');
    Route::delete('/admin/restaurant/{restaurant}', [AdminRestaurantController::class, 'deleteRestaurant'])->name('admin.restaurant.delete');

    Route::get('/admin/avis/{avis}/edit', [AdminController::class, 'editAvis'])->name('admin.avis.edit');
    Route::put('/admin/avis/{avis}', [AdminController::class, 'updateAvis'])->name('admin.avis.update');
    Route::delete('/admin/avis/{avis}', [AdminController::class, 'deleteAvis'])->name('admin.avis.delete');
});

// API routes (pas besoin de csrf ici si tu veux)
Route::prefix('api')->group(function () {
    Route::get('/restaurants', [ApiRestaurantController::class, 'index']);
    Route::get('/restaurants/{id}', [ApiRestaurantController::class, 'show']);
    Route::put('/restaurants/{id}', [ApiRestaurantController::class, 'update']);
    Route::get('/utilisateur/{userId}/restaurants', [ApiRestaurantController::class, 'getRestaurantsByUserId']);

    Route::get('/utilisateur/{userId}/avis', [ApiAvisController::class, 'getAvisByUserId']);
    Route::put('/avis/{id}', [ApiAvisController::class, 'update']);

    Route::get('/test', function () {
        return response()->json(['message' => 'API fonctionne']);
    });
});
