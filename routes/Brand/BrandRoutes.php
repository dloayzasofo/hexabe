<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Brand\BrandController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::prefix('brand')->group(function () {
    Route::get('/', [BrandController::class, 'index'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('brand.index');
    Route::get('/create', [BrandController::class, 'create'])->name('brand.create');
    Route::post('/create', [BrandController::class, 'save'])->name('brand.save');
});
