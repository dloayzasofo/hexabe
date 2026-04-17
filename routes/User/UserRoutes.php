<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use \Spatie\Permission\Middleware\RoleMiddleware;

Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])
    ->name('user.index');

    Route::get('/create', [UserController::class, 'create'])
    ->name('user.create');

    Route::post('/create', [UserController::class, 'save'])
    ->name('user.save');

    Route::get('/view/{user}', [UserController::class, 'view'])
    ->name('user.view');

    Route::get('/update/{user}', [UserController::class, 'edit'])
    ->name('user.edit');

    Route::post('/update/{user}', [UserController::class, 'update'])
    ->name('user.update');

    Route::get('/delete/{user}', [UserController::class, 'delete'])
    ->name('user.delete');

    Route::post('/list', [UserController::class, 'list'])
    ->name('user.list');

    Route::get('/change_password/{user}', [UserController::class, 'changePassword'])
    ->name('user.change_password');

    Route::post('/change_password/{user}', [UserController::class, 'savePassword'])
    ->name('user.save_password');

    Route::get('/search-user', [UserController::class, 'search_user'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('user.search-user');

    Route::get('/search-by-key', [UserController::class, 'search_by_key'])
        //->middleware(RoleMiddleware::using('ADMIN'))
        ->name('user.search-by-key');
});
