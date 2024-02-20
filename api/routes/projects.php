<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::prefix('projects')->group(function () {
  Route::group(['middleware' => ['role:Supervisore']], function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::post('/', [ProjectController::class, 'store']);
      Route::prefix('{project}')->group(function () {
        Route::get('/', [ProjectController::class, 'show']);
        Route::delete('/', [ProjectController::class, 'delete']);
        Route::put('/', [ProjectController::class, 'update']);
        Route::put('/restore', [ProjectController::class, 'restore']);
      });
  });
});