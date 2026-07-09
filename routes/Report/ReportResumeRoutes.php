<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Report\ReportResumeController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::middleware(['auth'])->prefix('report')->group(function () {
    Route::get('/resume', [ReportResumeController::class, 'index'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('report.resume');
    Route::get('/resume/stats', [ReportResumeController::class, 'stats'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('report.stats');
    Route::get('/resume/members', [ReportResumeController::class, 'members'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('report.members');
    Route::get('/resume/teams', [ReportResumeController::class, 'teams'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('report.teams');
    Route::get('/resume/brands', [ReportResumeController::class, 'brands'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('report.brands');
});