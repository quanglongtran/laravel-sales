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

        $repositories = [
            // Repository on admin side
            \App\Repositories\Admin\Role\RoleRepositoryInterface::class => \App\Repositories\Admin\Role\RoleRepository::class,
            \App\Repositories\Admin\Permission\PermissionRepositoryInterface::class => App\Repositories\Admin\Permission\PermissionRepository::class,
            \App\Repositories\Admin\Category\CategoryRepositoryInterface::class => \App\Repositories\Admin\Category\CategoryRepository::class,
            \App\Repositories\Admin\Coupon\CouponRepositoryInterface::class => \App\Repositories\Admin\Coupon\CouponRepository::class,
            \App\Repositories\Admin\Order\OrderRepositoryInterface::class => \App\Repositories\Admin\Order\OrderRepository::class,
            \App\Repositories\Admin\Product\ProductRepositoryInterface::class => \App\Repositories\Admin\Product\ProductRepository::class,
            \App\Repositories\Admin\User\UserRepositoryInterface::class => \App\Repositories\Admin\User\UserRepository::class,

            // Repository on client side
            \App\Repositories\Client\Product\ProductRepositoryInterface::class => \App\Repositories\Client\Product\ProductRepository::class,
            \App\Repositories\Client\Cart\CartRepositoryInterface::class => \App\Repositories\Client\Cart\CartRepository::class,
            \App\Repositories\Client\CartProduct\CartProductRepositoryInterface::class => \App\Repositories\Client\CartProduct\CartProductRepository::class,
            \App\Repositories\Client\Home\HomeRepositoryInterface::class => \App\Repositories\Client\Home\HomeRepository::class,
            \App\Repositories\Client\Order\OrderRepositoryInterface::class => \App\Repositories\Client\Order\OrderRepository::class,
            \App\Repositories\Client\Coupon\CouponRepositoryInterface::class => \App\Repositories\Client\Coupon\CouponRepository::class,
            \App\Repositories\Client\User\UserRepositoryInterface::class => \App\Repositories\Client\User\UserRepository::class,

            // Auth Repository
            \App\Repositories\Auth\AuthRepositoryInterface::class => \App\Repositories\Auth\AuthRepository::class
        ];

        foreach ($repositories as $interface => $class) {
            $this->app->singleton($interface, $class);
        }
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
