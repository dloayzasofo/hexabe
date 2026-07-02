<?php 

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\NotificationHelper;
use Illuminate\Support\Str;
use App\Models\Task;
use App\Models\TimeControl;
use Auth;

class DelayTasksController extends Controller {
 
    public function delaytasks(Request $request, $token) {
        if( $token != env('APP_TOKEN_CRON') ){
            echo 'Token invalido';
            return;
        }

        $tasks = Task::whereIn('status', ['TOSTART', 'PROCESS'])
            ->whereDate('date_delivery', '<', date('Y-m-d'))
            ->get();

        $count = 0;
        foreach( $tasks as $task ) {
            $task->status = 'DELAY';
            $task->save();
            $count++;
            NotificationHelper::send(
                $task->assign, 
                'Tarea "' . Str::limit($task->title, 12) . '" ha sido marcada como Retrasada.', 
                $task->title,
                'CRON',
                $task->id,
                null,
                route('task.view', ['task' => $task->id]),
                $task->priority
            );

            $timeControl = new TimeControl();
            $timeControl->task_id = $task->id;
            $timeControl->user_id = null;
            $timeControl->status = $task->status;
            $timeControl->save();
        }

        echo $count . ' Tareas marcadas como retrasadas';
        return;
    }

}