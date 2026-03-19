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

    public function search_user(Request $request) {
        $query = trim($request->query('q', ''));
        if( !$query ) {
            return response()->json(['success' => false, 'message' => 'Debe indicar un email'], 422);
        }

        $user = User::where('email', $query)->first();
        if( !$user ) {
            return response()->json(['success' => false, 'message' => 'No se encontró un usuario con ese email'], 404);
        }

        return response()->json(['success' => true, 'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]]);
    }

    public function search_by_key(Request $request) {
        $user = Auth::user();
        $business_id = $user->business_id;
        $query = trim($request->query('q', ''));

        $users = User::where('business_id', $business_id)
            ->where('email', 'like', '%' . $query. '%')
            ->get();

        $result = [];

        foreach( $users as $user ) {
            $result[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'image' => $user->image,
                'initials' => $user->nameInitial
            ];
        }

        return response()->json(['success' => true, 'data' => $result]);
    }
}