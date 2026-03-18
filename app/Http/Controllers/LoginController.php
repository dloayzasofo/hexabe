<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\AskRequest;
use Illuminate\Routing\Redirector;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\Setting;
use App\Models\Log\LoginLog;

class LoginController extends Controller
{
    function index(){
        $setting = null; // Setting::where('name','RECAPTCHA_SETTING')->first();
        $recaptchaApi = env('RECAPTCHA_CLIENT');

        if( isset($setting) ){
            $value = json_decode($setting->value, true);
            $recaptchaApi = $value['api'];
        }

        $parameters = [
            'recaptchaApi' => $recaptchaApi
        ];
        
        return view('login', $parameters);
    }

    function login(Request $request){
        $data = $this->_sanitizeInputs($request->email, $request->password);
        
        if( Auth::attempt($data) ) {
            $request->session()->regenerate(); 
            $this->_save_logs($data['email'], $data['password'], 'LOGIN SUCCESS', $request);
            return redirect()->route('dashboard.index');
        }
        
        $this->_save_logs($data['email'], $data['password'], 'LOGIN FAIL', $request);
        $request->session()->flash('login.fail', 'El email o password son incorrectos.');
        return redirect()->route('login');
    }

    function logout(Request $request){
        $this->_save_logs(Auth::user()->email, null, 'LOGOUT', $request);
        Auth::logout();
 
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    function _save_logs($email, $password, $action, $request){
        /*
        $ua = $request->header('User-Agent');
        $ip = $request->ip();

        $log = new LoginLog();
        $log->email  = $email;
        $log->password  = ( $password == null ) ? '' : Crypt::encryptString('$2y$10$' . $password);
        //$decrypted = Crypt::decryptString($encryptedValue);

        $log->action    = $action;
        $log->ip        = $ip;
        $log->user_agent = $ua;

        $log->save();
        */
    }

    function _sanitizeInputs($email, $password){
        $email    = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $data = ['email' => $email, 'password'=> $password];
        return $data;
    }
}
