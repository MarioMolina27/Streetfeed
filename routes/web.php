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