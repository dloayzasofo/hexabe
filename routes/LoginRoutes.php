<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;

Route::prefix('login')->group(function () {
    
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'login'])->name('login.signup');
    Route::get('/exit', [LoginController::class, 'logout'])->name('login.exit');

});
