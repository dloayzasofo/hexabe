<?php 

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use App\Http\Requests\TeamRequest;
use App\Models\Brand;
use App\Models\Task;
use App\Models\TaskMedia;
use App\Models\TaskCollaborator;
use App\Models\TeamUser;
use App\Models\User;
use Auth;

class TaskUserController extends Controller {
 
    public function list(Request $request, User $user) {
        $status = $request->query('status');
        if( $status == null OR !in_array($status, ['TOSTART', 'PROCESS', 'FINALIZED', 'DELAY', 'PAUSED']) ){
            $status = 'TOSTART';
        }

        $counters = [
            "TOSTART" => Task::where('user_assign', $user->id)->where('status', 'TOSTART')->count(),
            "PROCESS" => Task::where('user_assign', $user->id)->where('status', 'PROCESS')->count(),
            "FINALIZED" => Task::where('user_assign', $user->id)->where('status', 'FINALIZED')->count(),
            "DELAY" => Task::where('user_assign', $user->id)->where('status', 'DELAY')->count(),
            "PAUSED" => Task::where('user_assign', $user->id)->where('status', 'PAUSED')->count(),
        ];


        $tasks = Task::with('brand', 'assign', 'collaborators')
            ->withCount('medias')
            ->withCount('childs')
            ->where('user_assign', $user->id)
            ->where('status', $status)
            ->get();
        
        $params = [
            'user' => $user,
            'tasks' => $tasks,
            'status' => $status,
            'counters' => $counters
        ];

        return view('task.user.list', $params);
    }

    public function kanban(Request $request, User $user) {
        $tasks = Task::with('brand', 'assign', 'collaborators')
            ->withCount('medias')
            ->withCount('childs')
            ->where('user_assign', $user->id)
            ->orderBy('position', 'asc')
            ->get();

        $params = [
            'user' => $user,
            'tasks' => $tasks
        ];

        return view('task.user.kanban', $params);
    }
}