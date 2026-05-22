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
use App\Models\TaskOrderUser;
use App\Models\TeamUser;
use App\Models\User;
use Auth;

class KanbanController extends Controller {
 
    public function index() {
        $user = Auth::user();
        /*
        $tasks = Task::with('brand', 'assign', 'collaborators')
            ->withCount('medias')
            ->withCount('childs')
            ->where(function($query)use($user){
                $query->where('user_assign', $user->id)
                      ->orWhere('user_id', $user->id);
            })
            //->where('user_assign', $user->id)
            ->orderBy('position', 'asc')
            ->get();

        $query = Task::with('brand', 'assign', 'collaborators')
            ->withCount('medias')
            ->withCount('childs')
            ->where(function($query)use($user){
                $query->where('tasks.user_assign', $user->id)
                      ->orWhere('tasks.user_id', $user->id);
            });
        */
        $query = Task::with('brand', 'assign', 'collaborators')
            ->withCount('medias')
            ->withCount('childs')
            ->where(function($query)use($user){
                $query->where('tasks.user_assign', $user->id)
                      ->orWhere('tasks.user_id', $user->id);
            })
            ->leftJoin('task_order_users', function ($join) use($user) {
                $join->on('task_order_users.task_id', '=', 'tasks.id')->where('task_order_users.user_id', '=', $user->id);
            });

        $taskToStart = (clone $query)->where('status', 'TOSTART')->orderBy('task_order_users.position', 'asc')->get();
        $taskProcess = (clone $query)->where('status', 'PROCESS')->orderBy('task_order_users.position', 'asc')->get();
        $taskFinalized = (clone $query)->where('status', 'FINALIZED')->orderBy('task_order_users.position', 'asc')->get();
        $taskDelay = (clone $query)->where('status', 'DELAY')->orderBy('task_order_users.position', 'asc')->get();
        $taskPaused = (clone $query)->where('status', 'PAUSED')->orderBy('task_order_users.position', 'asc')->get();

        $params = [
            //'tasks' => $tasks,
            'taskToStart' => $taskToStart,
            'taskProcess' => $taskProcess,
            'taskFinalized' => $taskFinalized,
            'taskDelay' => $taskDelay,
            'taskPaused' => $taskPaused
        ];

        return view('task.kanban.index', $params);
    }

    public function draganddrop(Request $request) {
        $user = Auth::user();
        $taskId = $request->input('task_id');
        $newStatus = $request->input('new_status');
        $position = $request->input('position');
        $order = $request->input('order');

        $message = null;
        $task = Task::find($taskId);
        if ($task AND $task->status != $newStatus) {
            $task->status = $newStatus;
            $task->save();
            $status = "";
            switch ($newStatus) {
                case 'TOSTART':
                    $status = "Sin empezar";
                    break;
                case 'PROCESS':
                    $status = "En proceso";
                    break;
                case 'FINALIZED':
                    $status = "Finalizada";
                    break;
                case 'DELAY':
                    $status = "Retrasado";
                    break;
                case 'PAUSED':
                    $status = "Pausado";
                    break;
            }
            $message = $task->id . ' - <b>' . $task->title . '</b> se ha movido al estado: ' . $status;
        }

        if( isset($order) AND is_array($order['items']) ) {
            foreach ($order['items'] as $index => $item) {
                $id = $item['id'];
                $position = $item['position'];

                //Task::where('id', $id)->update(['position' => $position]);
                $taskOrder = TaskOrderUser::where('task_id', $id)->where('user_id', $user->id)->first();
                if ($taskOrder) {
                    if( $taskOrder->position != $position ) {
                        $taskOrder->position = $position;
                        $taskOrder->save();
                    }
                } else {
                    TaskOrderUser::create([
                        'task_id' => $id,
                        'user_id' => $user->id,
                        'position' => $position
                    ]);
                }
            }
        }

        $result = [
            'success' => true,
            'message' => $message
        ];
        //var_dump($taskId, $newStatus, $position, $order);exit();

        return response()->json($result);
    }
}