<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        
        if(session()->has('loggedAdmin') && Auth::user()){
            return $next($request);
        }else{
            return redirect(route('login'))->with('fail', 'You must be logged as admin!');
        }
    }
}
