<?php 

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Task;
use App\Models\User;
use App\Models\Brand;
use Spatie\Permission\Models\Role;
use Auth;

class DashboardController extends Controller {
 
    public function index() {
        $user = Auth::user();
        $brands = Brand::where('business_id', $user->business_id)->limit(5)->get();
        $task = Task::where('user_assign', $user->id)
            ->whereIn('status', ['DELAY', 'TOSTART'])
            ->limit(3)
            ->get();

        $taskCategories = [
            'DELAY' => Task::where('user_assign', $user->id)->where('status', 'DELAY')->count(),
            'TOSTART' => Task::where('user_assign', $user->id)->where('status', 'TOSTART')->count(),
            'PROCESS' => Task::where('user_assign', $user->id)->where('status', 'PROCESS')->count(),
            'PAUSED' => Task::where('user_assign', $user->id)->where('status', 'PAUSED')->count(),
            'FINALIZED' => Task::where('user_assign', $user->id)->where('status', 'FINALIZED')->count(),
        ];

        

        $params = [
            'brands' => $brands,                        
            'tasks' => $task,
            'taskCategories' => $taskCategories
        ];
        
        return view('dashboard.index', $params);
    }
}