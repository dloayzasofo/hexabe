<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Setting\PerfilController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::prefix('setting/perfil')->group(function () {
    Route::get('/', [PerfilController::class, 'index'])
        ->name('setting.perfil.index');

    Route::post('/create', [PerfilController::class, 'save'])
        ->name('setting.perfil.save');

    Route::post('/image/upload', [PerfilController::class, 'upload_picture'])
        ->name('setting.perfil.image.upload');

    Route::post('/image/remove', [PerfilController::class, 'remove_picture'])
        ->name('setting.perfil.image.remove');

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
