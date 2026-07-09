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
require_once __DIR__ . '/Task/TaskEditRoutes.php';
require_once __DIR__ . '/Task/TaskSearchRoutes.php';
require_once __DIR__ . '/Comment/CommentRoutes.php';
require_once __DIR__ . '/Media/MediaRoutes.php';
require_once __DIR__ . '/Dashboard/DashboardRoutes.php';
require_once __DIR__ . '/Setting/PerfilRoutes.php';
require_once __DIR__ . '/Setting/NotificationRoutes.php';
require_once __DIR__ . '/Notification/NotificationRoutes.php';
require_once __DIR__ . '/User/UserRoutes.php';
require_once __DIR__ . '/Popup/PopupRoutes.php';
require_once __DIR__ . '/Report/ReportRoutes.php';
require_once __DIR__ . '/Report/ReportGroupRoutes.php';
require_once __DIR__ . '/Report/ReportResumeRoutes.php';
require_once __DIR__ . '/ResetPassword/ResetPasswordRoutes.php';
require_once __DIR__ . '/Cron/CronRoutes.php';
require_once __DIR__ . '/Firebase/FirebaseRoutes.php';
