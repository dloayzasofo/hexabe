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
use App\Models\TaskLink;
use App\Models\User;
use Auth;

class TaskController extends Controller {
 
    public function index() {
        $user = Auth::user();
        $tasks = Task::with('brand', 'assign', 'collaborators')->withCount('medias')->withCount('childs')->where('user_assign', $user->id)->get();
        //var_dump($tasks[0]);exit();
        $params = [
            'tasks' => $tasks
        ];

        return view('task.index', $params);
    }

    public function create(Request $request) {
        $brands = Brand::all();
        $task = null;
        $params = [
            'model' => new Task(),
            'brands' => $brands,
            'task' => $task
        ];

        return view('task.create', $params);
    }

    public function subtask(Request $request, Task $task) {
        $brands = Brand::all();
        $params = [
            'model' => new Task(),
            'brands' => $brands,
            'task' => $task
        ];

        return view('task.create', $params);
    }

    public function finish(Request $request, Task $task) {
        $task->status = 'FINALIZED';
        $task->save();
        
        $request->session()->flash('task.success', 'La tarea ha sido marcada como finalizada.');
        return redirect()->route('task.view', ['task' => $task->id]);
    }

    public function save(Request $request) {
        //var_dump($request->all());exit();
        $user = Auth::user();

        $title = $request->name;
        $description = $request->description;
        $priority = $request->priority;
        $date_delivery = $request->date_delivery;
        $brand = $request->brand;
        $user_assign = $request->user_assign;
        $medias = $request->medias;
        $members = $request->members;
        $links = $request->links;

        $task = new Task();
        $task->title = $title;
        $task->description = $description;
        $task->priority = $priority;
        $task->date_delivery = $date_delivery;
        $task->brand_id = $brand;
        $task->user_assign = $user_assign;
        $task->status = 'TOSTART';
        $task->user_id = $user->id;
        $task->business_id = $user->business_id;
        $task->save();

        if( $medias ){
            foreach($medias as $media){
                $taskMedia = new TaskMedia();
                $taskMedia->task_id = $task->id;
                $taskMedia->media_id = $media;
                $taskMedia->save();
            }
        }

        if( $members ){
            foreach($members as $member){
                $taskCollaborator = new TaskCollaborator();
                $taskCollaborator->task_id = $task->id;
                $taskCollaborator->user_id = $member;
                $taskCollaborator->save();
            }
        }

        if( $links ){
            foreach($links as $link){
                if( $link == null || trim($link) == '' ) continue;
                $taskLink = new TaskLink();
                $taskLink->url = $link;
                $taskLink->task_id = $task->id;
                $taskLink->save();
            }
        }

        if( $request->parent_id != null ){
            $task->parent_id = $request->parent_id;
            $task->save();
        }

        return response()->json(['success' => true, 'data' => $task]);
    }

    public function view(Request $request, Task $task) {

        $taskMedias = TaskMedia::with('media')->where('task_id', $task->id)->get();
        $taskLinks = TaskLink::where('task_id', $task->id)->get();
        $taskCollaboratos = TaskCollaborator::where('task_id', $task->id)->get();
        $childs = Task::where('parent_id', $task->id)->orderBy('date_delivery', 'asc')->get();
        $comments = $task->comments()->with('user')->with('commentmedias')->orderBy('created_at', 'desc')->get();

        $params = [
            'task' => $task,
            'taskMedias' => $taskMedias,
            'taskLinks' => $taskLinks,
            'taskCollaboratos' => $taskCollaboratos,
            'childs' => $childs,
            'comments' => $comments
        ];

        return view('task.view', $params);
    }
}