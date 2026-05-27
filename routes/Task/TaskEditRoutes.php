<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task\TaskEditController;
use App\Http\Controllers\Task\TaskUserController;
use App\Http\Controllers\Task\KanbanController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::middleware(['auth'])->prefix('task/api')->group(function () {

    Route::post('/edit/status/{task}', [TaskEditController::class, 'status'])
        ->name('task.api.edit.status');

    Route::post('/edit/priority/{task}', [TaskEditController::class, 'priority'])
        ->name('task.api.edit.priority');

    Route::post('/edit/title/{task}', [TaskEditController::class, 'title'])
        ->name('task.api.edit.title');

    Route::post('/edit/brand/{task}', [TaskEditController::class, 'brand'])
        ->name('task.api.edit.brand');

    Route::post('/edit/user/{task}', [TaskEditController::class, 'user'])
        ->name('task.api.edit.user');

    Route::post('/edit/date/{task}', [TaskEditController::class, 'date_delivery'])
        ->name('task.api.edit.date');

    Route::post('/edit/dependency/{task}/{dependency}', [TaskEditController::class, 'add_dependency'])
        ->name('task.api.edit.dependency');

    Route::delete('/edit/dependency/{task}/{dependency}', [TaskEditController::class, 'delete_dependency'])
        ->name('task.api.delete.dependency');
});