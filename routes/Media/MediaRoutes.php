<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Media\MediaController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::prefix('media')->group(function () {
    Route::post('/upload', [MediaController::class, 'save'])
        ->name('media.upload');

    Route::post('/delete', [MediaController::class, 'delete'])
        ->name('media.delete');
});
