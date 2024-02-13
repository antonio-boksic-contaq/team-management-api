<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectAttachmentController;

Route::prefix('project-attachments')->group(function () {
  Route::get('/', [ProjectAttachmentController::class, 'index']);
  Route::post('/', [ProjectAttachmentController::class, 'store']);
    Route::prefix('{projectAttachment}')->group(function () {
      Route::get('/', [ProjectAttachmentController::class, 'show']);
      Route::delete('/', [ProjectAttachmentController::class, 'destroy']);
      Route::put('/', [ProjectAttachmentController::class, 'update']);
    });
});