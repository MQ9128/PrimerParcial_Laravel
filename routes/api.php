<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CategoryController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API funcionando 🚀']);
});

//Route::apiResource('cars', CarController::class);
//Route::apiResource('categories', CategoryController::class);

Route::get('categories/active-with-cars', [CategoryController::class, 'activeWithCars']);