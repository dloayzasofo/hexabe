<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Task\TaskSearchController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::middleware(['auth'])->prefix('task/api')->group(function () {

    Route::get('/search', [TaskSearchController::class, 'search'])
        ->name('task.api.search');

});