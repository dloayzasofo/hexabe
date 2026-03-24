<?php 

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use Illuminate\Support\Str;
use App\Http\Requests\TeamRequest;
use App\Models\Brand;
use App\Models\Media;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Auth;

class MediaController extends Controller {
 
    public function save(Request $request) {
        $user = Auth::user();

        $file = $request->file('file');

        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $mime = $file->getClientMimeType();
        $size = $file->getSize();
        
        $path = $user->business_id . '/resources/' . $fileName;
        Storage::disk('public')->put($path, file_get_contents($file));

        $media = new Media();
        $media->name = $file->getClientOriginalName();
        $media->path = $path;
        $media->mime = $mime;
        $media->size = $size;
        $media->user_id = $user->id;
        $media->business_id = $user->business_id;
        $media->save();

        return response()->json(['success' => true, 'data' => $media]);
    }

    public function delete(Request $request) {
        $id = $request->id;
        $media = Media::find($id);
        
        if( $media ){
            Storage::disk('public')->delete($media->path);
            $media->delete();
        }
        return response()->json([ 'success' => true, 'data' => ['id'=> $id] ]);
    }
}