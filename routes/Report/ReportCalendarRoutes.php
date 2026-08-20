<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\ReportCalendarController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::middleware(['auth'])->prefix('report/calendar')->group(function () {
    Route::get('/', [ReportCalendarController::class, 'index'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('report.calendar.index');
    Route::post('/list', [ReportCalendarController::class, 'list'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('report.calendar.list');
});