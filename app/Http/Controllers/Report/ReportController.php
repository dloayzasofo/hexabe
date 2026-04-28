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
}