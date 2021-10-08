<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationMail;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
    public function index(){
        return view('user.auth.login');
    }

    public function store(Request $request){
        $this->validate($request,[
            'email'=>'required|email'
        ]);
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return back()->with('fail', 'We do not recognize your email adress!');
        }else{
            Session::put('verification_code', rand(10000,99999));
            Session::put('email', $request->email);
            Mail::to($request->email)->send(new VerificationMail());
            return view('user.auth.verification');
        }
    }

    public function verify(Request $request){
        if($request->verification_code == Session::get('verification_code')){
            $user = User::where('email', Session::get('email'))->first();
            if($user->isAdmin === 1){
                Session::put('loggedAdmin', $user->id);
            }else{
                Session::put('loggedUser', $user->id);
            }
            Auth::login($user);
            return view('user.project.dashboard');
        }else{
            return view('user.auth.verification', ['message'=>'Verification code incorrect!']);
        }
    }
}
