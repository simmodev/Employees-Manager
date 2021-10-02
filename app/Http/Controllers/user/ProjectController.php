<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProjectController extends Controller
{
    public function index(Request $request){
        
        return view('user.project.dashboard');
    }

    public function getProjects(){
        
        $user = Auth::user();
        $projects = $user->projects()->get();
        return ProjectResource::collection($projects);
    }
}
