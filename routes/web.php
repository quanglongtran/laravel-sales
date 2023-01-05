<?php

/*
|--------------------------------------------------------------------------
| Admin Controller
|--------------------------------------------------------------------------
|
*/

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\Usercontroller;
use App\Http\Controllers\Client\HomeController;
// ----------------------------------------------------------------

/*
|--------------------------------------------------------------------------
| Client Controller
|--------------------------------------------------------------------------
|
*/

use App\Http\Controllers\Client\ProductController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

Route::any('test', function (Request $request) {
    $category = new Category();
    $result = $category->all()->withProducts(5);
    return $result;
});

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::view('dashboard', 'admin.dashboard.index')->name('dashboard');
    Route::resource('role', RoleController::class);
    Route::resource('user', Usercontroller::class);
    Route::resource('category', CategoryController::class);
    Route::resource('product', AdminProductController::class);
    Route::resource('coupon', CouponController::class);
});

Route::resource('product', ProductController::class);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
