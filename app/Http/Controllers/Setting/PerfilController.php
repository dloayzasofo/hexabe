<?php 

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Media;
use Auth;

class PerfilController extends Controller {
 
    public function index() {
        $user = Auth::user();
        $params = [
            'user' => $user
        ];
        
        return view('setting.perfil', $params);
    }

    public function save(Request $request) {
        $user = Auth::user();

        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->save();
        
        $request->session()->flash('setting.perfil.success', 'Perfil se ha actualizado correctamente.');
        return redirect()->route('setting.perfil.index');
    }

    public function upload_picture(Request $request) {
        $user = Auth::user();

        if( $request->file('image') != null ) {
            $uploadedImage = $request->file('image');
            $media = MediaHelper::saveMedia($uploadedImage, 120, 120, "user", $user);
            $user->media_id = $media->id;
            $user->save();

            return response()->json(['success' => true, 'data' => $media]);
        }

        return response()->json(['error' => true, 'message' => 'Seleccione una imagen.']);
    }

    public function remove_picture(Request $request) {
        $user = Auth::user();

        $media = Media::find($user->media_id);
        if( $media != null ) {
            Storage::disk('public')->delete($media->path);
            $media->delete();
            $user->media_id = null;
            $user->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['error' => true, 'message' => 'Seleccione una imagen.']);
    }
}