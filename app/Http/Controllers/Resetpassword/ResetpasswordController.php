<?php 

namespace App\Http\Controllers\ResetPassword;
use Illuminate\Http\Request;
use App\Http\Requests\ResetPassword\ResetPasswordAccountRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use App\Models\User;
 
class ResetPasswordController extends Controller
{
    public function index(Request $request){
        $token = Str::uuid()->toString();
        $request->session()->put('resetpassword', $token);
        $params = [
            'token' => $token
        ];
        return view('resetpassword.index', $params);
    }

    public function request(Request $request, $token){
        if( $token != $request->session()->get('resetpassword') ) return abort(404);

        $email = $request->input('email');
        $user = User::where('email', $email)
            ->first();

        if( $user == null ){
            return back()->withInput()->withErrors(['email' => 'Email incorrecto']);
        }

        if( $user->banned_at != null ){
            return back()->withInput()->withErrors(['email' => 'Su cuenta esta deshabilitada']);
        }

        try {
            $user->remember_token = Str::uuid()->toString();
            $user->save();
            Mail::to($user->email)->send(new ResetPasswordMail($user));
            $params = [
                'success' => true,
                'email' => $user->email,
                'message' => 'Te hemos enviado un correo para restablecer tu contraseña'
            ];
            return view('resetpassword.sendemail', $params);
        } catch (\Exception $ex) {
            // Ver que pudo ser el error
            $params = [
                'success' => false,
                'email' => $user->email,
                'message' => $ex->getMessage()
            ];
            return view('resetpassword.sendemail', $params);
        }
    }

    public function show(Request $request, $token){
        $user = User::where('remember_token', $token)
            ->first();

        if( $user == null ){
            return abort('404');
        }

        $params = [
            'token' => $token
        ];

        return view('resetpassword.request', $params);
    }

    public function reset(Request $request, $token){
        $user = User::where('remember_token', $token)
            ->first();

        if( $user == null ){
            return abort('404');
        }

        $password = $request->input('password');
        $password_confirmed = $request->input('password_confirmed');
        $user->remember_token = null;
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('resetpassword.thankyou');
    }

    public function thankyou(Request $request){
        return view('resetpassword.thankyou');
    }
}