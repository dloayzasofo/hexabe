<?php 

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use App\Http\Requests\TeamRequest;
use App\Models\Brand;
use App\Models\Task;
use App\Models\Team;
use App\Models\TeamBrand;
use App\Models\TeamUser;
use App\Models\User;
use Auth;

//use Illuminate\Support\Facades\Mail;
//use App\Models\TeamInvitation;
//use App\Mail\TeamInviteMail;

class TeamController extends Controller {
 
    public function index() {

        //$teamIniviteMail = new TeamInviteMail(TeamInvitation::first());
        //$mailer = Mail::to('lf.deiby@gmail.com');
        //$mailer->send($teamIniviteMail);
        //exit();

        $teams = Team::all();
        $params = [
            'teams' => $teams
        ];

        return view('team.index', $params);
    }

    public function create() {
        $brands = []; //Brand::where('business_id', Auth::user()->business_id)->get();
        $params = [
            'model' => new Team(),
            'users' => [],
            'brands' => $brands
        ];

        return view('team.create', $params);
    }

    public function save(TeamRequest $request) {
        $user = Auth::user();

        $team = new Team();
        if( $request->file('image') != null ) {
            $uploadedImage = $request->file('image');
            $media = MediaHelper::saveMedia($uploadedImage, 270, 195, "team", $user);
            $team->media_id = $media->id;
        }

        $team->name = $request->name;
        $team->description = $request->description;
        $team->status = "ACTIVE";
        $team->user_id = $user->id;
        $team->business_id = $user->business_id;
        $team->save();

        $members = $request->members;
        foreach($members as $member) {
            $teamUser = new TeamUser();
            $teamUser->team_id = $team->id;
            $teamUser->user_id = $member;
            $teamUser->save();
        }

        $brands = $request->brands;
        foreach($brands as $brand) {
            $teamBrand = new TeamBrand();
            $teamBrand->team_id = $team->id;
            $teamBrand->brand_id = $brand;
            $teamBrand->save();
        }
        
        $request->session()->flash('team.success', 'Equipo ha sido registrada correctamente.');
        return response()->json(['success' => true]);
    }

    public function edit(Request $request, Team $team) {
        $teamUsers = TeamUser::with('user')->where('team_id', $team->id)->get();
        $teanBrands = TeamBrand::with('brand')->where('team_id', $team->id)->get();

        $users = [];
        foreach($teamUsers as $teamuser) {
            $users[] = [
                'id' => $teamuser->user->id,
                'name' => $teamuser->user->name,
                'email' => $teamuser->user->email,
                'image' => $teamuser->user->image,
                'initials' => $teamuser->user->nameInitial
            ];
        }

        $brands = [];
        foreach($teanBrands as $teambrand) {
            $brands[] = [
                'id' => $teambrand->brand->id,
                'name' => $teambrand->brand->name,
                'image' => $teambrand->brand->image,
                'initials' => $teambrand->brand->nameInitial
            ];
        }

        $params = [
            'model' => $team,
            'users' => $users,
            'brands' => $brands
        ];

        return view('team.update', $params);
    }

    public function update(TeamRequest $request, Team $team) {
        $user = Auth::user();

        if( $request->file('image') != null ) {
            $uploadedImage = $request->file('image');
            $media = MediaHelper::saveMedia($uploadedImage, 270, 195, "team", $user);
            $team->media_id = $media->id;
        }

        $team->name = $request->name;
        $team->description = $request->description;
        //$team->status = $request->status == "1" ? "ACTIVE" : "DEACTIVE";
        $team->user_id = $user->id;
        $team->business_id = $user->business_id;
        $team->save();

        $members = $request->members;
        $teamUsers = TeamUser::whereNotIn('user_id', $members)->where('team_id', $team->id)->delete();

        foreach($members as $member) {
            if( TeamUser::where('team_id', $team->id)->where('user_id', $member)->exists() ) {
                continue;
            }
            $teamUser = new TeamUser();
            $teamUser->team_id = $team->id;
            $teamUser->user_id = $member;
            $teamUser->save();
        }

        $brands = $request->brands;
        $teamBrands = TeamBrand::whereNotIn('brand_id', $brands)->where('team_id', $team->id)->delete();

        foreach($brands as $member) {
            if( TeamBrand::where('team_id', $team->id)->where('brand_id', $member)->exists() ) {
                continue;
            }
            $teamBrand = new TeamBrand();
            $teamBrand->team_id = $team->id;
            $teamBrand->brand_id = $member;
            $teamBrand->save();
        }
        
        $request->session()->flash('team.success', 'Marca ha sido actualizada correctamente.');
        return response()->json(['success' => true]);
    }

    public function view(Request $request, Team $team) {
        $users = $team->teamuser()->pluck('user_id');
        $lastTasks = Task::whereNull('parent_id')
            ->whereIn('user_assign', $users)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $members = $team->members;
        $brands = $team->teambrand()->pluck('brand_id');
        $brands = Brand::whereIn('id', $brands)->get();

        $params = [
            'team' => $team,
            'lastTasks' => $lastTasks,
            'members' => $members,
            'brands' => $brands
        ];

        return view('team.view', $params);
    }

    public function removeBrand(Request $request, Team $team, Brand $brand) {
        $name = $brand->name;
        TeamBrand::where('team_id', $team->id)->where('brand_id', $brand->id)->delete();
        
        $request->session()->flash('team.success', 'Marca '.$name.' ha sido removida del equipo correctamente.');
        return redirect()->route('team.view', [$team]);
    }

    public function removeUser(Request $request, Team $team, User $user) {
        $name = $user->name;
        TeamUser::where('team_id', $team->id)->where('user_id', $user->id)->delete();
        
        $request->session()->flash('team.success', 'Usuario '.$name.' ha sido removido del equipo correctamente.');
        return redirect()->route('team.view', [$team]);
    }
}