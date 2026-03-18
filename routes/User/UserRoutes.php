<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('user.index');
        /*
    Route::get('/create', [BrandController::class, 'create'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('brand.create');
    Route::post('/create', [BrandController::class, 'save'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('brand.save');
    Route::get('/view/{brand}', [BrandController::class, 'view'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('brand.view');
        */
});
