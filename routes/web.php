<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\Usercontroller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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

Route::any('test', function (Request $request) {
    return Storage::url("public/" . User::find(11)->images->url);
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', function () {
    return view('admin.dashboard.index');
})->name('dashboard');

Route::get('home', function () {
    return view('client.layouts.app');
});

Auth::routes();

Route::resource('role', RoleController::class);
Route::resource('user', Usercontroller::class);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
