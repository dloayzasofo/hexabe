<?php 

namespace App\Http\Controllers\Firebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Firebase;
use Auth;

class FirebaseController extends Controller {
 
    public function save(Request $request) {
        $user = Auth::user();

        $token = $request->input('token');
        $source = $request->input('source');

        $firebase = Firebase::where('user_id', $user->id)
            ->where('token', $token)
            ->where('source', $source)
            ->first();

        if( $firebase == null ) {
            $firebase = new Firebase();
            $firebase->user_id = $user->id;
            $firebase->source = $source;
            $firebase->token = $token;
            $firebase->save();
        }
        
        $params = [
            'success' => true,
            'message' => 'Servicio de notificaciones guardado correctamente'
        ];

        return response()->json($params);
    }

    public function delete(Request $request) {
        $user = Auth::user();
        $source = $request->input('source');

        Firebase::where('user_id', $user->id)
            ->where('source', $source)
            ->delete();

        $params = [
            'success' => true,
            'message' => 'Servicio de notificaciones eliminado correctamente'
        ];
        
        return response()->json($params);
    }

}