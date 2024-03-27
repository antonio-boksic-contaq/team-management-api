<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleAndPermissionController;

Route::prefix('roles')->group(function () {
  Route::get('/', [RoleAndPermissionController::class, 'all']);
});