<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API funcionando 🚀']);
});

Route::apiResource('cars', CarController::class);