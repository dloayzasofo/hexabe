<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {

    return view('welcome');
});

require_once __DIR__ . '/LoginRoutes.php';
require_once __DIR__ . '/Brand/BrandRoutes.php';
require_once __DIR__ . '/Team/TeamRoutes.php';
require_once __DIR__ . '/Task/TaskRoutes.php';
require_once __DIR__ . '/Comment/CommentRoutes.php';
require_once __DIR__ . '/Media/MediaRoutes.php';
require_once __DIR__ . '/Dashboard/DashboardRoutes.php';
require_once __DIR__ . '/Setting/PerfilRoutes.php';
require_once __DIR__ . '/Setting/NotificationRoutes.php';
require_once __DIR__ . '/Notification/NotificationRoutes.php';
require_once __DIR__ . '/User/UserRoutes.php';
