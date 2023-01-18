<?php

/*
|--------------------------------------------------------------------------
| Admin Controller
|--------------------------------------------------------------------------
|
*/

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\Usercontroller;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\AuthController;
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
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CartProductController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\CouponController;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Container\Container;

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

Route::any('test', function () {
    dd(Auth::guard('web')->check());
});

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

Route::group([], function () {
    Route::get('login', [AuthController::class, 'loginView'])->middleware('guest:web')->name('login-view');
    Route::view('register', 'auth.register')->middleware('guest:web');
    Route::view('dashboard', 'dashboard')->name('dashboard')->middleware('auth');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::view('dashboard', 'admin.dashboard.index')->name('dashboard');
    Route::resource('role', RoleController::class);
    Route::resource('user', Usercontroller::class);
    Route::resource('category', CategoryController::class);
    Route::resource('product', AdminProductController::class);
    Route::resource('coupon', AdminCouponController::class);
    Route::get('order', [AdminOrderController::class, 'index'])->name('order.index');
    Route::put('order-update-status', [AdminOrderController::class, 'updateStatus'])->middleware('update-order')->name('order.update-status');
});

Route::resource('product', ProductController::class);

Route::prefix('cart')->name('cart.')->middleware('auth')->group(function () {
    Route::post('update/{id}', [CartProductController::class, 'update'])->name('update-quantity');
    Route::post('counpon', [CouponController::class, 'apply'])->name('apply-coupon');
    Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('checkout-handle', [CartController::class, 'checkoutHandle'])->name('checkout-handle');
});

Route::prefix('order')->name('order.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::delete('delete/{id}', [OrderController::class, 'delete'])->name('delete');
});

Route::resource('cart', CartController::class);

// Route::get('/home', [App\Http\Controllers\Client\HomeController::class, 'index'])->name('home');
