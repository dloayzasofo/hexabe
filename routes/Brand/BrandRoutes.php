<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Brand\BrandController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::prefix('brand')->group(function () {
    Route::get('/', [BrandController::class, 'index'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('brand.index');
        
    Route::get('/create', [BrandController::class, 'create'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('brand.create');
    Route::post('/create', [BrandController::class, 'save'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('brand.save');

    Route::get('/edit/{brand}', [BrandController::class, 'edit'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('brand.edit');
    Route::post('/edit/{brand}', [BrandController::class, 'update'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('brand.update');

    Route::get('/view/{brand}', [BrandController::class, 'view'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('brand.view');

    Route::get('/search-by-key', [BrandController::class, 'search_by_key'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('brand.search-by-key');
});
