<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\Task\KanbanController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::prefix('task')->group(function () {
    Route::get('/', [TaskController::class, 'index'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('task.index');
    Route::get('/create', [TaskController::class, 'create'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('task.create');

    Route::post('/create', [TaskController::class, 'save'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('task.save');

    Route::post('/finish/{task}', [TaskController::class, 'finish'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('task.finish');

    Route::get('/subtask/{task}', [TaskController::class, 'subtask'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('task.subtask');

    Route::get('/edit/{task}', [TaskController::class, 'edit'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('task.edit');
    Route::post('/edit/{task}', [TaskController::class, 'update'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('task.update');

    Route::get('/view/{task}', [TaskController::class, 'view'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('task.view');

    Route::get('/kanban', [KanbanController::class, 'index'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('kanban.index');
});
