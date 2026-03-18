<?php 

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Auth;

class BrandController extends Controller {
 
    public function index() {
        $brands = Brand::all();
        $params = [
            'brands' => $brands
        ];

        return view('brand.index', $params);
    }

    public function create() {
        $params = [
            'model' => new Brand()
        ];

        return view('brand.create', $params);
    }

    public function save(BrandRequest $request) {
        $user = Auth::user();

        $brand = new Brand();
        if( $request->file('image') != null ) {
            $uploadedImage = $request->file('image');
            $media = MediaHelper::saveMedia($uploadedImage, 270, 195, "brand", $user);
            $brand->media_id = $media->id;
        }

        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->industry = $request->industry;
        $brand->status = $request->status == "1" ? "ACTIVE" : "DEACTIVE";
        $brand->user_id = $user->id;
        $brand->business_id = $user->business_id;
        $brand->save();
        
        $request->session()->flash('brand.success', 'Marca ha sido registrada correctamente.');
        return response()->json(['success' => true]);
        //return redirect()->route('brand.index');
    }

    public function edit(Request $request, Brand $brand) {
        $params = [
            'model' => $brand
        ];

        return view('brand.update', $params);
    }

    public function update(BrandRequest $request, Brand $brand) {
        $user = Auth::user();

        if( $request->file('image') != null ) {
            $uploadedImage = $request->file('image');
            $media = MediaHelper::saveMedia($uploadedImage, 270, 195, "brand", $user);
            $brand->media_id = $media->id;
        }

        $brand->name = $request->name;
        $brand->description = $request->description;
        $brand->industry = $request->industry;
        $brand->status = $request->status == "1" ? "ACTIVE" : "DEACTIVE";
        $brand->user_id = $user->id;
        $brand->business_id = $user->business_id;
        $brand->save();
        
        $request->session()->flash('brand.success', 'Marca ha sido actualizada correctamente.');
        return response()->json(['success' => true]);
        //return redirect()->route('brand.index');
    }

    public function view(Request $request, Brand $brand) {
        $params = [
            'brand' => $brand
        ];

        return view('brand.view', $params);
    }
}