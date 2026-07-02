<?php 

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\NotificationHelper;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\Task;
use App\Models\TaskMedia;
use App\Models\TaskCollaborator;
use App\Models\TeamUser;
use App\Models\TaskLink;
use App\Models\TaskInfo;
use App\Models\TimeControl;
use App\Models\User;
use Auth;

class TaskEditController extends Controller {
 
    public function status(Request $request, Task $task) {
        $task->status = $request->status;
        $task->save();
        $message = Str::limit($task->title, 50) . ": Estado de la tarea actualizado";

        $timeControl = new TimeControl();
        $timeControl->task_id = $task->id;
        $timeControl->user_id = Auth::user()->id;
        $timeControl->status = $task->status;
        $timeControl->save();
        
        return response()->json(['success' => true, 'data' => ["id"=> $task->id, "status"=> $task->status], 'message' => $message], 200);
    }

    public function priority(Request $request, Task $task) {
        $task->priority = $request->priority;
        $task->save();
        $message = Str::limit($task->title, 50) . ": Prioridad de la tarea actualizada";
        return response()->json(['success' => true, 'data' => ["id"=> $task->id, "priority"=> $task->priority], 'message' => $message], 200);
    }

    public function title(Request $request, Task $task) {
        $description = trim($request->description);
        if( $description == '' OR $description == '<p><br></p>' ) $description = null;

        $task->title = $request->title;
        $task->description = $description;
        $task->save();
        
        return response()->json(['success' => true, 'data' => [
            "title"=> $task->title,
            "description"=> $task->description
        ]], 200);
    }

    public function brand(Request $request, Task $task) {
        $brand = Brand::find($request->brand_id);
        $task->brand_id = $brand->id;
        $task->save();
        return response()->json(['success' => true, 'data' => [
            "id"=> $brand->id,
            "name"=> $brand->name,
            "image" => $brand->image,
            "industry"=> $brand->industry
        ]], 200);
    }

    public function user(Request $request, Task $task) {
        $user = User::find($request->user_id);
        $task->user_assign = $user->id;
        $task->save();

        if( $user->id != Auth::user()->id ){
            NotificationHelper::send(
                $task->assign, 
                'Tienes una tarea por realizar', 
                $task->title, 
                'TASK',
                $task->id,
                $user,
                route('task.view', ['task' => $task->id]),
                $task->priority
            );
        }

        return response()->json(['success' => true, 'data' => [
            "id"=> $user->id,
            "name"=> $user->name,
            "last_name"=> $user->last_name,
            "nameInitial"=> $user->nameInitial,
            "image" => $user->image
        ]], 200);
    }

    public function date_delivery(Request $request, Task $task) {
        $task->date_delivery = $request->date_delivery;
        $task->save();
        return response()->json(['success' => true, 'data' => [
            "id"=> $task->id,
            "date_delivery"=> $task->date_delivery
        ]], 200);
    }

    public function add_dependency(Request $request, Task $task, Task $dependency) {
        $taskInfo = TaskInfo::where('task_id', $task->id)->first();
        
        if( $taskInfo == null ){
            $taskInfo = new TaskInfo();
            $taskInfo->task_id = $task->id;
        }

        $taskInfo->task_dependency_id = $dependency->id;
        $taskInfo->save();

        $params = [
            'success' => true, 
            'data' => [
                "id"=> $taskInfo->id,
                "task_id"=> $taskInfo->task_id,
                "task_dependency_id"=> $taskInfo->task_dependency_id
            ]
        ];

        return response()->json($params, 200);
    }

    public function delete_dependency(Request $request, Task $task, Task $dependency) {
        $taskInfo = TaskInfo::where('task_id', $task->id)->where('task_dependency_id', $dependency->id)->first();
        
        if( $taskInfo ){
            $taskInfo->task_dependency_id = null;
            $taskInfo->save();
            return response()->json(['success' => true], 200);
        }

        return response()->json(['success' => false], 404);
    }

}