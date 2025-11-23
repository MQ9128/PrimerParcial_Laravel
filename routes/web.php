<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Web\CategoryWebController;
use App\Http\Controllers\Web\CarWebController;

// Ruta raíz - Redirige al dashboard si está autenticado, sino al login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Rutas de Categorías
    Route::get('/categories', [CategoryWebController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryWebController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryWebController::class, 'store'])->name('categories.web.store');
    Route::get('/categories/{category}', [CategoryWebController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryWebController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryWebController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryWebController::class, 'destroy'])->name('categories.destroy');

    // Rutas de Carros
    Route::get('/cars', [CarWebController::class, 'index'])->name('cars.index');
    Route::get('/cars/create', [CarWebController::class, 'create'])->name('cars.create');
    Route::post('/cars', [CarWebController::class, 'store'])->name('cars.store');
    Route::get('/cars/{car}', [CarWebController::class, 'show'])->name('cars.show');
    Route::get('/cars/{car}/edit', [CarWebController::class, 'edit'])->name('cars.edit');
    Route::put('/cars/{car}', [CarWebController::class, 'update'])->name('cars.update');
    Route::delete('/cars/{car}', [CarWebController::class, 'destroy'])->name('cars.destroy');
});