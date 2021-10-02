<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(){
        return view('user.task.dashboard');
    }

    public function getTasks(){
        $user = Auth::user();
        $tasks = $user->tasks()->get();
        return TaskResource::collection($tasks);
    }

    public function updateCheck(Task $task){
        $task->completed = !$task->completed;
        $task->save();
        return response()->noContent();
    }
}
