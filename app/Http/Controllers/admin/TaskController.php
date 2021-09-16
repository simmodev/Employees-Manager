<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Http\Resources\UserResource;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\UserProject;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class TaskController extends Controller
{
    public function index(){
        return view('admin.task.dashboard');
    }

    public function store(StoreTaskRequest $request){
        $task = Task::create($request->validated());
        return new TaskResource($task);
    }

    public function getTasks(){
        $tasks = Task::get();
        return TaskResource::collection($tasks);
    }

    public function getUsers(Request $request){
        $project = Project::where('id', $request->project_id)->first();
        $users = $project->users()->get();
        return UserResource::collection($users);
    }

    public function getUser($id){
        $user = User::where('id', $id)->first()->only('first_name', 'last_name');
        return $user;
    }

    public function getProject($id){
        $project = Project::where('id', $id)->first()->only('title');
        return $project;
    }

}
