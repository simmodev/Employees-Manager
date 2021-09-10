<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function store(StorePostRequest $request){
        /*
        $this->validate($request, [
            'first_name'=>'required',
            'last_name'=>'required',
            'job_name'=>'required',
            'phone_number'=>'required',
            'email'=>'required',
            'password'=>'required',
        ]);
        
        $request->password=encrypt($request->password);
        $employee = Employee::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'job_name'=>$request->job_name,
            'phone_number'=>$request->phone_number,
            'email'=>$request->email,
            'password'=>encrypt($request->password),
        ]);

        $employee->password=decrypt($request->password);
        return $employee;
        */
        
        $user = User::create($request->validated());
        return new UserResource($user);

    }
}
