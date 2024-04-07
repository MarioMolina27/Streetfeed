<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdressController;
use App\Http\Controllers\Api\MarkerController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\ScheduleController;
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
Route::get('users/getUsersNums', [UserController::class, 'getUsersNums']);
Route::get('delivery/totalKg', [DeliveryController::class, 'calculateDeliveryKg']);
Route::get('users/evolutionUsers/{idUser}', [UserController::class, 'getNumUsersByMonth']);
Route::get('delivery/deliveryNumbers', [DeliveryController::class, 'getDeliveriesByMonth']);
Route::get('adress/numberAdress/{type_user}', [AdressController::class, 'getAdreesNumbers']);
Route::get('users/numberUsersByType/{typeUser}', [UserController::class, 'getNumUsersByType']);
Route::get('delivery/getTotalDeliveries', [DeliveryController::class, 'getTotalDeliveries']);
Route::get('markers/all', [MarkerController::class, 'getAllMarkers']);
Route::get('markers/markersByUser/{id}', [MarkerController::class, 'getMarkersCreatedByUser']);
Route::get('delivery/getDeliveriesByUser/{id}', [DeliveryController::class, 'getNumDeliveriesByUser']);
Route::get('delivery/getDeliveriesByKgUser/{id}', [DeliveryController::class, 'getDeliveriesByKgUser']);
Route::get('schedule/getScheduleByUser/{user}', [ScheduleController::class, 'getScheduleByUser']);
Route::get('adress/getAdressesByUser/{user}', [AdressController::class, 'getAdressesByUser']);
Route::post('users/updateUser', [UserController::class, 'updateUserData']);
Route::get('adress/getTypeRoad', [AdressController::class, 'getTypeRoad']);

Route::apiResource('users', UserController::class);
Route::get('users/get-provider/{nickname}/{user}', [UserController::class, 'getProviderByNick']);
Route::get('users/near-providers/{user}', [UserController::class, 'getMoreNearProviders']);
Route::get('users/has-more-favourites-providers/{user}', [UserController::class, 'getBetterProviders']);
Route::get('users/favourite-providers/{user}', [UserController::class, 'getFavouritesProviders']);
Route::get('users/reserve-data/{user}/{menuid}', [UserController::class, 'reserveMarkers']);
Route::post('users/toggle-favorite-provider', [UserController::class, 'toggleFavoriteProvider']);
Route::post('users/reactivate/{user}', [UserController::class, 'reactivate']);
Route::post('delivery/do-reserve', [DeliveryController::class, 'doReserve']);
Route::get('users/do-suggest/{latitude}/{longitude}', [UserController::class, 'doSuggest']);
Route::get('delivery/get-user-deliveries/{user}', [DeliveryController::class, 'getUserDeliveries']);
Route::post('delivery/do-suggest-reserve', [DeliveryController::class, 'doSuggestReserve']);
Route::post('delivery/do-collect', [DeliveryController::class, 'doCollect']);
Route::post('delivery/do-deliver', [DeliveryController::class, 'doDeliver']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
