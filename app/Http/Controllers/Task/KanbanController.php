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

class KanbanController extends Controller {
 
    public function index() {
        $user = Auth::user();
        $tasks = Task::with('brand', 'assign', 'collaborators')
            ->withCount('medias')
            ->withCount('childs')
            ->where('user_assign', $user->id)
            ->orderBy('position', 'asc')
            ->get();

        $params = [
            'tasks' => $tasks
        ];

        return view('task.kanban.index', $params);
    }

    public function draganddrop(Request $request) {
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
                Task::where('id', $id)->update(['position' => $position]);
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