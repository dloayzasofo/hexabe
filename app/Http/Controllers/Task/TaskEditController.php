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
use App\Models\User;
use Auth;

class TaskEditController extends Controller {
 
    public function status(Request $request, Task $task) {
        $task->status = $request->status;
        $task->save();
        return response()->json(['success' => true, 'data' => ["status"=> $task->status]], 200);
    }

    public function priority(Request $request, Task $task) {
        $task->priority = $request->priority;
        $task->save();
        return response()->json(['success' => true, 'data' => ["priority"=> $task->priority]], 200);
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

}