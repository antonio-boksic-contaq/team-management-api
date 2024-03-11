<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::prefix('users')->group(function () {

    Route::get('/', [UserController::class, 'index']);
    Route::get('/export', [UserController::class, 'export']);
    Route::post('/', [UserController::class, 'store']);
      Route::prefix('{user}')->group(function () {
        Route::get('/', [UserController::class, 'show']);
        Route::delete('/', [UserController::class, 'delete']);
        Route::put('/', [UserController::class, 'update']);
        Route::put('/restore', [UserController::class, 'restore']);
        Route::put('/send-password', [UserController::class, 'sendPassword']);
        Route::put('/update-password', [UserController::class, 'updatePassword']);
      });

});