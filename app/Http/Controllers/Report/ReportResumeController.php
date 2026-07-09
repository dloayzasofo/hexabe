<?php 

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\User;
use App\Models\Brand;
use App\Models\Team;
use App\Models\TeamUser;
use Auth;
use Carbon\Carbon;

class ReportResumeController extends Controller {
 
    public function index(Request $request) {
        $user = Auth::user();
        $statuses = ['TOSTART'=> 'Sin empezar', 'PROCESS'=> 'En proceso', 'FINALIZED'=> 'Finalizado', 'DELAY'=> 'Atrasado', 'PAUSED'=> 'Pausado'];
        $users = User::select('id', 'name', 'last_name', 'media_id')->where('business_id', $user->business_id)->orderBy('name', 'asc')->orderBy('last_name', 'asc')->get();
        $teams = Team::select('id', 'name', 'media_id')->where('business_id', $user->business_id)->orderBy('name', 'asc')->get();
        $brands = Brand::select('id', 'name', 'media_id')->where('business_id', $user->business_id)->orderBy('name', 'asc')->get();

        $params = [
            "users"=> $users,
            "teams"=> $teams,
            "brands"=> $brands,
            "status"=> $statuses,
        ];

        return view('report.resume', $params);
    }

    public function stats(Request $request) {
        $statuses = ['TOSTART'=> 'Sin empezar', 'PROCESS'=> 'En proceso', 'FINALIZED'=> 'Finalizado', 'DELAY'=> 'Atrasado', 'PAUSED'=> 'Pausado'];
        $date = $request->query('date');
        $member = $request->query('member');
        $team = $request->query('team');
        $brand = $request->query('brand');
        $status = $request->query('status');
        if( $date == null ) $date = 'year';

        $user = Auth::user();
        $query = Task::with('brand', 'assign')
            ->whereHas('assign')
            ->where('business_id', $user->business_id);

        $year = Carbon::now()->year;
        $date_ini = Carbon::now()->startOfYear();
        $date_end = Carbon::now()->endOfYear();

        if( $date == 'month' ){
            $date_ini = Carbon::now()->startOfMonth();
            $date_end = Carbon::now()->endOfMonth();
        }
        if( $date == 'week' ){
            $date_ini = Carbon::now()->startOfWeek();
            $date_end = Carbon::now()->endOfWeek();
        }
        if( $date == 'today' ){
            $date_ini = Carbon::now()->startOfDay();
            $date_end = Carbon::now()->endOfDay();
        }
        if( $date == 'custom' ){
            $date_ini = Carbon::parse($request->query('start'));
            $date_end = Carbon::parse($request->query('end'));
        }

        $models = [
            "member" => null,
            "team" => null,
            "brand" => null,
            "status" => null
        ];

        if( $member != null AND $member != 'all' ) {
            $query = $query->where('user_assign', $member);
            $models['member'] = User::select('id', 'name', 'last_name')->find($member);
        }

        if( $team != null AND $team != 'all' ) {
            $teamUsers = TeamUser::with('user')->where('team_id', $team)->get();
            $members = [];
            foreach ($teamUsers as $teamUser) {
                if( $teamUser->user == null ) continue;
                $members[] = $teamUser->user->id;
            }
            $models['team'] = Team::select('id', 'name')->find($team);
            $query = $query->whereIn('user_assign', $members);
        }

        if( $brand != null AND $brand != 'all' ) {
            $query = $query->where('brand_id', $brand);
            $models['brand'] = Brand::select('id', 'name')->find($brand);
        }

        if( $status != null AND $status != 'all' ) {
            $query = $query->where('status', $status);
            $models['status'] = [
                'key' => $status,
                'value' => $statuses[$status]
            ];
        }

        $graph = $this->getStatByYear(clone $query);
        if( $date == 'month' ){
            $graph = $this->getStatByMonth(clone $query);
            }
        if( $date == 'week' ){
            $graph = $this->getStatByWeek(clone $query);
        }
        if( $date == 'today' ){
            $graph = $this->getStatByDay(clone $query);
        }
        if( $date == 'today' ){
            $graph = $this->getStatByMonth(clone $query);
        }
        if( $date == 'custom' ){
            $graph = $this->getStatByCustom(clone $query, $date_ini->clone(), $date_end->clone());
        }

        $query = $query->where('date_delivery', '>=', $date_ini)
                ->where('date_delivery', '<=', $date_end);

        //var_dump($request->query('start') . ' ' . $request->query('end'));
        //var_dump($date_ini->format('Y-m-d') . ' ' . $date_end->format('Y-m-d'));
        //var_dump($query->toRawSql());exit();

        $queryStatusTostart = clone $query;
        $queryStatusProcess = clone $query;
        $queryStatusFinalized = clone $query;
        $queryStatusDelay = clone $query;
        $queryStatusPaused = clone $query;
        $tasksPaginate = clone $query;
        $taskTotals = $query->get();
        $tasksPaginate = $tasksPaginate->orderBy('updated_at', 'desc')->paginate(10);
                
        $queryTostart = $queryStatusTostart->where('status', 'TOSTART')->count();
        $queryProcess = $queryStatusProcess->where('status', 'PROCESS')->count();
        $queryFinalized = $queryStatusFinalized->where('status', 'FINALIZED')->count();
        $queryDelay = $queryStatusDelay->where('status', 'DELAY')->count();
        $queryPaused = $queryStatusPaused->where('status', 'PAUSED')->count();
        $queryTotal = count($taskTotals);

        $hours = $this->getHoursAvarage($taskTotals);
        $params = [
            "inputs" => [
                'date' => $date,
                'member' => $member,
                'team' => $team,
                'brand' => $brand,
                'status' => $status
            ],
            "models" => $models,
            "stats" => [
                "total" => $queryTotal,
                "tostart" => $queryTostart,
                "process" => $queryProcess,
                "delay" => $queryDelay,
                "paused" => $queryPaused,
                "finalized" => $queryFinalized
            ],

            "graph" => $graph,
            "hours" => $hours,
            "tasks" => $tasksPaginate
        ];
        return response()->json(["success"=> true, "data"=> $params]);
    }

    public function members(Request $request) {
        $user = Auth::user();
        $result = [];
        $users = User::where('business_id', $user->business_id)->orderBy('name', 'asc')->orderBy('last_name', 'asc')->get();

        foreach($users as $item){
            $tasks = Task::where('business_id', $user->business_id)->where('user_assign', $item->id)->get();
            $hours = $this->getHoursAvarage($tasks);
            $stats = $this->getStatToTasks($tasks);
            $result[] = [
                "id" => $item->id,
                "name" => $item->name,
                "last_name" => $item->last_name,
                "image" => $item->image,
                "nameInitial" => $item->nameInitial,
                "position" => $item->position,
                "hours" => $hours,
                "stats" => $stats
            ];
        }

        return response()->json(["success"=> true, "data"=> $result]);
    }

    public function teams(Request $request) {
        $user = Auth::user();
        $result = [];
        $teams = Team::where('business_id', $user->business_id)->get();

        foreach($teams as $item){
            $teamUsers = TeamUser::with('user')->where('team_id', $item->id)->get();
            $tasks = Task::where('business_id', $user->business_id)->whereIn('user_assign', $teamUsers->pluck('user_id'))->get();
            $hours = $this->getHoursAvarage($tasks);
            $stats = $this->getStatToTasks($tasks);
            $users = [];

            foreach($teamUsers as $teamuser) {
                if( $teamuser->user == null ) continue;
                $users[] = [
                    "id" => $teamuser->user_id,
                    "name" => $teamuser->user->name,
                    "last_name" => $teamuser->user->last_name,
                    "image" => $teamuser->user->image,
                    "nameInitial" => $teamuser->user->nameInitial,
                    "position" => $teamuser->user->position,
                ];
            }
            
            $result[] = [
                "id" => $item->id,
                "name" => $item->name,
                "image" => $item->image,
                "hours" => $hours,
                "stats" => $stats,
                "users" => $users
            ];
        }

        return response()->json(["success"=> true, "data"=> $result]);
    }

    public function brands(Request $request) {
        $user = Auth::user();
        $result = [];
        $brands = Brand::where('business_id', $user->business_id)->get();

        foreach($brands as $item){
            $barndUsers = $item->members;
            $tasks = Task::where('business_id', $user->business_id)->where('brand_id', $item->id)->get();
            $hours = $this->getHoursAvarage($tasks);
            $stats = $this->getStatToTasks($tasks);
            $users = [];

            foreach($barndUsers as $brandUser) {
                $users[] = [
                    "id" => $brandUser->id,
                    "name" => $brandUser->name,
                    "last_name" => $brandUser->last_name,
                    "image" => $brandUser->image,
                    "nameInitial" => $brandUser->nameInitial,
                    "position" => $brandUser->position,
                ];
            }
            
            $result[] = [
                "id" => $item->id,
                "name" => $item->name,
                "image" => $item->image,
                "hours" => $hours,
                "stats" => $stats,
                "users" => $users
            ];
        }

        return response()->json(["success"=> true, "data"=> $result]);
    }

    private function getHoursAvarage($tasks){
        $total = 0;
        $hours = 0;

        foreach($tasks as $task){
            if( $task->hoursWorked !== null ){
                $total += 1;
                $hours += $task->hoursWorked;
            }
        }

        $countHours = $total == 0 ? 0 : $hours / $total;
        $result = [
            "average" => intval($countHours),
            "days"=> 0,
            "hours"=> 0,
            "minutes"=> 0
        ];

        if($countHours > 8){
            $days = floor($countHours / 8);
            $hours = $countHours % 8;

            $countHours = round($countHours, 2);
            $hour = floor($countHours);

            $minutes = ($countHours - $hour) * 60;
            $result['days'] = $days;


            if( $hours > 0 OR $minutes > 0 ){
                $result['hours'] = $hours;
            }
            if( $minutes > 0 ){
                $result['minutes'] = intval($minutes);
            }
            return $result;
        }
        
        $countHours = round($countHours, 2);
        $hour = floor($countHours);
        $minutes = ($countHours - $hour) * 60;

        if( $hour > 0 ){
            $result['hours'] = $hour;
        }
        if( $minutes > 0 ){
            $result['minutes'] = intval($minutes);
        }

        return $result;
    }

    /**
     * Get stats total tasks by months and status
     * @return array [[month=>1, total=>4, tostart=>1, process=>2, finalized=>1, delay=>1, paused=>1], ...]
     */
    private function getStatByYear($query){
        //var_dump($query->toSql());exit();
        $months = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        $result = [];
        $year = Carbon::now()->year;

        for($i = 0; $i < count($months); $i++){
            $queryYear = clone $query;
            $month = $months[$i];
            $queryYear = $queryYear->whereMonth('date_delivery', $month)
                            ->whereYear('date_delivery', $year);

            $queryTostart = clone $queryYear;
            $queryProcess = clone $queryYear;
            $queryFinalized = clone $queryYear;
            $queryDelay = clone $queryYear;
            $queryPaused = clone $queryYear;

            $total = $queryYear->count();
            $tostart = $queryTostart->where('status', 'TOSTART')->count();
            $process = $queryProcess->where('status', 'PROCESS')->count();
            $finalized = $queryFinalized->where('status', 'FINALIZED')->count();
            $delay = $queryDelay->where('status', 'DELAY')->count();
            $paused = $queryPaused->where('status', 'PAUSED')->count();

            $result[] = [
                "month" => $month,
                "total" => $total,
                "tostart" => $tostart, //($total == 0) ? 0 : $tostart * 100 / $total,
                "process" => $process, //($total == 0) ? 0 : $process * 100 / $total,
                "delay" => $delay, //($total == 0) ? 0 : $delay * 100 / $total,
                "paused" => $paused, //($total == 0) ? 0 : $paused * 100 / $total,
                "finalized" => $finalized //($total == 0) ? 0 : $finalized * 100 / $total
            ];
        }
        return $result;
    }

    private function getStatByMonth($query){
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $query = $query->whereMonth('date_delivery', $month)
                ->whereYear('date_delivery', $year);
        
        $queryTostart = clone $query;
        $queryProcess = clone $query;
        $queryFinalized = clone $query;
        $queryDelay = clone $query;
        $queryPaused = clone $query;

        $total = $query->count();
        $tostart = $queryTostart->where('status', 'TOSTART')->count();
        $process = $queryProcess->where('status', 'PROCESS')->count();
        $finalized = $queryFinalized->where('status', 'FINALIZED')->count();
        $delay = $queryDelay->where('status', 'DELAY')->count();
        $paused = $queryPaused->where('status', 'PAUSED')->count();
        $result[] = [
            "month" => $month,
            "total" => $total,
            "tostart" => $tostart, //($total == 0) ? 0 : $tostart * 100 / $total,
            "process" => $process, //($total == 0) ? 0 : $process * 100 / $total,
            "delay" => $delay, //($total == 0) ? 0 : $delay * 100 / $total,
            "paused" => $paused, //($total == 0) ? 0 : $paused * 100 / $total,
            "finalized" => $finalized //($total == 0) ? 0 : $finalized * 100 / $total
        ];
        return $result;
    }

    private function getStatByWeek($query){
        $months = [1, 2, 3, 4, 5, 6, 7];
        $result = [];

        $dayInitial = Carbon::now()->startOfWeek();
        $dayFinal = Carbon::now()->endOfWeek();

        while( $dayInitial <= $dayFinal ){
            $queryDay = clone $query;
            $day = $dayInitial->format('d-m-Y');
            $queryDay = $queryDay->where('date_delivery', $dayInitial->format('Y-m-d'));
            
            $queryTostart = clone $queryDay;
            $queryProcess = clone $queryDay;
            $queryFinalized = clone $queryDay;
            $queryDelay = clone $queryDay;
            $queryPaused = clone $queryDay;

            $total = $queryDay->count();
            $tostart = $queryTostart->where('status', 'TOSTART')->count();
            $process = $queryProcess->where('status', 'PROCESS')->count();
            $finalized = $queryFinalized->where('status', 'FINALIZED')->count();
            $delay = $queryDelay->where('status', 'DELAY')->count();
            $paused = $queryPaused->where('status', 'PAUSED')->count();

            $result[] = [
                "day" => $day,
                "total" => $total,
                "tostart" => $tostart, //($total == 0) ? 0 : $tostart * 100 / $total,
                "process" => $process, //($total == 0) ? 0 : $process * 100 / $total,
                "delay" => $delay, //($total == 0) ? 0 : $delay * 100 / $total,
                "paused" => $paused, //($total == 0) ? 0 : $paused * 100 / $total,
                "finalized" => $finalized //($total == 0) ? 0 : $finalized * 100 / $total
            ];
            

            $dayInitial->addDay();
        }
        return $result;
    }

    private function getStatByDay($query){
        $day = Carbon::now()->format('Y-m-d');
        $query = $query->where('date_delivery', $day);
        
        $queryTostart = clone $query;
        $queryProcess = clone $query;
        $queryFinalized = clone $query;
        $queryDelay = clone $query;
        $queryPaused = clone $query;

        $total = $query->count();
        $tostart = $queryTostart->where('status', 'TOSTART')->count();
        $process = $queryProcess->where('status', 'PROCESS')->count();
        $finalized = $queryFinalized->where('status', 'FINALIZED')->count();
        $delay = $queryDelay->where('status', 'DELAY')->count();
        $paused = $queryPaused->where('status', 'PAUSED')->count();

        $result[] = [
            "day" => Carbon::now()->dayOfWeek - 1,
            "total" => $total,
            "tostart" => $tostart, //($total == 0) ? 0 : $tostart * 100 / $total,
            "process" => $process, //($total == 0) ? 0 : $process * 100 / $total,
            "delay" => $delay, //($total == 0) ? 0 : $delay * 100 / $total,
            "paused" => $paused, //($total == 0) ? 0 : $paused * 100 / $total,
            "finalized" => $finalized //($total == 0) ? 0 : $finalized * 100 / $total
        ];

        return $result;
    }

    private function getStatByCustom($query, $date_ini, $date_end){
        $dayInitial = $date_ini;
        $dayFinal = $date_end;
        $result = [];

        while( $dayInitial <= $dayFinal ){
            $queryDay = clone $query;
            $day = $dayInitial->format('d-m-Y');
            $queryDay = $queryDay->where('date_delivery', $dayInitial->format('Y-m-d'));
            
            $queryTostart = clone $queryDay;
            $queryProcess = clone $queryDay;
            $queryFinalized = clone $queryDay;
            $queryDelay = clone $queryDay;
            $queryPaused = clone $queryDay;

            $total = $queryDay->count();
            $tostart = $queryTostart->where('status', 'TOSTART')->count();
            $process = $queryProcess->where('status', 'PROCESS')->count();
            $finalized = $queryFinalized->where('status', 'FINALIZED')->count();
            $delay = $queryDelay->where('status', 'DELAY')->count();
            $paused = $queryPaused->where('status', 'PAUSED')->count();

            $result[] = [
                "date" => $dayInitial->format('d/m/Y'),
                "total" => $total,
                "tostart" => $tostart, //($total == 0) ? 0 : $tostart * 100 / $total,
                "process" => $process, //($total == 0) ? 0 : $process * 100 / $total,
                "delay" => $delay, //($total == 0) ? 0 : $delay * 100 / $total,
                "paused" => $paused, //($total == 0) ? 0 : $paused * 100 / $total,
                "finalized" => $finalized //($total == 0) ? 0 : $finalized * 100 / $total
            ];
            

            $dayInitial->addDay();
        }
        return $result;
    }

    private function getStatToTasks($tasks){
        $result = [
            "total" => count($tasks),
            "tostart" => 0,
            "process" => 0,
            "delay" => 0,
            "paused" => 0,
            "finalized" => 0
        ];

        foreach($tasks as $task){
            switch($task->status){
                case "TOSTART":
                    $result['tostart'] += 1;
                    break;
                case "PROCESS":
                    $result['process'] += 1;
                    break;
                case "DELAY":
                    $result['delay'] += 1;
                    break;
                case "PAUSED":
                    $result['paused'] += 1;
                    break;
                case "FINALIZED":
                    $result['finalized'] += 1;
                    break;
            }
        }
        return $result;
    }

}
