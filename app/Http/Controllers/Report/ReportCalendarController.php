<?php 

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use App\Http\Requests\TeamRequest;
use App\Models\Brand;
use App\Models\Task;
use App\Models\TaskMedia;
use App\Models\TaskCollaborator;
use App\Models\TimeControl;
use App\Models\TeamUser;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class ReportCalendarController extends Controller {
 
    public function index() {
        $user = Auth::user();
        return view('report.calendar', []);
    }

    public function list(Request $request) {
        $user = Auth::user();
        $dateIni = $request->input('date_ini');
        $dateEnd = $request->input('date_end');

        $tasks = Task::with('brand', 'assign', 'collaborators')
            ->whereBetween('date_delivery', [$dateIni, $dateEnd])
            ->where('user_assign', $user->id)
            ->get();

        $data = [];
        foreach($tasks as $task){
            $data = array_merge($data, $this->getTaskData($task));
        }

        $params = [
            'success' => true,
            'data' => $data
        ];
        return response()->json($params);
    }

    public function getTaskData($task){
        $dateIni = Carbon::parse($task->date_ini);
        $dateEnd = Carbon::parse($task->date_delivery);
        if( isset($task->finalized_at) ){
            $dateEnd = Carbon::parse($task->finalized_at);
        }
        
        $result = [];
        if( $dateIni->isSameDay($dateEnd) OR $task->date_ini == null ){
            $hours = $this->calcTimeSameDay($task);
            $result[] = [
                'id' => $task->id,
                'title' => $task->title,
                'status' => $task->status,
                'date' => $dateEnd->format('Y-m-d'),
                'date_ini' => $task->date_ini,
                'date_end' => $task->finalized_at,
                'date_delivery' => $task->date_delivery,
                'hours' => $hours['hours'],
                'hour_literal' => $hours['hour_literal'],
                'assign' => [
                    'id' => $task->assign->id,
                    'name' => $task->assign->name,
                    'last_name' => $task->assign->last_name,
                    'image' => $task->assign->image,
                    'nameInitial' => $task->assign->nameInitial,
                ]
            ];
        }else{
            while( $dateIni->lt($dateEnd) ){
                $hours = $this->calcTimeDiffDay($task, $dateIni);
                $result[] = [
                    'id' => $task->id,
                    'title' => $task->title,
                    'status' => $task->status,
                    'date' => $dateIni->format('Y-m-d'),
                    'date_ini' => $task->date_ini,
                    'date_end' => $task->finalized_at,
                    'date_delivery' => $dateIni->format('Y-m-d'),
                    'hours' => $hours['hours'],
                    'hour_literal' => $hours['hour_literal'],
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
        $dateEnd = Carbon::parse($task->date_delivery);
        if( isset($task->finalized_at) ){
            $dateEnd = Carbon::parse($task->finalized_at);
        }

        $hours = 0;
        $hour_literal = '-';
        if( $task->date_ini != null ){
            $hours = $dateIni->diffInHours($dateEnd);
            if( $dateIni->hour < 12 AND $dateEnd->hour > 14 ){
                $hours -= 2;
            }
            $hour_literal = $this->getHoursWorkedLiteralAttribute($hours);
        }

        return [
            'hours' => $hours,
            'hour_literal' => $hour_literal
        ];
    }

    public function calcTimeDiffDay($task, $date){
        $dateIni = Carbon::parse($task->date_ini);
        $dateEnd = Carbon::parse($task->date_delivery);
        if( isset($task->finalized_at) ){
            $dateEnd = Carbon::parse($task->finalized_at);
        }

        $hours = 0;
        $hour_literal = '-';
        if( $dateIni->isSameDay($date) ){
            $hourEndDay = Carbon::parse($dateIni->format('Y-m-d') . ' 18:30:00');
            $hours = $dateIni->diffInHours($hourEndDay);
            if( $dateIni->hour < 12 ){
                $hours -= 2;
            }
        }elseif( $dateEnd->isSameDay($date) ){
            $hourIniDay = Carbon::parse($dateEnd->format('Y-m-d') . ' 08:30:00');
            $hours = $hourIniDay->diffInHours($dateEnd);
            if( $dateEnd->hour > 14 ){
                $hours -= 2;
            }
        }else{
            $hours = 8;
        }

        $hour_literal = $this->getHoursWorkedLiteralAttribute($hours);
        return [
            'hours' => $hours,
            'hour_literal' => $hour_literal
        ];
    }

    public function getHoursWorked($task, $date){
        $dateIni = Carbon::parse($task->date_ini);
        $dateEnd = Carbon::parse($task->date_delivery);
        if( isset($task->finalized_at) ){
            $dateEnd = Carbon::parse($task->finalized_at);
        }
        
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
}