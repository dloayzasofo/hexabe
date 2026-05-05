<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\ReportGroupController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::middleware(['auth'])->prefix('report/group')->group(function () {
    Route::get('/', [ReportGroupController::class, 'index'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('report.group.index');
    Route::post('/', [ReportGroupController::class, 'report'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('report.group.report');
});