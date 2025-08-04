<?php

use App\Http\Controllers\CostingController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\WorksheetController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    
    // Production monitoring dashboard
    Route::get('/production', [ProductionController::class, 'index'])->name('production.dashboard');
    
    // Resource routes for worksheets
    Route::resource('worksheets', WorksheetController::class);
    
    // Resource routes for costings
    Route::resource('costings', CostingController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
