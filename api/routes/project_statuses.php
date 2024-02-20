<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectStatusController;

Route::prefix('project-statuses')->group(function () {
  Route::group(['middleware' => ['role:Supervisore']], function () {
    Route::get('/', [ProjectStatusController::class, 'index']);
    Route::post('/', [ProjectStatusController::class, 'store']);
      Route::prefix('{projectStatus}')->group(function () {
        Route::get('/', [ProjectStatusController::class, 'show']);
        Route::delete('/', [ProjectStatusController::class, 'delete']);
        Route::put('/', [ProjectStatusController::class, 'update']);
        Route::put('/restore', [ProjectStatusController::class, 'restore']);
      });
  });
});