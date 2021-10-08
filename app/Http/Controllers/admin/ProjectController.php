<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SebastianBergmann\Environment\Console;

class ProjectController extends Controller
{
    public function index(){
        return view('admin.project.dashboard');
    }

    public function store(StoreProjectRequest $request){
        $project = Project::create($request->validated());
        $project->users()->sync($request->selected_users);
        return new ProjectResource($project);
    }

    public function getProjects(){
        $projects = Project::all();
        return ProjectResource::collection($projects);
    }

    public function getUsers(Project $project){
        $users = $project->users()->get();
        return UserResource::collection($users);
    }

    public function update(Project $project, StoreProjectRequest $request){
        $project->update($request->validated());
        $project->users()->sync($request->selected_users);
        return new ProjectResource($project);
    }

    public function destroy(Project $project){
        $project->tasks()->delete();
        $project->users()->sync([]);
        $project->delete();
        return response()->noContent();
    }
}
