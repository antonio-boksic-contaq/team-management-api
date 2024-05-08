<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskCommentController;

Route::prefix('task-comments')->group(function () {
  Route::group(['middleware' => ['role:Supervisore|Collaboratore']], function () {
    Route::get('/', [TaskCommentController::class, 'index']);
    Route::post('/', [TaskCommentController::class, 'store']);
    
      Route::prefix('{taskComment}')->group(function () {
        Route::get('/', [TaskCommentController::class, 'show']);
        Route::get('/download', [TaskCommentController::class, 'download']);
        Route::delete('/', [TaskCommentController::class, 'destroy']);
        Route::put('/', [TaskCommentController::class, 'update']);
      });
  });
});