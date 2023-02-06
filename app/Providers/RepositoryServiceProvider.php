<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*
        |--------------------------------------------------------------------------
        | Repository on admin side
        |--------------------------------------------------------------------------
        |
        |
        */

        // Role
        $this->app->singleton(
            \App\Repositories\Admin\Role\RoleRepositoryInterface::class,
            \App\Repositories\Admin\Role\RoleRepository::class
        );

        // Permission
        $this->app->singleton(
            \App\Repositories\Admin\Permission\PermissionRepositoryInterface::class,
            \App\Repositories\Admin\Permission\PermissionRepository::class
        );

        // Category
        $this->app->singleton(
            \App\Repositories\Admin\Category\CategoryRepositoryInterface::class,
            \App\Repositories\Admin\Category\CategoryRepository::class
        );

        // Coupon
        $this->app->singleton(
            \App\Repositories\Admin\Coupon\CouponRepositoryInterface::class,
            \App\Repositories\Admin\Coupon\CouponRepository::class
        );

        // Order
        $this->app->singleton(
            \App\Repositories\Admin\Order\OrderRepositoryInterface::class,
            \App\Repositories\Admin\Order\OrderRepository::class
        );

        // Product
        $this->app->singleton(
            \App\Repositories\Admin\Product\ProductRepositoryInterface::class,
            \App\Repositories\Admin\Product\ProductRepository::class
        );

        //User
        $this->app->singleton(
            \App\Repositories\Admin\User\UserRepositoryInterface::class,
            \App\Repositories\Admin\User\UserRepository::class
        );




        /*
        |--------------------------------------------------------------------------
        | Repository on client side
        |--------------------------------------------------------------------------
        |
        |
        */

        // Product
        $this->app->singleton(
            \App\Repositories\Client\Product\ProductRepositoryInterface::class,
            \App\Repositories\Client\Product\ProductRepository::class
        );

        // Cart
        $this->app->singleton(
            \App\Repositories\Client\Cart\CartRepositoryInterface::class,
            \App\Repositories\Client\Cart\CartRepository::class
        );

        // Cart Product
        $this->app->singleton(
            \App\Repositories\Client\CartProduct\CartProductRepositoryInterface::class,
            \App\Repositories\Client\CartProduct\CartProductRepository::class
        );

        // Home
        $this->app->singleton(
            \App\Repositories\Client\Home\HomeRepositoryInterface::class,
            \App\Repositories\Client\Home\HomeRepository::class
        );

        // Order
        $this->app->singleton(
            \App\Repositories\Client\Order\OrderRepositoryInterface::class,
            \App\Repositories\Client\Order\OrderRepository::class
        );

        // Coupon
        $this->app->singleton(
            \App\Repositories\Client\Coupon\CouponRepositoryInterface::class,
            \App\Repositories\Client\Coupon\CouponRepository::class
        );

        // User
        $this->app->singleton(
            \App\Repositories\Client\User\UserRepositoryInterface::class,
            \App\Repositories\Client\User\UserRepository::class
        );




        /*
        |--------------------------------------------------------------------------
        | Auth Repository
        |--------------------------------------------------------------------------
        |
        |
        */

        // Auth
        $this->app->singleton(
            \App\Repositories\Auth\AuthRepositoryInterface::class,
            \App\Repositories\Auth\AuthRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
