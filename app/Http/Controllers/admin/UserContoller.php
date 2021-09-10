<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserContoller extends Controller
{
    public function store(StorePostRequest $request){
        
        $user = User::create($request->validated());
        return new UserResource($user);

    }
}
