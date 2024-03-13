<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('layouts.layout');
});

Route::get('admin/users', function () {
    return view('admin.admin');
});

Route::get('menu', function () {
    return view('providers.menu');
});
Route::get('delivery', function () {
    return view('riders.delivery');
});
Route::get('details/{nickname}', function ($nickname) {
    return view('riders.details', ['nickname' => $nickname]);
});
Route::get('assignreserve/{encodedMenuId}', function ($encodedMenuId) {
    $menusjson = json_decode(base64_decode($encodedMenuId));
    return view('riders.assignreserve', ['menusjson' => $menusjson]);
});
Route::get('confirmation/{encodedHomelessData}', function ($encodedHomelessData) {
    $decodedData = base64_decode($encodedHomelessData);
    $decodedData = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $decodedData);
    $datareserve = json_decode($decodedData);
    $datareserve;
    return view('riders.reserveconfirm', ['datareserve' => $datareserve]);
});
Route::get('riderlanding', function () {
    return view('landings.riderlanding');
});
Route::get('providerlanding', function () {
    return view('landings.providerlanding');
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