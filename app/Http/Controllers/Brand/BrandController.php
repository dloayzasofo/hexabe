<?php 

namespace App\Http\Controllers\Brand;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\Task;
use App\Models\Team;
use App\Models\TeamBrand;
use Auth;

class BrandController extends Controller {
 
    public function index() {
        $user = Auth::user();
        $brands = Brand::where('business_id', $user->business_id)->get();

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
        $brand->status = "ACTIVE";
        $brand->user_id = $user->id;
        $brand->business_id = $user->business_id;
        $brand->save();
        
        $request->session()->flash('brand.success', 'Marca ha sido registrada correctamente.');
        return response()->json(['success' => true]);
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
        //$brand->status = $request->status == "1" ? "ACTIVE" : "DEACTIVE";
        $brand->user_id = $user->id;
        $brand->business_id = $user->business_id;
        $brand->save();
        
        $request->session()->flash('brand.success', 'Marca ha sido actualizada correctamente.');
        return response()->json(['success' => true]);
    }

    public function view(Request $request, Brand $brand) {
        $lastTasks = Task::where('brand_id', $brand->id)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $members = $brand->members;
        $params = [
            'brand' => $brand,
            'lastTasks' => $lastTasks,
            'members' => $members
        ];

        return view('brand.view', $params);
    }

    public function delete(Request $request, Brand $brand) {
        $taskCount = Task::where('brand_id', $brand->id)->count();
        $name = $brand->name;

        if( $taskCount > 0 ) {
            $request->session()->flash('brand.error', 'No se puede eliminar la marca porque tiene tareas asociadas.');
            return redirect()->route('brand.view', [$brand]);
        } 

        TeamBrand::where('brand_id', $brand->id)->delete();

        $brand->delete();
        $request->session()->flash('brand.success', 'Marca ' . $name . ' ha sido eliminada correctamente.');
        return redirect()->route('brand.index');
    }

    public function search_by_key(Request $request) {
        $user = Auth::user();
        $business_id = $user->business_id;
        $query = trim($request->query('q', ''));

        $brands = Brand::where('business_id', $business_id)
            ->where('name', 'like', '%' . $query. '%')
            ->get();

        $result = [];

        foreach( $brands as $brand ) {
            $result[] = [
                'id' => $brand->id,
                'name' => $brand->name,
                'image' => $brand->image,
                'initials' => $brand->nameInitial
            ];
        }

        return response()->json(['success' => true, 'data' => $result]);
    }

}