<?php 

namespace App\Http\Controllers\Team;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helper\MediaHelper;
use App\Http\Requests\TeamRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
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

        try{
            $teamIniviteMail = new TeamInviteMail($teamInivitation);
            $mailer = Mail::to($email);
            $mailer->send($teamIniviteMail);
            $request->session()->flash('team.success', 'Invitación a ' . $email . '  enviada correctamente');
        } catch (TransportExceptionInterface $e) {
            // Catch SMTP or transport-specific errors (e.g., connection failed)
            $teamInivitation->error = $e->getMessage();
            $teamInivitation->save();
            Log::error('Mail transport error: ' . $e->getMessage());
            $request->session()->flash('team.error', 'Error al enviar la invitación a ' . $email . '. Por favor, inténtalo de nuevo más tarde.');
        } catch (Exception $e) {
            // Catch any other general exceptions
            $teamInivitation->error = $e->getMessage();
            $teamInivitation->save();
            Log::error('General mail error: ' . $e->getMessage());
            $request->session()->flash('team.error', 'Error al enviar la invitación a ' . $email . '. Por favor, inténtalo de nuevo más tarde.');
        }
        
        return response()->json(['success' => true, 'message' => 'Invitación enviada correctamente']);
    }

    public function invitationaccept(Request $request, $token) {
        $teamInvitation = TeamInvitation::where('token', $token)
            ->whereNull('accepted_at')
            ->firstOrFail();

        $params = [
            'token' => $token,
            'email' => $teamInvitation->email
        ];

        return view('register.invitation', $params);

    }

    public function invitationaccept_save(Request $request, $token) {
        $teamInvitation = TeamInvitation::where('token', $token)
            ->whereNull('accepted_at')
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:4|max:20|confirmed',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->last_name = $request->input('lastname');
        $user->email = $request->input('email');
        $user->phone_code = '591';
        $user->phone = $request->input('phone');
        $user->status = 'ACTIVE';
        $user->password =  Hash::make($request->input('password'));

        $user->business_id = $teamInvitation->team->business_id;
        $user->role = $teamInvitation->role;
        $user->parent_id = $teamInvitation->user_id;
        $user->save();

        // Add user to team
        $teamUser = new TeamUser();
        $teamUser->team_id = $teamInvitation->team_id;
        $teamUser->user_id = $user->id;
        $teamUser->save();

        // Mark invitation as accepted
        $teamInvitation->accepted_at = now();
        $teamInvitation->save();

        return redirect()->route('login')->with('success', 'Cuenta creada exitosamente. Por favor, inicia sesión.');

    }

}