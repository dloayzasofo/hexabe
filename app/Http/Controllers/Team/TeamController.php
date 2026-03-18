<?php 

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use App\Http\Requests\TeamRequest;
use App\Models\Team;
use Auth;

class TeamController extends Controller {
 
    public function index() {
        $teams = Team::all();
        $params = [
            'teams' => $teams
        ];

        return view('team.index', $params);
    }

    public function create() {
        $params = [
            'model' => new Team()
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
        $team->industry = $request->industry;
        $team->status = $request->status == "1" ? "ACTIVE" : "DEACTIVE";
        $team->user_id = $user->id;
        $team->business_id = $user->business_id;
        $team->save();
        
        $request->session()->flash('team.success', 'Equipo ha sido registrada correctamente.');
        return response()->json(['success' => true]);
        //return redirect()->route('team.index');
    }

    public function edit(Request $request, Team $team) {
        $params = [
            'model' => $team
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
        $team->industry = $request->industry;
        $team->status = $request->status == "1" ? "ACTIVE" : "DEACTIVE";
        $team->user_id = $user->id;
        $team->business_id = $user->business_id;
        $team->save();
        
        $request->session()->flash('team.success', 'Marca ha sido actualizada correctamente.');
        return response()->json(['success' => true]);
        //return redirect()->route('team.index');
    }

    public function view(Request $request, Team $team) {
        $params = [
            'team' => $team
        ];

        return view('team.view', $params);
    }
}