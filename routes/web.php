<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\LanguageController;


//---------------------LANDING--------------------------------
Route::get('/', function () {
    return view('landings.landing');
});
//----------------------------------------------------------------


//-----------------------AUTH--------------------------------
Route::get('login', function () {
    return view('auth.login');
});

Route::post('users/login', [UserController::class, 'login']);
//----------------------------------------------------------------


//-----------------------ADMIN--------------------------------
Route::get('admin', function () {
    return view('admin.home');
});

Route::get('admin/users', function () {
    return view('admin.admin');
})->name('mainAdmin');

Route::get('admin/stadistics/providers', function () {
    return view('admin.stadisticsProvider');
});

Route::get('admin/stadistics/riders', function () {
    return view('admin.stadisticsRiders');
});

Route::get('admin/map', function () {
    return view('admin.mapAdmin');
});
//----------------------------------------------------------------


//-----------------------RIDERS--------------------------------
Route::get('delivery', function () {
    $lang = request()->cookie('lang', 'es');
    return view('riders.delivery.delivery', compact('lang'));
});

Route::get('explore', function () {
    $lang = request()->cookie('lang', 'es');
    return view('riders.explore.explore', compact('lang'));
});

Route::get('details/{nickname}', function ($nickname) {
    $lang = request()->cookie('lang', 'es');
    return view('riders.explore.details', ['nickname' => $nickname], compact('lang'));
});

Route::get('assignreserve/{encodedMenuId}', function ($encodedMenuId) {
    $lang = request()->cookie('lang', 'es');
    $menusjson = json_decode(base64_decode($encodedMenuId));
    return view('riders.explore.assignreserve', ['menusjson' => $menusjson], compact('lang'));
});

Route::get('confirmation/{encodedHomelessData}', function ($encodedHomelessData) {
    $lang = request()->cookie('lang', 'es');
    $decodedData = base64_decode($encodedHomelessData);
    $decodedData = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $decodedData);
    $datareserve = json_decode($decodedData);
    return view('riders.explore.reserveconfirm', ['datareserve' => $datareserve], compact('lang'));
});

Route::get('favorite', function () {
    $lang = request()->cookie('lang', 'es');
    return view('riders.favorite.favorite', compact('lang'));
});
//----------------------------------------------------------------


//-----------------------PROVIDERS--------------------------------
Route::get('managedelivery', function () {
    $lang = request()->cookie('lang', 'es');
    return view('providers.manage_delivery.manage_delivery', compact('lang'));
});

Route::get('menu', function () {
    $lang = request()->cookie('lang', 'es');
    return view('providers.manage_menu.manage_menu', compact('lang'));
});
//----------------------------------------------------------------


//-----------------------SHARED--------------------------------
Route::get('profile', function () {
    return view('shared.profile');
});
//----------------------------------------------------------------


//-----------------------LANGUAGES--------------------------------
Route::get('set-language/{lang}', [LanguageController::class,'setLanguage'])->name('set.language');
//----------------------------------------------------------------