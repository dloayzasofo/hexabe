<?php

namespace App\Http\Controllers\Popup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Helper\MediaHelper;
use App\Models\Popup;
use App\Models\Log\PopupLog;
use App\Http\Requests\PopupRequest;
use Illuminate\Routing\Redirector;
use Symfony\Component\HttpFoundation\Response;
use Storage;
use Auth;

class PopupController extends Controller
{
    function index(){
        return view('popup.index');
    }

    function create(){
        $parameters = ['model'=> new Popup];

        return view('popup.create', $parameters);
    }

    function save(PopupRequest $request){
        $model = new Popup;
        $user = Auth::user();

        if( $request->hasFile('image') ){
            $uploadedImage = $request->file('image');
            $media = MediaHelper::save($uploadedImage, "popup", $user);
            $model->media_id = $media->id;
        }

        $this->_sanitizeInputs($model, $request);
        $model->save();
        $this->_onlyOnePopupActive($model);
        $this->_save_logs($model, 'CREATE', $request);
        return redirect()->route('popup.view', [$model]);
    }

    function edit(Popup $popup){
        $parameters = ['model'=> $popup];

        return view('popup.update', $parameters);
    }

    function update(PopupRequest $request, Popup $popup){
        $user = Auth::user();
        if( $request->hasFile('image') ){
            $uploadedImage = $request->file('image');
            $media = MediaHelper::save($uploadedImage, "popup", $user);
            $popup->media_id = $media->id;
        }
        
        $this->_sanitizeInputs($popup, $request);
        $popup->save();
        $this->_onlyOnePopupActive($popup);
        $this->_save_logs($popup, 'UPDATE', $request);
        return redirect()->route('popup.view', [$popup]);
    }

    function view(Popup $popup){
        return view('popup.view', ['model'=> $popup]);
    }

    function delete(Request $request, Popup $popup){
        $name = $popup->name;
        $popup->delete();
        $this->_save_logs($popup, 'DELETE', $request);
        $request->session()->flash('popup.delete', 'Popup "' . $name . '" se eliminó correctamente');
        return redirect()->route('popup.index');
    }

    function toggle(Request $request, Popup $popup, $active){
        $status = null;
        if( $active == '1' ){
            $status = true;
        }elseif( $active == '0'){
            $status = false;
        }

        if( isset($status) AND $status != $popup->active){
            $popup->active = $status;
            $popup->save();
            $this->_onlyOnePopupActive($popup);
            $this->_save_logs($popup, 'SWITCH STATUS', $request);
        }
        
        return response()->json(['status'=>'ok']);
    }

    function list(Request $request){
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        $totalRecords = Popup::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Popup::select('count(*) as allcount')
            ->where('name', 'like', '%' .$searchValue . '%')
            ->orWhere('url', 'like', '%' .$searchValue . '%')
            ->count();

        // Fetch records
        $models = Popup::orderBy($columnName,$columnSortOrder)
            ->where('name', 'like', '%' .$searchValue . '%')
            ->orWhere('url', 'like', '%' .$searchValue . '%')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = $this->_modelsToHtmlTable($models);

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }

    function _modelsToHtmlTable($models){
        $data_arr = [];
   
        foreach($models as $model){
            $image      = '<div class="avatar"> <img src="' . $model->image . 
                '" alt="Avatar" class="rounded"> </div>'; 
            $name       = $model->name;
            $url        = $model->url;
            $active     = $model->active ? 
                '<span class="badge badge-center rounded-pill bg-success"><i class="bx bx-check"></i></span>' : 
                '<span class="badge badge-center bg-label-secondary"><i class="bx bx-minus"></i></span>';
            $created_at = date('d/m/Y H:i', strtotime($model->created_at));
            $actions    =   '<div class="d-inline-block">
                                <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a href="' . route('popup.view', [$model]) . '" class="dropdown-item">Ver</a></li>
                                    <li>
                                        <button data-href="' . route('popup.toggle', 
                                            [
                                                "popup" => $model, 
                                                "active" => $model->active ? '0' : '1'
                                            ]) . 
                                            '" class="dropdown-item popupActionToggle">' . 
                                            ($model->active ? "Desactivar" : "Activar") . 
                                        '</button>
                                    </li>
                                    <div class="dropdown-divider"></div>
                                    <li>
                                        <button class="dropdown-item text-danger delete-record confirmDelete"
                                            data-href="' . route('popup.delete', ['popup'=> $model]) . '"
                                            data-message="el popup <b> ' . $model->name . '</b>." >
                                            Eliminar
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <a href="' . route('popup.edit', [$model]) . '" class="btn btn-sm btn-icon item-edit">
                                <i class="bx bxs-edit"></i>
                            </a>';

            $data_arr[] = [
                "image"      => $image,
                "name"       => $name,
                "url"        => $url,
                "active"     => $active,
                "created_at" => $created_at,
                "actions"    => $actions
            ];
        }
        return $data_arr;
    }

    function _sanitizeInputs(&$model, $request){
        $url    = filter_var($request->url, FILTER_SANITIZE_URL);
        $name   = filter_var($request->name, FILTER_SANITIZE_STRING);
        $target = filter_var($request->target, FILTER_VALIDATE_BOOLEAN);
        $active = filter_var($request->active, FILTER_VALIDATE_BOOLEAN);

        $model->url     = $url ? $url : null;
        $model->name    = $name;
        $model->target  = $target;
        $model->active  = $active;
        $model->user_id = Auth::user()->id;
    }

    function _onlyOnePopupActive($model){
        if($model->active == false) return;
        
        $models = Popup::where('active', true)->where('id', '<>', $model->id)->get();
        foreach($models as $item){
            $item->active = false;
            $item->save();
        }
    }

    function _save_logs($model, $action, $request){
        /*
        $ua = $request->header('User-Agent');
        $ip = $request->ip();

        $log = new PopupLog();
        $log->model_id  = $model->id;
        $log->image     = $model->image;
        $log->name      = $model->name;
        $log->url       = $model->url;
        $log->target    = $model->target;
        $log->active    = $model->active;

        $log->user_id   = Auth::user()->id;
        $log->action    = $action;
        $log->ip        = $ip;
        $log->user_agent = $ua;

        $log->save();
        */
    }

}
