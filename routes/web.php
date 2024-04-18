<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\LanguageController;


//---------------------LANDING--------------------------------
Route::get('/', function () {
    $apiKeyOpenAI = env('API_KEY');
    $lang = request()->cookie('lang', 'es');
    $translationFilePath = resource_path("lang" . DIRECTORY_SEPARATOR . "landing" . DIRECTORY_SEPARATOR . "$lang.json");

    $trans = json_decode(file_get_contents($translationFilePath));
    
    return view('landings.landing', compact('lang', 'apiKeyOpenAI', 'trans'));
});
//----------------------------------------------------------------


//-----------------------AUTH--------------------------------
Route::get('login', function () {
    $lang = request()->cookie('lang', 'es');
    return view('auth.login', compact('lang'));
});

Route::post('users/login', [UserController::class, 'login']);
Route::get('logout', [UserController::class, 'logout']);
//----------------------------------------------------------------


//-----------------------ADMIN--------------------------------
Route::get('admin', function () {
    $lang = request()->cookie('lang', 'es');
    return view('admin.home', compact('lang'));
});

Route::get('admin/users', function () {
    $lang = request()->cookie('lang', 'es');
    return view('admin.admin', compact('lang'));
})->name('mainAdmin');

Route::get('admin/stadistics/providers', function () {
    $lang = request()->cookie('lang', 'es');
    return view('admin.stadisticsProvider', compact('lang'));
});

Route::get('admin/stadistics/riders', function () {
    $lang = request()->cookie('lang', 'es');
    return view('admin.stadisticsRiders', compact('lang'));
});

Route::get('admin/map', function () {
    $lang = request()->cookie('lang', 'es');
    return view('admin.mapAdmin', compact('lang'));
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
    $lang = request()->cookie('lang', 'es');
    return view('shared.profile', compact('lang'));
});
//----------------------------------------------------------------


//-----------------------LANGUAGES--------------------------------
Route::get('set-language/{lang}', [LanguageController::class,'setLanguage'])->name('set.language');
//----------------------------------------------------------------