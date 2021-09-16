<?php

use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\UserContoller;
use App\Http\Controllers\admin\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('admin')->group(function(){
    Route::post('user/add',[UserContoller::class, 'store']);
    Route::post('users',[UserContoller::class, 'getUsers']);

    Route::post('project/add',[ProjectController::class, 'store']);
    Route::post('projects',[ProjectController::class, 'getProjects']);

    Route::post('task/add',[TaskController::class, 'store']);
    Route::post('tasks',[TaskController::class, 'getTasks']);
    Route::post('task/users',[TaskController::class, 'getUsers']);
    Route::post('task/user/{id}',[TaskController::class, 'getUser']);
    Route::post('task/project/{id}',[TaskController::class, 'getProject']);
});

