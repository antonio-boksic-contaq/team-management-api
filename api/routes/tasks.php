<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::prefix('tasks')->group(function () {
    Route::group(['middleware' => ['role:Supervisore|Collaboratore']], function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/', [TaskController::class, 'store']);
        
        Route::prefix('{task}')->group(function () {
            Route::get('/', [TaskController::class, 'show']);
            Route::delete('/', [TaskController::class, 'delete']);
            Route::put('/', [TaskController::class, 'update']);
            Route::put('/restore', [TaskController::class, 'restore']);
        });
    });

    Route::group(['middleware' => ['role:Supervisore|Collaboratore']], function () {
      Route::put('{task}/change_status', [TaskController::class, 'change_status']);
    });
});