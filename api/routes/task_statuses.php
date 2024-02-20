<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskStatusController;

Route::prefix('task-statuses')->group(function () {
  Route::group(['middleware' => ['role:Supervisore']], function () {
    Route::get('/', [TaskStatusController::class, 'index']);
    Route::post('/', [TaskStatusController::class, 'store']);
      Route::prefix('{taskStatus}')->group(function () {
        Route::get('/', [TaskStatusController::class, 'show']);
        Route::delete('/', [TaskStatusController::class, 'delete']);
        Route::put('/', [TaskStatusController::class, 'update']);
        Route::put('/restore', [TaskStatusController::class, 'restore']);
      });
  });
});