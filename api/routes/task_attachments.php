<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskAttachmentController;

Route::prefix('task-attachments')->group(function () {
  Route::group(['middleware' => ['role:Supervisore|Collaboratore']], function () {
    Route::get('/', [TaskAttachmentController::class, 'index']);
    Route::post('/', [TaskAttachmentController::class, 'store']);
    
      Route::prefix('{taskAttachment}')->group(function () {
        Route::get('/', [TaskAttachmentController::class, 'show']);
        Route::get('/download', [TaskAttachmentController::class, 'download']);
        Route::delete('/', [TaskAttachmentController::class, 'destroy']);
        Route::put('/', [TaskAttachmentController::class, 'update']);
      });
  });
});