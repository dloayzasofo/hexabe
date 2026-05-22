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
use App\Models\TeamUser;
use App\Models\TaskLink;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class TaskSearchController extends Controller {
 
    public function search(Request $request) {
        $user = Auth::user();
        $search = $request->query('s');
        
        $tasks = Task::with('assign')->where('business_id', $user->business_id)
            ->where('title', 'LIKE', "%$search%")
            ->orWhere('description', 'LIKE', "%$search%")
            ->orWhereHas('brand', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })
            ->orWhereHas('collaborators.user', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%");
            })
            ->limit(10)
            ->get();

        $results = $tasks->map(function ($task) {
            return [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,               
                'brand' => $task->brand->name,
                'date_delivery' => Carbon::parse($task->date_delivery)->format('d/m/Y'),
                'status' => $task->status,
                'user_assign' => [
                    'id' => $task->assign->id,
                    'nameInitial' => $task->assign->nameInitial,
                    'email' => $task->assign->email,
                    'image' => $task->assign->image
                ]
            ];
        });

        $params = [
            'success' => true,
            'data' => $results,
            'results_count' => $results->count()
        ];

        return response()->json($params);
    }
}