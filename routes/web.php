<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('layouts.layout');
});

Route::get('admin', function () {
    return view('admin.admin');
});