<?php 

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Brand;
use Auth;

class UserController extends Controller {
 
    function index(){
        return view('user.index');
    }

    function create(){
        $parameters = ['model'=> new User];

        return view('user.create', $parameters);
    }

    function save(Request $request){
        $model = new User;
        $user = Auth::user();

        $model->status = 'ACTIVE';
        $model->business_id = $user->business_id;
        $model->phone_code = '591';
        $model->parent_id = $user->id;
        $this->_sanitizeInputs($model, $request);
        $model->save();

        $model->assignRole($model->role);

        $this->_save_logs($model, 'CREATE', $request);
        return redirect()->route('user.view', [$model]);
    }

    function edit(User $user){
        $parameters = ['model'=> $user];

        return view('user.update', $parameters);
    }

    function update(Request $request, User $user){
        $oldRole = $user->role;
        $this->_sanitizeInputs($user, $request);
        $user->save();
                
        if( $oldRole != $user->role ){
            $user->syncRoles($user->role);
        }
            
        $this->_save_logs($user, 'UPDATE', $request);
        return redirect()->route('user.view', [$user]);
    }

    function changePassword(User $user){
        $parameters = ['model'=> $user];

        return view('user.change_password', $parameters);
    }

    function savePassword(PasswordRequest $request, User $user){
        $password = filter_var($request->password, FILTER_SANITIZE_STRING);
        $user->password = Hash::make($password);
        $user->save();
        $this->_save_logs($user, 'CHANGE PASSWORD', $request);
        $request->session()->flash('user.change_password', 'Usuario "' . $user->name . '" se cambió la contraseña correctamente');
        return redirect()->route('user.view', [$user]);
    }

    function view(User $user){
        return view('user.view', ['model'=> $user]);
    }

    function delete(Request $request, User $user){
        $name = $user->name . ' ' . $user->last_name;
        $user_id = $user->id;
        $user->email = $user->email . '_deleted_' . Str::random(5);
        $user->delete();
        $this->_save_logs($user, 'DELETE', $request);

        if( $user_id == Auth::user()->id ){
            Auth::logout();
        }

        $request->session()->flash('user.delete', 'Usuario "' . $name . '" se eliminó correctamente');
        return redirect()->route('user.index');
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

        $totalRecords = User::select('count(*) as allcount')->where('id', '>', 1)->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')
            ->where(function ($query) use($searchValue) {
                $query->orWhere('name', 'like', '%' .$searchValue . '%')
                    ->orWhere('last_name', 'like', '%' .$searchValue . '%')
                    ->orWhere('email', 'like', '%' .$searchValue . '%');
            })
            ->count();
        
        // Fetch records
        $models = User::orderBy($columnName,$columnSortOrder)
            ->where(function ($query) use($searchValue) {
                $query->orWhere('name', 'like', '%' .$searchValue . '%')
                    ->orWhere('last_name', 'like', '%' .$searchValue . '%')
                    ->orWhere('email', 'like', '%' .$searchValue . '%');
            })
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
            $name = $model->name;
            $last_name  = $model->last_name;
            $email      = $model->email;

            $teams = '';
            foreach($model->teamusers as $teamuser){
                $teams .= '<span class="badge bg-label-dark me-2">' . $teamuser->team->name . '</span>';
            }
            
            switch($model->role){
                case 'SUPER':
                    $role = '<span class="badge bg-label-primary">Super Admin</span>';
                break;
                case 'ADMIN':
                    $role = '<span class="badge bg-label-primary">Administrador</span>';
                break;
                case 'USER':
                    $role = '<span class="badge bg-label-secondary">Miembro</span>';
                break;
                case 'EXTERNAL':
                    $role = '<span class="badge bg-label-secondary">Invitado</span>';
                break;
            }

            $created_at = date('d/m/Y H:i', strtotime($model->created_at));

            $image = '<span class="avatar-initial rounded-circle bg-label-danger">' . $model->nameInitial . '</span>';
            if( $model->image ){
                $image = '<img src="' . $model->image .'" alt="Avatar" class="rounded-circle">';
            }

            $nameHtml = '<div class="d-flex justify-content-start align-items-center user-name">
                            <div class="avatar-wrapper">
                                <div class="avatar avatar-sm me-2">
                                    ' . $image . '
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <a href="app-user-view-account.html" class="text-heading text-truncate">
                                    <span class="fw-medium">' . $model->name . ' ' . $model->last_name . '</span>
                                </a>
                                <small>' . $model->email . '</small>
                            </div>
                        </div>';

            $actions    =   '<div class="d-inline-block">
                                <a href="javascript:;" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a href="' . route('user.view', [$model]) . '" class="dropdown-item">Ver</a></li>
                                    <li><a href="' . route('user.change_password', ['user'=> $model]) . '" class="dropdown-item">Cambiar Contraseña</a></li>
                                    <div class="dropdown-divider"></div>
                                    <li>
                                        <button class="dropdown-item text-danger delete-record confirmDelete"
                                            data-href="' . route('user.delete', ['user'=> $model]) . '"
                                            data-message="el user <b> ' . $model->name . ' ' . $model->last_name . '</b>." >
                                            Eliminar
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <a href="' . route('user.edit', [$model]) . '" class="btn btn-sm btn-icon item-edit">
                                <i class="bx bxs-edit"></i>
                            </a>';

            $data_arr[] = [
                "name" => $nameHtml,
                "role"  => $role,
                "position"      => $model->position,
                "teams"      => $teams,
                "created_at" => $created_at,
                "actions"    => $actions
            ];
        }
        return $data_arr;
    }

    function _sanitizeInputs(&$model, $request){
        $name = filter_var($request->name, FILTER_SANITIZE_STRING);
        $last_name  = filter_var($request->last_name, FILTER_SANITIZE_STRING);
        $email      = filter_var($request->email, FILTER_SANITIZE_STRING);

        $phone      = filter_var($request->phone, FILTER_SANITIZE_STRING);
        $role       = filter_var($request->role, FILTER_SANITIZE_STRING);
        $position   = filter_var($request->position, FILTER_SANITIZE_STRING);

        if( $model->id == null ){
            $password   = filter_var($request->password, FILTER_SANITIZE_STRING);
            $model->password    = Hash::make($password);
        }

        $model->name  = $name;
        $model->last_name   = $last_name;
        $model->email       = $email;
        $model->phone       = $phone;
        $model->role        = $role;
        $model->position    = $position;
    }

    function _save_logs($model, $action, $request){
        /*
        $ua = $request->header('User-Agent');
        $ip = $request->ip();

        $log = new UserLog();
        $log->model_id       = $model->id;
        $log->first_name     = $model->first_name;
        $log->last_name      = $model->last_name;
        $log->email          = $model->email;
        $log->email_verify_at = $model->email_verify_at;
        $log->password       = $model->password;
        $log->remember_token = $model->remember_token;

        $log->user_id   = Auth::user()->id;
        $log->action    = $action;
        $log->ip        = $ip;
        $log->user_agent = $ua;

        $log->save();
        */
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