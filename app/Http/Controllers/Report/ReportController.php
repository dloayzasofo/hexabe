<?php 

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\User;
use Auth;

class ReportController extends Controller {
 
    public function index() {
        $user = Auth::user();
        $taskComplete = Task::where('business_id', $user->business_id)->where('status', 'FINALIZED')->count();
        $avergeDate = DB::select('SELECT avg(DATEDIFF(date_delivery, created_at)) AS avergedate FROM tasks where business_id = ?', [$user->business_id]);
        $avergeDate = round($avergeDate[0]->avergedate, 1);
        
        $users = User::where('business_id', $user->business_id)->get();
        $team = [];
        $efficiencyTeam = [];
        foreach ($users as $item) {
            $totalTask = $item->totalTask();
            $efficiency = $item->efficiency();
            $team[] = [
                'id'=> $item->id,
                'name'=> $item->name,
                'last_name'=> $item->last_name,
                'email'=> $item->email,
                'position'=> $item->position,
                'image'=> $item->image,
                'nameInitial'=> $item->nameInitial,
                'totalTask'=> $totalTask,
                'timeDelivery' => $item->timeDelivery(),
                'totalFinalized' => $item->totalFinalized(),
                'efficiency' => $efficiency
            ];
            if( $totalTask == 0 ) continue;
            $efficiencyTeam[] = $efficiency;
        }

        $calcEfficiencyTeam = round(array_sum($efficiencyTeam) / count($efficiencyTeam), 1);
        $params = [
            'user' => $user,
            'taskComplete' => $taskComplete,
            'avergeDate' => $avergeDate,
            'team' => $team,
            'calcEfficiencyTeam' => $calcEfficiencyTeam
        ];
        
        return view('report.index', $params);
    }

    public function listWork(Request $request){
        $user = Auth::user();
        $users = User::where('business_id', $user->business_id)->get();
        $time = $request->query('time') ?? 'today';

        $startdate = '';
        $enddate = '';
        if( $time == 'today' ){
            $startdate = date('Y-m-d');
            $enddate = date('Y-m-d');
        }
        if( $time == 'week' ){
            $startdate = date('Y-m-d', strtotime('-1 week'));
            $enddate = date('Y-m-d');
        }
        if( $time == 'month' ){
            $startdate = date('Y-m-d', strtotime('-1 month'));
            $enddate = date('Y-m-d');
        }

        $result = [];
        foreach ($users as $item) {
            $totalTask = $item->totalTaskByDate($startdate, $enddate);
            $totalFinalized = $item->totalFinalizedByDate($startdate, $enddate);
            $result[] = [
                'id'=> $item->id,
                'name'=> $item->name,
                'last_name'=> $item->last_name,
                'totalTask'=> $totalTask,
                'totalFinalized' => $totalFinalized,
            ];

        }

        $params = [
            'status' =>'success',
            'data' => $result
        ];

        return response()->json($params);
    }
}