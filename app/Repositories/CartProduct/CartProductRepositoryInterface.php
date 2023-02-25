<?php

namespace App\Repositories\CartProduct;

use App\Repositories\RepositoryInterface;
use App\Models\CartProduct;
use Illuminate\Http\Request;

interface CartProductRepositoryInterface extends RepositoryInterface
{
    /**
     * addToCart
     *
     * @param Request $request
     * @return CartProduct
     */
    public function addToCart(Request $request);

    /**
     * getBy
     *
     * @param  int $productId
     * @param  int $cartId
     * @param  int $productSize
     * @return CartProduct|object|static|null
     */
    public function getBy($productId, $cartId, $productSize);

    /**
     * updateCartProduct
     *
     * @param  Request $request
     * @param  int $id
     * @return array
     */
    public function updateQuantity(Request $request, int $id);
}
