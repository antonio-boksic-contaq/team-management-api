<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectApplicantController;

Route::prefix('project-applicants')->group(function () {
  Route::group(['middleware' => ['role:Supervisore']], function () {
    Route::get('/', [ProjectApplicantController::class, 'index']);
    Route::post('/', [ProjectApplicantController::class, 'store']);
      Route::prefix('{projectApplicant}')->group(function () {
        Route::get('/', [ProjectApplicantController::class, 'show']);
        Route::delete('/', [ProjectApplicantController::class, 'delete']);
        Route::put('/', [ProjectApplicantController::class, 'update']);
        Route::put('/restore', [ProjectApplicantController::class, 'restore']);
      }); 
  });
});