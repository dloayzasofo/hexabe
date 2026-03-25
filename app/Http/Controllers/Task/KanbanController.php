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
        $tasks = Task::all();
        $params = [
            'tasks' => $tasks
        ];

        return view('task.kanban.index', $params);
    }
}