<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserContoller extends Controller
{
    public function index(){
        return view('admin.user.dashboard');
    }

    public function store(StoreUserRequest $request){
        $user = User::create($request->validated());
        return new UserResource($user);
    }

    public function getUsers(){
        $users = User::all();
        return UserResource::collection($users);
    }

    public function update(User $user ,StoreUserRequest $request){
        $user->update($request->validated());
        return new UserResource($user);
    }

    public function destroy(User $user){
        $user->tasks()->delete();
        $user->projects()->sync([]);
        $user->delete();
        return response()->noContent();
    }
}
