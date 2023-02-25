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
            // Auth Repository
            \App\Repositories\Auth\AuthRepositoryInterface::class => \App\Repositories\Auth\AuthRepository::class,
            \App\Repositories\Auth\PasswordRepositoryInterface::class => \App\Repositories\Auth\PasswordRepository::class,
            \App\Repositories\Auth\SocialRepositoryInterface::class => \App\Repositories\Auth\SocialRepository::class,
            
            // TEST
            \App\Repositories\User\UserRepositoryInterface::class => \App\Repositories\User\UserRepository::class,
            \App\Repositories\Coupon\CouponRepositoryInterface::class => \App\Repositories\Coupon\CouponRepository::class,
            \App\Repositories\Product\ProductRepositoryInterface::class => \App\Repositories\Product\ProductRepository::class,
            \App\Repositories\Order\OrderRepositoryInterface::class => \App\Repositories\Order\OrderRepository::class,
            \App\Repositories\Category\CategoryRepositoryInterface::class => \App\Repositories\Category\CategoryRepository::class,
            \App\Repositories\Role\RoleRepositoryInterface::class => \App\Repositories\Role\RoleRepository::class,
            \App\Repositories\Permission\PermissionRepositoryInterface::class => \App\Repositories\Permission\PermissionRepository::class,
            \App\Repositories\Cart\CartRepositoryInterface::class => \App\Repositories\Cart\CartRepository::class,
            \App\Repositories\CartProduct\CartProductRepositoryInterface::class => \App\Repositories\CartProduct\CartProductRepository::class,
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
