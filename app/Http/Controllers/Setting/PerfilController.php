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

class PerfilController extends Controller {
 
    public function index() {
        $user = Auth::user();
        $params = [
            'user' => $user
        ];
        
        return view('setting.perfil', $params);
    }
}