<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(){
        return view('admin.project.dashboard');
    }

    public function store(StoreProjectRequest $request){
        $project = Project::create($request->validated());
        foreach($request->selected_users as $selected_user){
            $user = User::where('id', $selected_user)->first();
            $user->projects()->attach($project);
        }
        return new ProjectResource($project);
    }

    public function getProjects(){
        $projects = Project::all();
        return ProjectResource::collection($projects);
    }
}
