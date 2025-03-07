<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('select-options/campuses-select-options', function () {
    return view('db-select-options');
});