<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('layouts.layout');
});

Route::get('admin', function () {
    return view('admin.admin');
});
Route::get('menu', function () {
    return view('providers.menu');
});
Route::get('delivery', function () {
    return view('riders.delivery');
});
Route::get('details/{encodedProvider}', function ($encodedProvider) {
    $provider = json_decode(base64_decode($encodedProvider));
    return view('riders.details', ['provider' => $provider]);
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