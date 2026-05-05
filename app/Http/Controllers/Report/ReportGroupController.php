<?php 

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\User;
use App\Models\Team;
use App\Models\TeamUser;
use Carbon\Carbon;
use Auth;

class ReportGroupController extends Controller {
 
    public function index() {
        $user = Auth::user();
        $now = date('Y-m-d');
        $teams = Team::where('business_id', $user->business_id)->orderBy('name', 'desc')->get();
        $users = User::where('business_id', $user->business_id)->orderBy('name', 'desc')->get();

        $params = [
            'user' => $user,
            'users' => $users,
            'teams' => $teams
        ];
        
        return view('report.team', $params);
    }

    public function report(Request $request){
        //$user = Auth::user();
        $date = $request->date;
        $type = $request->type;
        $user = $request->user;
        $team = $request->team;

        $totalTask = 0;
        $result = [];

        

        if( $type == 'team' ) {
            $result = $this->filter_team($team, $date);
            $totalTask = count($result);
        }

        if( $type == 'user' ) {
            $result = $this->filter_user($user, $date);
            $totalTask = count($result);
        }

        $params = [
            'totalTask' => $totalTask,
            'tasks' => $result
        ];

        return response()->json([
            'success' => true,
            'data' => $params
        ]);
    }

    public function filter_team($team_id, $date){
        $users = TeamUser::where('team_id', $team_id)->pluck('user_id');
        $tasks = Task::whereIn('user_assign', $users)->where('date_delivery', $date)->get();

        $result = [];
        foreach( $tasks as $item ){
            $userTeams = TeamUser::where('user_id', $item->assign->id)->pluck('team_id')->toArray();
            $teams = [];
            if( count($userTeams) > 0 ) {
                $teams = Team::whereIn('id', $userTeams)->pluck('name')->toArray();
            }

            $result[] = [
                'id' => $item->id,
                'title' => $item->title,
                'date_delivery' => Carbon::parse($item->date_delivery)->format('d/m/Y'),
                'status' => $item->status,
                'priority' => $item->priority,
                'brand' => [
                    'name' => $item->brand->name,
                    'image' => $item->brand->image
                ],
                'user' => [
                    'id' => $item->user->id,
                    'name' => $item->user->name,
                    'last_name' => $item->user->last_name,
                    'image' => $item->user->image,
                    'nameInitial' => $item->user->nameInitial
                ],
                'assign' => [
                    'id' => $item->assign->id,
                    'name' => $item->user->name,
                    'last_name' => $item->user->last_name,
                    'image' => $item->user->image,
                    'nameInitial' => $item->user->nameInitial,
                    'teams' => $teams
                ]
            ];
        }
        return $result;
    }

    public function filter_user($user_id, $date){
        $tasks = Task::with('brand','user','assign')
            ->where('user_assign', $user_id)
            ->where('date_delivery', $date)
            ->get();

        $result = [];
        foreach( $tasks as $item ){
            $userTeams = TeamUser::where('user_id', $item->assign->id)->pluck('team_id')->toArray();
            $teams = [];
            if( count($userTeams) > 0 ) {
                $teams = Team::whereIn('id', $userTeams)->pluck('name')->toArray();
            }

            $result[] = [
                'id' => $item->id,
                'title' => $item->title,
                'date_delivery' => Carbon::parse($item->date_delivery)->format('d/m/Y'),
                'status' => $item->status,
                'priority' => $item->priority,
                'brand' => [
                    'name' => $item->brand->name,
                    'image' => $item->brand->image
                ],
                'user' => [
                    'id' => $item->user->id,
                    'name' => $item->user->name,
                    'last_name' => $item->user->last_name,
                    'image' => $item->user->image,
                    'nameInitial' => $item->user->nameInitial
                ],
                'assign' => [
                    'id' => $item->assign->id,
                    'name' => $item->assign->name,
                    'last_name' => $item->assign->last_name,
                    'image' => $item->assign->image,
                    'nameInitial' => $item->assign->nameInitial,
                    'teams' => $teams
                ]
            ];
        }
        return $result;
    }
}