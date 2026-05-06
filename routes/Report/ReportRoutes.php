<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\ReportController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::middleware(['auth'])->prefix('report')->group(function () {
    Route::get('/performance', [ReportController::class, 'index'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('report.index');
});