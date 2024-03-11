<?php

use App\Http\Controllers\{LoginController, AuthController};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('/auth')->group(function () {
  Route::post('/login', [LoginController::class, 'login']);
  Route::post('/password-recovery', [LoginController::class, 'passwordRecovery']);
  /* testing auth */
  Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/user', AuthController::class);
  });
});