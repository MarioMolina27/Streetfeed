<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResource('users', UserController::class);
Route::get('users/get-provider/{nickname}/{user}', [UserController::class, 'getProviderByNick']);
Route::get('users/near-providers/{user}', [UserController::class, 'getMoreNearProviders']);
Route::get('users/has-more-favourites-providers/{user}', [UserController::class, 'getBetterProviders']);
Route::get('users/favourite-providers/{user}', [UserController::class, 'getFavouritesProviders']);
Route::get('users/reserve-data/{user}/{menuid}', [UserController::class, 'reserveMarkers']);
Route::post('users/toggle-favorite-provider', [UserController::class, 'toggleFavoriteProvider']);
Route::post('users/reactivate/{user}', [UserController::class, 'reactivate']);
Route::post('delivery/do-reserve', [DeliveryController::class, 'doReserve']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
