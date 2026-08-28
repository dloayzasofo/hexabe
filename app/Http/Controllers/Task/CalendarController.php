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
                $query->where('user_assign', $user->id)->orWhere('user_id', $user->id);
            })
            ->orderBy('position', 'asc')
            ->get();

        $data = [];
        foreach($tasks as $task){
            /*
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
            */
            $data = array_merge($data, $this->getTaskByRangeDate($task));
        }

        $params = [
            'success' => true,
            'data' => $data
        ];

        return response()->json($params);
    }

    public function getTaskByRangeDate($task){
        $dateIni = Carbon::parse($task->date_ini);
        $dateDelivery = Carbon::parse($task->date_delivery);
        $result = [];

        if( $dateIni->isSameDay($dateDelivery) OR $task->date_ini == null ){
            $result[] = [
                'id' => $task->id,
                'title' => $task->title,
                'status' => $task->status,
                'date_ini' => $task->date_ini,
                'date_delivery' => $task->date_delivery,
                'hours' => $this->calcTimeSameDay($task),
                'assign' => [
                    'id' => $task->assign->id,
                    'name' => $task->assign->name,
                    'last_name' => $task->assign->last_name,
                    'image' => $task->assign->image,
                    'nameInitial' => $task->assign->nameInitial,
                ]
            ];
        }else{
            while( $dateIni->lt($dateDelivery) ){
                $result[] = [
                    'id' => $task->id,
                    'title' => $task->title,
                    'status' => $task->status,
                    'date_ini' => $task->date_ini,
                    'date_delivery' => $dateIni->format('Y-m-d'),
                    'hours' => $this->calcTimeDiffDay($task, $dateIni),
                    'assign' => [
                        'id' => $task->assign->id,
                        'name' => $task->assign->name,
                        'last_name' => $task->assign->last_name,
                        'image' => $task->assign->image,
                        'nameInitial' => $task->assign->nameInitial,
                    ]
                ];
                $dateIni->addDay();
            }
        }

        return $result;
    }

    public function calcTimeSameDay($task){
        $dateIni = Carbon::parse($task->date_ini);
        $dateDelivery = Carbon::parse($task->date_delivery);
        $hours = $dateIni->diffInHours($dateDelivery);

        if( $dateIni->hour < 12 AND $dateDelivery->hour > 14 ){
            $hours -= 2;
        }

        $result = $this->getHoursWorkedLiteralAttribute($hours);
        if($task->date_ini == null ){
            return '-';
        }

        return $result;
    }

    public function calcTimeDiffDay($task, $date){
        $dateIni = Carbon::parse($task->date_ini);
        $dateDelivery = Carbon::parse($task->date_delivery);

        $hours = 0;
        if( $dateIni->isSameDay($date) ){
            $hourEndDay = Carbon::parse($dateIni->format('Y-m-d') . ' 18:30:00');
            $hours = $dateIni->diffInHours($hourEndDay);
            if( $dateIni->hour < 12 ){
                $hours -= 2;
            }
        }elseif( $dateDelivery->isSameDay($date) ){
            $hourIniDay = Carbon::parse($dateDelivery->format('Y-m-d') . ' 08:30:00');
            $hours = $hourIniDay->diffInHours($dateDelivery);
            if( $dateDelivery->hour > 14 ){
                $hours -= 2;
            }
        }else{
            $hours = 8;
        }

        $result = $this->getHoursWorkedLiteralAttribute($hours);
        return $result;
    }

    public function getHoursWorkedLiteralAttribute($countHours){
        $countHours = round($countHours, 2);
        $hour = floor($countHours);

        $minutes = ($countHours - $hour) * 60;
        $result = "";

        if( $hour > 0 ){
            $result = $hour . "h "; 
        }
        if( $minutes > 0 ){
            $result .= intval($minutes) . "m";
        }
        return $result;
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