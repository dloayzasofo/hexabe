<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Comment\CommentController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::prefix('comment')->group(function () {
    Route::post('/create/{task}', [CommentController::class, 'save'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('comment.save');
    /*
    Route::get('/', [CommentController::class, 'index'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('comment.index');
    Route::get('/create', [CommentController::class, 'create'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('comment.create');
    
    Route::get('/edit/{comment}', [CommentController::class, 'edit'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('comment.edit');
    Route::post('/edit/{comment}', [CommentController::class, 'update'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('comment.update');

    Route::get('/view/{comment}', [CommentController::class, 'view'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('comment.view');
    */
});