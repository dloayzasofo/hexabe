<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Notification\NotificationController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::middleware(['auth'])->prefix('notification')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('notification.index');

    Route::post('/read', [NotificationController::class, 'read'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('notification.read');
});