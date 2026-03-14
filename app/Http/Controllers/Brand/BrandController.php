<?php 

namespace App\Http\Controllers\Brand;

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

class BrandController extends Controller {
 
    public function index() {
        //$role = Role::create(['name' => 'SUPER']);
        //$role = Role::create(['name' => 'ADMIN']);
        //$role = Role::create(['name' => 'STAFF']);
        //$role = Role::create(['name' => 'VISIT']);
        //$user = Auth::user();
        //$user->assignRole('ADMIN');
        $brand = Brand::find(1);
        echo "<pre>";
        print_r($brand->image);
        echo '<img src="'. $brand->image .'">';
        echo "</pre>";
        //echo "hola"; 
        exit();
    }

    public function create() {
        return view('brand.create');
    }

    public function save(Request $request) {
        //var_dump($request->all());
        $user = User::find(1);

        $brand = new Brand();
        if( $request->file('image') != null ) {

            $uploadedImage = $request->file('image');
            $media = MediaHelper::saveMedia($uploadedImage, 270, 195, "brand", $user);
            $brand->media_id = $media->id;
        }

        $brand->name = $request->name;
        $brand->industry = $request->industry;
        $brand->status = $request->status == "1" ? "ACTIVE" : "DEACTIVE";
        $brand->user_id = $user->id;
        $brand->business_id = $user->business_id;
        $brand->save();
        
        var_dump($brand->toArray());
        exit();
    }
}