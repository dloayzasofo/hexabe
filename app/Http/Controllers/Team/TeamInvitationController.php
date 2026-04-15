<?php 

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use App\Http\Requests\TeamRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\Task;
use App\Models\Team;
use App\Models\TeamBrand;
use App\Models\TeamUser;
use App\Models\TeamInvitation;
use App\Models\User;
use App\Mail\TeamInviteMail;
use Auth;

class TeamInvitationController extends Controller {
 
    public function invitation(Request $request) {
        
        $user = Auth::user();
        $email = $request->input('email');
        $teamId = $request->input('team_id');
        $role = $request->input('role');
        $token = (string) Str::uuid();

        $teamInivitation = new TeamInvitation();
        $teamInivitation->email = $email;
        $teamInivitation->team_id = $teamId;
        $teamInivitation->role = $role;
        $teamInivitation->token = $token;
        $teamInivitation->user_id = $user->id;
        $teamInivitation->save();

        $teamIniviteMail = new TeamInviteMail($teamInivitation);
        $mailer = Mail::to($email);
        $mailer->send($teamIniviteMail);
        
        $request->session()->flash('team.success', 'Invitación a ' . $email . '  enviada correctamente');
        return response()->json(['success' => true, 'message' => 'Invitación enviada correctamente']);
    }
}