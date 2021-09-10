<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
    
    public function store(Request $request){
        Session::put('email', $request->email);

        
        
        return view('auth.login');

    }
}
