<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiRestaurantController;
use App\Http\Controllers\Api\ApiAvisController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Ces routes seront automatiquement préfixées par 'api/' et n'auront pas de CSRF
Route::get('/restaurants', [ApiRestaurantController::class, 'index']);
Route::get('/restaurants/{id}', [ApiRestaurantController::class, 'show']);
Route::put('/restaurants/{id}', [ApiRestaurantController::class, 'update']);
Route::get('/utilisateur/{userId}/restaurants', [ApiRestaurantController::class, 'getRestaurantsByUserId']);

Route::get('/utilisateur/{userId}/avis', [ApiAvisController::class, 'getAvisByUserId']);
Route::put('/avis/{id}', [ApiAvisController::class, 'update']);

Route::get('/test', function () {
    return response()->json(['message' => 'API fonctionne']);
});

// Si vous avez besoin d'authentification pour certaines routes
Route::middleware('auth:sanctum')->group(function () {
    // Ici vous pouvez mettre les routes qui nécessitent une authentification
    // Route::post('/restaurants', [ApiRestaurantController::class, 'store']);
    // Route::delete('/restaurants/{id}', [ApiRestaurantController::class, 'destroy']);
});