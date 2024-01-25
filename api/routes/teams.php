<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;

Route::prefix('teams')->group(function () {
  Route::get('/', [TeamController::class, 'index']);
  Route::post('/', [TeamController::class, 'store']);
    Route::prefix('{team}')->group(function () {
      Route::get('/', [TeamController::class, 'show']);
      Route::delete('/', [TeamController::class, 'delete']);
      Route::put('/', [TeamController::class, 'update']);
      Route::put('/restore', [TeamController::class, 'restore']);
    });
});