<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Resetpassword\ResetpasswordController;

Route::get('/resetpassword', [ResetpasswordController::class, 'index'])->name('resetpassword.index');
Route::post('/resetpassword/{token}', [ResetpasswordController::class, 'request'])->name('resetpassword.request');
Route::get('/resetpassword/reset/{token}', [ResetpasswordController::class, 'show'])->name('resetpassword.show');
Route::post('/resetpassword/reset/{token}', [ResetpasswordController::class, 'reset'])->name('resetpassword.reset');
Route::get('/resetpassword/thankyou', [ResetpasswordController::class, 'thankyou'])->name('resetpassword.thankyou');
