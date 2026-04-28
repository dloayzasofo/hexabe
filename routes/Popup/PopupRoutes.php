<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Popup\PopupController;

Route::group(['prefix' => 'popup',  'middleware' => 'auth'], function () {
    
    Route::get('/', [PopupController::class, 'index'])->name('popup.index');
    Route::get('/create', [PopupController::class, 'create'])->name('popup.create');
    Route::post('/create', [PopupController::class, 'save'])->name('popup.save');
    Route::get('/view/{popup}', [PopupController::class, 'view'])->name('popup.view');
    Route::get('/update/{popup}', [PopupController::class, 'edit'])->name('popup.edit');
    Route::post('/update/{popup}', [PopupController::class, 'update'])->name('popup.update');
    Route::get('/delete/{popup}', [PopupController::class, 'delete'])->name('popup.delete');
    Route::post('/list', [PopupController::class, 'list'])->name('popup.list');
    Route::get('/toggle/{popup}/{active}', [PopupController::class, 'toggle'])->name('popup.toggle');

});
