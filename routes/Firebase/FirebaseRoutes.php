<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Firebase\FirebaseController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::middleware(['auth'])->prefix('notification')->group(function () {
    Route::post('/save', [FirebaseController::class, 'save'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('firebase.save');

    Route::post('/delete', [FirebaseController::class, 'delete'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('firebase.delete');
});