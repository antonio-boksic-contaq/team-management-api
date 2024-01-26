<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectCategoryController;

Route::prefix('project-categories')->group(function () {
  Route::get('/', [ProjectCategoryController::class, 'index']);
  Route::post('/', [ProjectCategoryController::class, 'store']);
    Route::prefix('{projectCategory}')->group(function () {
      Route::get('/', [ProjectCategoryController::class, 'show']);
      Route::delete('/', [ProjectCategoryController::class, 'delete']);
      Route::put('/', [ProjectCategoryController::class, 'update']);
      Route::put('/restore', [ProjectCategoryController::class, 'restore']);
    });
});