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
        $users = User::where('business_id', $user->business_id)->orderBy('name', 'desc')->get();
        $brands = Brand::where('business_id', $user->business_id)->orderBy('name', 'desc')->get();

        $params = [
            'brands'=> $brands,
            'users'=> $users
        ];

        return view('report.calendar', $params);
    }

    public function list(Request $request) {
        $user = Auth::user();
        $dateIni = Carbon::parse($request->input('date_ini'));
        $dateEnd = Carbon::parse($request->input('date_end'));

        $query = Task::with('brand', 'assign', 'collaborators')
            ->orWhere(function($query) use ($dateIni, $dateEnd) {
                $query->whereBetween('date_ini', [$dateIni->format('Y-m-d'), $dateEnd->format('Y-m-d')])
                ->orWhereBetween('date_delivery', [$dateIni->format('Y-m-d'), $dateEnd->format('Y-m-d')]);
            });

        $userId = $request->input('user');
        $brandId = $request->input('brand');
        if( $userId != 'all' ){
            $query = $query->where('user_assign', $userId);
        }
        if( $brandId != 'all' ){
            $query = $query->where('brand_id', $brandId);
        }

        $tasks = $query->get();
        $data = [];
        foreach($tasks as $task){
            $data = array_merge($data, $this->getTaskData($task));
        }

        $dates = [];
        while( $dateIni->lt($dateEnd) ){
            $date = $dateIni->format('Y-m-d');
            $hoursByDate = $this->getHoursTotalByDate($data, $date);
            $dates[] = [
                'date' => $date,
                'hours' => $hoursByDate['hours'],
                'hour_literal' => $hoursByDate['hour_literal'],
                'have_task' => $hoursByDate['have_task']
            ];
            $dateIni->addDay();
        }

        $params = [
            'success' => true,
            'data' => $data,
            'dates' => $dates
        ];
        return response()->json($params);
    }
    
    public function getHoursTotalByDate($tasks, $date){
        $hours = 0;
        $hours_literal = '0m';
        $have_task = 0;

        foreach( $tasks as $task ){
            $taskDayData = $this->calcRealHoursByDate($task, $date);
            $task['status'] = $taskDayData['status'];
            if( $task['date'] == $date ){
                $have_task += 1;
                $hours += $taskDayData['hours'];
            }
        }

        if( $hours > 0 ){
            $hours_literal = $this->getHoursWorkedLiteralAttribute($hours);
        }

        return [
            'hours' => $hours,
            'hour_literal' => $hours_literal,
            'have_task' => $have_task
        ];
    }

    public function calcRealHoursByDate($task, $date){
        $timeControls = TimeControl::where('task_id', $task['id'])
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'asc')
            ->get();

        $hours = 0;
        $flagSum = false;
        $lastDate = null;
        $lastStatus = '';

        //Calcular la hora si dentro del dia no hay ningun estado
        if( count($timeControls) == 0 ){
            $taskModel = Task::find($task['id']);
            $lastStatus = $this->getTaskStatusByDate($taskModel, Carbon::parse($date));
            if( $lastStatus == 'PROCESS' ){
                $hours = 8;
            }
            return [
                'hours' => $hours,
                'status' => $lastStatus
            ];
        }
        
        //Calcular la hora si dentro del día hay varios estado de la tarea
        //va sumando los intervalos
        $lastDateToExeptionCalc = null;
        foreach( $timeControls as $timeControl ){
            if( $timeControl->status == 'PROCESS' ){
                $flagSum = true;
                $lastDate = Carbon::parse($timeControl->created_at);

            }else{
                if( $flagSum ){
                    $currentDate = Carbon::parse($timeControl->created_at);
                    $hours += $lastDate->diffInHours($currentDate);
                    if( $this->isLessThan12_30($lastDate) AND $this->isGreaterThan14_30($currentDate) ){
                        $hours -= 2;
                    }
                    $flagSum = false;
                    $lastDate = Carbon::parse($timeControl->created_at);
                }
            }
            $lastDateToExeptionCalc = Carbon::parse($timeControl->created_at);
            $lastStatus = $timeControl->status;
        }

        //Si el estado del día es PROCESS y no hay estado de finalizacion en este dia se
        //debe calcular hasta las 18:30
        if($lastStatus == 'PROCESS' AND $hours == 0){
            $dateOut = Carbon::parse($date . ' 18:30:00');
            $hours = $lastDate->diffInHours($dateOut);
            if( $this->isLessThan12_30($lastDate) ){
                $hours -= 2;
            }
        }

        //Si el estado es FINALIZED y no tiene un estado de inicio en el dia se debe
        //calcular desde las 8:30 de la mañana
        if( ($lastStatus == 'FINALIZED' OR $lastStatus == 'FINALIZED_DELAY') AND $hours == 0){
            $dateIn = Carbon::parse($date . ' 08:30:00');
            $hours = $dateIn->diffInHours($lastDateToExeptionCalc);
            if( $this->isGreaterThan14_30($lastDateToExeptionCalc) ){
                $hours -= 2;
            }
        }

       
        return [
            'hours' => $hours,
            'status' => $lastStatus
        ];
    }

    public function getTaskStatusByDate($task, $date){
        $timeControls = TimeControl::where('task_id', $task['id'])
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'desc')
            ->first();

        //Si la fecha es mayor a la fecha actual, deberia estar sin empezar
        if( $date->gt(Carbon::now()) ){
            return "TOSTART";
        }

        if( $task->date_ini == null OR $date->lt(Carbon::parse($task->date_ini)) ){
            if( $task->date_delivery == $date->format('Y-m-d') ){
                return $task->status;
            }else{
                return "TOSTART";
            }
        }

        if( $timeControls == null ){
            $newDate = $date->clone()->subDay();
            return $this->getTaskStatusByDate($task, $newDate);
        }else{
            return $timeControls->status;
        }
    }

    public function isLessThan12_30($date){
        $dateCompare = $date->clone();
        $date->hour = 12;
        $date->minute = 30;
        $date->second = 0;

        if( $dateCompare->lt($date) ){
            return true;
        }
        return false;
    }

    public function isGreaterThan14_30($date){
        $dateCompare = $date->clone();
        $date->hour = 14;
        $date->minute = 30;
        $date->second = 0;

        if( $dateCompare->gt($date) ){
            return true;
        }
        return false;
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
                $status = $this->getTaskStatusByDate($task, $dateIni);
                $result[] = [
                    'id' => $task->id,
                    'title' => $task->title,
                    'status' => $status,
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
        //var_dump($result); exit();
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

    public function pie(Request $request){
        $user = Auth::user();
        $dateIni = Carbon::parse($request->input('date_ini'));
        $dateEnd = Carbon::parse($request->input('date_end'));
        $userId = $request->input('user');

        $query = Task::with('brand', 'assign', 'collaborators')
            ->orWhere(function($query) use ($dateIni, $dateEnd) {
                $query->whereBetween('date_ini', [$dateIni->format('Y-m-d'), $dateEnd->format('Y-m-d')])
                ->orWhereBetween('date_delivery', [$dateIni->format('Y-m-d'), $dateEnd->format('Y-m-d')]);
            });

        if( $userId != 'all' ){
            $query = $query->where('user_assign', $userId);
        }

        $brands = Brand::where('business_id', $user->business_id)
            ->orderBy('name', 'asc')
            ->get();
            
        $result = [];
        foreach($brands as $brand){
            $queryClone = clone $query;
            $result[] = [
                "id"=> $brand->id,
                "name"=> $brand->name,
                "count"=> $queryClone->where('brand_id', $brand->id)->count()
            ];
        }

        return response()->json(['success' => true, 'data' => $result], 200);
    }
}