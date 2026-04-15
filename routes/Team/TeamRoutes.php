<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Team\TeamController;
use App\Http\Controllers\Team\TeamInvitationController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::prefix('team')->group(function () {
    Route::get('/', [TeamController::class, 'index'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('team.index');
    Route::get('/create', [TeamController::class, 'create'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('team.create');
    Route::post('/create', [TeamController::class, 'save'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('team.save');

    Route::get('/edit/{team}', [TeamController::class, 'edit'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('team.edit');
    Route::post('/edit/{team}', [TeamController::class, 'update'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('team.update');

    Route::get('/view/{team}', [TeamController::class, 'view'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('team.view');

    Route::get('/remove/brand/{team}/{brand}', [TeamController::class, 'removeBrand'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('team.remove.brand');
    Route::get('/remove/user/{team}/{user}', [TeamController::class, 'removeUser'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('team.remove.user');

    Route::post('/invitation', [TeamInvitationController::class, 'invitation'])
        ->middleware(RoleMiddleware::using('ADMIN'))
        ->name('team.invitation');
});
