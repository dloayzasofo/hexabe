<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {

    return view('welcome');
});

require_once __DIR__ . '/LoginRoutes.php';
require_once __DIR__ . '/Brand/BrandRoutes.php';
