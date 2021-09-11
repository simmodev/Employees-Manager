<?php

use App\Http\Controllers\auth\Login;
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

Route::post('/login', [Login::class, 'store'])->name('login');
Route::post('/verification', [Login::class, 'verify'])->name('verification');
