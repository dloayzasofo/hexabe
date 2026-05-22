<?php 

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use App\Http\Helper\NotificationHelper;
use Illuminate\Support\Str;
use App\Http\Helper\HistoryHelper;
use App\Models\Brand;
use App\Models\Task;
use App\Models\TaskMedia;
use App\Models\TaskCollaborator;
use App\Models\TaskOrderUser;
use App\Models\TeamUser;
use App\Models\TaskLink;
use App\Models\User;
use Auth;

class TaskController extends Controller {
 
    public function index(Request $request) {
        $status = $request->query('status');
        if( $status == null OR !in_array($status, ['TOSTART', 'PROCESS', 'FINALIZED', 'DELAY', 'PAUSED']) ){
            $status = 'TOSTART';
        }

        $user = Auth::user();
        $counters = [
            "TOSTART" => Task::getTaskCountByStatus('TOSTART', $user),
            "PROCESS" => Task::getTaskCountByStatus('PROCESS', $user),
            "FINALIZED" => Task::getTaskCountByStatus('FINALIZED', $user),
            "DELAY" => Task::getTaskCountByStatus('DELAY', $user),
            "PAUSED" => Task::getTaskCountByStatus('PAUSED', $user)
        ];
        /*
        $counters = [
            "TOSTART" => Task::where(function($query)use($user){ $query->where('user_assign', $user->id)->orWhere('user_id', $user->id); })->where('status', 'TOSTART')->count(),
            "PROCESS" => Task::where(function($query)use($user){ $query->where('user_assign', $user->id)->orWhere('user_id', $user->id); })->where('status', 'PROCESS')->count(),
            "FINALIZED" => Task::where(function($query)use($user){ $query->where('user_assign', $user->id)->orWhere('user_id', $user->id); })->where('status', 'FINALIZED')->count(),
            "DELAY" => Task::where(function($query)use($user){ $query->where('user_assign', $user->id)->orWhere('user_id', $user->id); })->where('status', 'DELAY')->count(),
            "PAUSED" => Task::where(function($query)use($user){ $query->where('user_assign', $user->id)->orWhere('user_id', $user->id); })->where('status', 'PAUSED')->count(),
        ];
        */

        $tasks = Task::with('brand', 'assign', 'collaborators')
            ->withCount('medias')
            ->withCount('childs')
            ->withCount('comments')
            ->where(function($query)use($user){
                $query->where('user_assign', $user->id)
                      ->orWhere('user_id', $user->id)
                      ->orWhereRaw('id in (SELECT task_id FROM task_collaborators WHERE user_id = ?)', [$user->id]);
            })
            ->where('status', $status)
            ->get();
        
        $params = [
            'tasks' => $tasks,
            'status' => $status,
            'counters' => $counters
        ];

        HistoryHelper::save(Auth::user(), 'task');
        return view('task.index', $params);
    }

    public function create(Request $request) {
        $brands = Brand::orderBy('name', 'asc')->get();
        $task = null;
        $params = [
            'model' => new Task(),
            'brands' => $brands,
            'task' => $task
        ];

        return view('task.create', $params);
    }

    public function finish(Request $request, Task $task) {
        //var_dump($task->user);exit();
        $task->status = 'FINALIZED';
        $task->finalized_at = date('Y-m-d H:i:s');
        $task->save();
        
        $user = Auth::user();

        $userNotify = $task->user;
        if($user->id == $task->user_id){
            $userNotify = $task->assign;
        }

        if( $task->user_id != $task->user_assign ){
            NotificationHelper::send(
                $userNotify, 
                'Tarea "' . Str::limit($task->title, 12) . '" ha sido marcada como finalizada.', 
                $task->title,
                'TASK',
                $user,
                route('task.view', ['task' => $task->id]),
                $task->priority
            );
        }
        
        $request->session()->flash('task.success', 'La tarea ha sido marcada como finalizada.');
        return redirect()->route('task.view', ['task' => $task->id]);
    }

    public function apifinish(Request $request, Task $task) {
        $task->status = 'FINALIZED';
        $task->finalized_at = date('Y-m-d H:i:s');
        $task->save();

        $user = Auth::user();

        $userNotify = $task->user;
        if($user->id == $task->user_id){
            $userNotify = $task->assign;
        }

        if( $task->user_id != $task->user_assign ){
            NotificationHelper::send(
                $userNotify, 
                'Tarea "' . Str::limit($task->title, 12) . '" ha sido marcada como finalizada.', 
                $task->title,
                'TASK',
                $user,
                route('task.view', ['task' => $task->id]),
                $task->priority
            );
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'action' => "FINALIZED",
                'id' => $task->id,
                'title' => $task->title,
                'status' => $task->status,
                'message' => 'La tarea ha sido marcada como finalizada.'
            ]
        ]);
    }

    public function apidelete(Request $request, Task $task) {
        $id = $task->id;
        $title = $task->title;
        $user_origin = $task->user;
        $task->delete();
        
        $user = Auth::user();
        NotificationHelper::send(
            $user_origin, 
            'Tarea "' . Str::limit($title, 12) . '" ha sido eliminada', 
            $title,
            'TASK',
            null,
            null,
            'high'
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'action' => "DELETE",
                'id' => $task->id,
                'title' => $task->title,
                'status' => $task->status,
                'message' => 'La tarea ha sido eliminada.'
            ]
        ]);
    }

    public function delete(Request $request, Task $task) {
        //var_dump($task->user);exit();
        $task->status = 'FINALIZED';
        $task->save();
        
        $user = Auth::user();
        NotificationHelper::send(
            $task->user, 
            'Tarea "' . Str::limit($task->title, 12) . '" ha sido marcada como finalizada.', 
            $task->title,
            'TASK',
            $user,
            route('task.view', ['task' => $task->id]),
            $task->priority
        );
        
        $request->session()->flash('task.success', 'La tarea ha sido marcada como finalizada.');
        return redirect()->route('task.view', ['task' => $task->id]);
    }

    public function save(Request $request) {
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
        $task->position = 0;
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

        $this->saveOrder($task->id, $user->id);
        if( $user_assign != $user->id ){
            $this->saveOrder($task->id, $user_assign);
        }

        NotificationHelper::send(
            $task->assign, 
            'Tienes una tarea por realizar', 
            $task->title, 
            'TASK',
            $user,
            route('task.view', ['task' => $task->id]),
            $task->priority
        );
        
        $request->session()->flash('task.success', 'Tarea ha sido registrada correctamente.');
        return response()->json(['success' => true, 'data' => $task]);
    }

    public function saveOrder($task_id, $user_id){
        $position = Task::where('tasks.user_id', $user_id)
            ->where('status', 'TOSTART')
            ->leftJoin('task_order_users', function ($join) use($user_id) {
                $join->on('task_order_users.task_id', '=', 'tasks.id')->where('task_order_users.user_id', '=', $user_id);
            })
            ->max('task_order_users.position');
        
        if( $position == null ) $position = 0;
        else $position++;

        TaskOrderUser::create([
            'task_id' => $task_id,
            'user_id' => $user_id,
            'position' => $position
        ]);
    }

    public function view(Request $request, Task $task) {
        $user = Auth::user();
        $taskMedias = TaskMedia::with('media')->where('task_id', $task->id)->get();
        $taskLinks = TaskLink::where('task_id', $task->id)->get();
        $taskCollaboratos = TaskCollaborator::where('task_id', $task->id)->get();
        $childs = Task::where('parent_id', $task->id)->orderBy('date_delivery', 'asc')->get();
        $comments = $task->comments()->with('user')->with('commentmedias')->orderBy('created_at', 'desc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();
        $users = User::where('business_id', $user->business_id)->orderBy('name')->orderBy('last_name')->get();

        $userIsPartOfTask = false;
        foreach( $task->collaborators as $collaborator ){
            if( $collaborator->user_id == $user->id ) $userIsPartOfTask = true;
        }
        if( $task->user_id == $user->id || $task->user_assign == $user->id ) $userIsPartOfTask = true;

        $parent = null;
        if( $task->parent != null ){
            $parent = [
                'parent' => $task->parent,
                'childs' => Task::with('assign')->where('parent_id', $task->parent->id)->orderBy('date_delivery', 'asc')->get()
            ];
        }

        $params = [
            'task' => $task,
            'taskMedias' => $taskMedias,
            'taskLinks' => $taskLinks,
            'taskCollaboratos' => $taskCollaboratos,
            'childs' => $childs,
            'comments' => $comments,
            'userIsPartOfTask' => $userIsPartOfTask,
            'brands' => $brands,
            'parent' => $parent,
            'users' => $users
        ];

        HistoryHelper::save(Auth::user(), 'task: ' . $task->id);
        return view('task.view', $params);
    }

    //FUNCIONES PARA LLAMAR AL FORMULARIO CON DATOS
    public function subtask(Request $request, Task $task) {
        $brands = Brand::orderBy('name', 'asc')->get();
        $params = [
            'model' => new Task(),
            'brands' => $brands,
            'task' => $task
        ];

        return view('task.create', $params);
    }

    public function user(Request $request, User $user) {
        $brands = Brand::orderBy('name', 'asc')->get();
        $params = [
            'model' => new Task(),
            'brands' => $brands,
            'user' => $user
        ];

        return view('task.create', $params);
    }

    public function brand(Request $request, Brand $brand) {
        $brands = Brand::orderBy('name', 'asc')->get();
        $params = [
            'model' => new Task(),
            'brands' => $brands,
            'brand' => $brand
        ];

        return view('task.create', $params);
    }
}