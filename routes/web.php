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
use App\Http\Controllers\Client\OrderController;
use App\Models\Cart;
use App\Models\Coupon;

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
    session()->forget(['coupon_code', 'discount_amount_price', 'coupon_id']);
});

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('dashboard', 'admin.dashboard.index')->name('dashboard');
    Route::resource('role', RoleController::class);
    Route::resource('user', Usercontroller::class);
    Route::resource('category', CategoryController::class);
    Route::resource('product', AdminProductController::class);
    Route::resource('coupon', CouponController::class);
});

Route::resource('product', ProductController::class);

Route::prefix('cart')->name('cart.')->middleware('auth')->group(function () {
    Route::post('update/{id}', [CartController::class, 'updateQuantity'])->name('update-quantity');
    Route::post('counpon', [CartController::class, 'applyCoupon'])->name('apply-coupon');
    Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('checkout-handle', [CartController::class, 'checkoutHandle'])->name('checkout-handle');
});

Route::prefix('order')->name('order.')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('index');
    Route::delete('delete/{id}', [OrderController::class, 'delete'])->name('delete');
});

Route::resource('cart', CartController::class);

// Route::get('/home', [App\Http\Controllers\Client\HomeController::class, 'index'])->name('home');
