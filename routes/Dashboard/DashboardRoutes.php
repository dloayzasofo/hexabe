<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\DashboardController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('dashboard.index');
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
