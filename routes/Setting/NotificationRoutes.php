<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Setting\NotificationController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::prefix('setting/notification')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('setting.notification.index');
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
