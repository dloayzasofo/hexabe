<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\ReportController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::middleware(['auth'])->prefix('report')->group(function () {
    Route::get('/performance', [ReportController::class, 'index'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('report.index');

    Route::get('/performance/list', [ReportController::class, 'listWork'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('report.list');
});