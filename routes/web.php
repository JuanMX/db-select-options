<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DBSelectOptionsController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix(env('DB_TABLE_SELECT_OPTIONS_ENDS_WITH'))->group(function () {
    Route::get('/{DBSelectOptions}', [DBSelectOptionsController::class, 'index']);
    Route::post('/create', [DBSelectOptionsController::class, 'create']);
    Route::patch('/update', [DBSelectOptionsController::class, 'update']);
    Route::post('/read', [DBSelectOptionsController::class, 'read']);
    Route::delete('/delete', [DBSelectOptionsController::class, 'delete']);
});