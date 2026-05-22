<?php 

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Auth;
use App\Services\Firebase\FirebaseService;

class NotificationController extends Controller {
 
    public function index() {
        //$firebaseService = new FirebaseService();
        //$imagePush = 'https://hexabe.sofopolis.com/assets/img/icon-push.png';
        //$token = 'cHaSZMLEVw7RRB1QjfbVDd:APA91bHTwBnfso0NqrpralA2Dsh-r7uyIiNjKAjP1W7y5-L_pwWBx9vrF_u5mkpGrOJsBSsdb1CLjJbuYMXSYOFrurwivp1mqYpK3lKVqOtRbp4kRJ_nqKw';
        //$firebaseService->send($token, "title", "message", "link", $imagePush);

        $user = Auth::user();
        $params = [
            'user' => $user
        ];
        
        return view('setting.notification', $params);
    }
}