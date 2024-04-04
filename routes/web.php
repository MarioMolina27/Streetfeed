<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('landings.landing');
});

Route::get('admin/users', function () {
    return view('admin.admin');
});

Route::get('menu', function () {
    return view('providers.menu');
});
Route::get('delivery', function () {
    return view('riders.delivery.delivery');
});
Route::get('explore', function () {
    return view('riders.explore.explore');
});
Route::get('details/{nickname}', function ($nickname) {
    return view('riders.explore.details', ['nickname' => $nickname]);
});
Route::get('assignreserve/{encodedMenuId}', function ($encodedMenuId) {
    $menusjson = json_decode(base64_decode($encodedMenuId));
    return view('riders.explore.assignreserve', ['menusjson' => $menusjson]);
});
Route::get('confirmation/{encodedHomelessData}', function ($encodedHomelessData) {
    $decodedData = base64_decode($encodedHomelessData);
    $decodedData = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $decodedData);
    $datareserve = json_decode($decodedData);
    return view('riders.explore.reserveconfirm', ['datareserve' => $datareserve]);
});
Route::get('favorite', function () {
    return view('riders.favorite.favorite');
});
Route::get('profile', function () {
    return view('shared.profile');
});
Route::get('login', function () {
    return view('auth.login');
});
Route::get('register', function () {
    return view('auth.register');
});

Route::get('admin', function () {
    return view('admin.home');
});

Route::get('admin/stadistics/providers', function () {
    return view('admin.stadisticsProvider');
});

Route::get('admin/stadistics/riders', function () {
    return view('admin.stadisticsRiders');
});

Route::get('admin/map', function () {
    return view('admin.mapAdmin');
});