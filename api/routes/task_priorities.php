<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskPriorityController;

Route::prefix('task-priorities')->group(function () {
  Route::group(['middleware' => ['role:Supervisore']], function () {
    Route::get('/', [TaskPriorityController::class, 'index']);
    Route::post('/', [TaskPriorityController::class, 'store']);
      Route::prefix('{taskPriority}')->group(function () {
        Route::get('/', [TaskPriorityController::class, 'show']);
        Route::delete('/', [TaskPriorityController::class, 'delete']);
        Route::put('/', [TaskPriorityController::class, 'update']);
        Route::put('/restore', [TaskPriorityController::class, 'restore']);
      });
  });
});