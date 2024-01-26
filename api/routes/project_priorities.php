<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectPriorityController;

Route::prefix('project-priorities')->group(function () {
  Route::get('/', [ProjectPriorityController::class, 'index']);
  Route::post('/', [ProjectPriorityController::class, 'store']);
    Route::prefix('{projectPriority}')->group(function () {
      Route::get('/', [ProjectPriorityController::class, 'show']);
      Route::delete('/', [ProjectPriorityController::class, 'delete']);
      Route::put('/', [ProjectPriorityController::class, 'update']);
      Route::put('/restore', [ProjectPriorityController::class, 'restore']);
    });
});