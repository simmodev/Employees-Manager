<?php

use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\UserContoller;
use App\Http\Controllers\auth\Login;
use App\Http\Controllers\admin\TaskController;
use App\Http\Controllers\user\ProjectController as UserProjectController;
use App\Http\Controllers\user\TaskController as UserTaskController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('admin.user.dashboard');
})->name('home');

Route::prefix('')->group(function(){
    Route::get('/login', [Login::class, 'index'])->name('login');
    Route::post('/login', [Login::class, 'store'])->name('login');
    
    Route::post('/verification', [Login::class, 'verify'])->name('verification');
});



Route::prefix('admin')->group(function(){
    Route::get('users/dashboard', [UserContoller::class, 'index'])->name('admin.users.dashboard');
    Route::get('projects/dashboard', [ProjectController::class, 'index'])->name('admin.projects.dashboard');
    Route::get('tasks/dashboard', [TaskController::class, 'index'])->name('admin.tasks.dashboard');
});

Route::prefix('user')->group(function(){
    Route::get('projects/dashboard', [UserProjectController::class, 'index'])->name('user.projects.dashboard');
    Route::get('tasks/dashboard', [UserTaskController::class, 'index'])->name('user.tasks.dashboard');
});