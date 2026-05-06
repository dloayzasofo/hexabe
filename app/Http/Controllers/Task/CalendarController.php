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
use Carbon\Carbon;
use Auth;

class CalendarController extends Controller {
 
    public function index() {
        $user = Auth::user();
        return view('task.calendar.index', []);
    }

    public function list(Request $request) {
        $user = Auth::user();
        $dateIni = $request->input('date_ini');
        $dateEnd = $request->input('date_end');

        $tasks = Task::with('brand', 'assign', 'collaborators')
            ->whereBetween('date_delivery', [$dateIni, $dateEnd])
            ->where(function($query)use($user){
                $query->where('user_assign', $user->id)
                      ->orWhere('user_id', $user->id)
                      ->orWhereRaw('id in (SELECT task_id FROM task_collaborators WHERE user_id = ?)', [$user->id]);
            })
            ->orderBy('position', 'asc')
            ->get();
        /*
        $tasks = Task::with('brand', 'assign', 'collaborators')
            ->withCount('medias')
            ->withCount('childs')
            ->whereBetween('date_delivery', [$dateIni, $dateEnd])
            ->where(function($query)use($user){
                $query->where('user_assign', $user->id)
                      ->orWhere('user_id', $user->id);
            })
            //->where('user_assign', $user->id)
            ->orderBy('position', 'asc')
            ->get();
        */

        $data = [];
        foreach($tasks as $task){
            $data[] = [
                'id' => $task->id,
                'title' => $task->title,
                'status' => $task->status,
                'date_delivery' => $task->date_delivery,
                'assign' => [
                    'id' => $task->assign->id,
                    'name' => $task->assign->name,
                    'last_name' => $task->assign->last_name,
                    'image' => $task->assign->image,
                    'nameInitial' => $task->assign->nameInitial
                ]
            ];
        }

        $params = [
            'success' => true,
            'data' => $data
        ];

        return response()->json($params);
    }

    public function draganddrop(Request $request) {
        $taskId = $request->input('task_id');
        //$date_delivery = $request->input('date_delivery');
        $date_delivery = Carbon::parse($request->input('date_delivery'))->format('Y-m-d');

        $task = Task::find($taskId);
        if( $task == null ){
            $result = [
                'success' => false,
                'message' => 'Tarea no encontrada'
            ];
            return response()->json($result);
        }

        $task->date_delivery = $date_delivery;
        $task->save();
        $result = [
            'success' => true,
            'data' => [
                'id' => $task->id,
                'date_delivery' => Carbon::parse($task->date_delivery)->format('d/m/Y'),
                'title' => $task->title
            ]
        ];
        return response()->json($result);
    }
}