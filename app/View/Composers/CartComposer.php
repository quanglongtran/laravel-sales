<?php

namespace App\View\Composers;

use App\Models\Cart;
use Illuminate\View\View;

class CartComposer
{
    protected Cart $cart;


    /**
     * __construct
     *
     * @param  Cart $category
     * @return void
     */
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('totalProducts', $this->countProductInCart());
    }

    /**
     * countProductInCart
     *
     * @return int
     */
    public function countProductInCart()
    {
        if (\auth()->check()) {
            $cart = $this->cart->getBy(\auth()->user()->getAuthIdentifier());

            if ($cart) {
                return $cart->cartProducts()->count();
            }
        }

        return 0;
    }
}
