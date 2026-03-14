<?php 

namespace App\Http\Helper;
use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class MediaHelper {

    /**
     * Save Media
     * 
     * @param $file Request file
     * @param $width int
     * @param $height int
     * @param $folder string
     * @param $user User
     * @return Media
     */
    public static function saveMedia($file, $width, $height, $folder, $user): Media {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $mime = $file->getClientMimeType();
        //$size = $file->getSize();
        
        $img = Image::read($file->getRealPath());
        $img->scaleDown(120, 100);
        $size = strlen((string) $img->encode());
        $path = $user->business_id . '/' . $folder . '/' . $fileName;
        Storage::disk('public')->put($path, (string) $img->encode());

        $media = new Media();
        $media->name = $file->getClientOriginalName();
        $media->path = $path;
        $media->mime = $mime;
        $media->size = $size;
        $media->user_id = $user->id;
        $media->business_id = $user->business_id;
        $media->save();
        return $media;
    }

}

