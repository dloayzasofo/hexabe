<?php 

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Brand;
use Spatie\Permission\Models\Role;
use Auth;

class UserController extends Controller {
 
    public function index() {
        $users = User::all();
        $params = [
            'users' => $users
        ];
        
        return view('user.index', $params);
    }
}