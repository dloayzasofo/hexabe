<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cron\DelayTasksController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::prefix('cron')->group(function () {
    Route::get('/delay/{token}', [DelayTasksController::class, 'delaytasks'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('cron.delay.task');
});