<?php

namespace App\Repositories\CartProduct;

use App\Repositories\BaseRepository;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Cart\CartRepository;

class CartProductRepository extends BaseRepository implements CartProductRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\CartProduct::class;
    }

    public function getBy($productId, $cartId, $productSize)
    {
        return $this->model->whereCartId($cartId)->whereProductId($productId)->whereProductSize($productSize)->first();
    }

    public function addToCart($request)
    {
        $productRepo = new ProductRepository();
        $cartRepo = new CartRepository();

        $product = $productRepo->findOrFail($request->product_id);

        $cart = $cartRepo->firstOrCreate()->execute();

        $cartProduct = $this->getBy($cart->id, $product->id, $request->size);

        if ($cartProduct) {
            $cartProduct->product_quantity += $request->quantity;
        } else {
            $cartProduct = $this->model;
            $cartProduct->cart_id = $cart->id;
            $cartProduct->product_size = $request->size;
            $cartProduct->product_quantity = $request->quantity;
            $cartProduct->product_price = $product->price;
            $cartProduct->product_id = $product->id;
        }

        $cartProduct->save();
        return $cartProduct;
    }

    public function updateQuantity($request, $id)
    {
        $cartProduct = $this->findOrFail($id);

        if ($request->product_quantity < 1) {
            $cartProduct->delete();
            $message = 'Product has been removed from your cart!';
        } else {
            $cartProduct->update($request->all());
            $message = 'Product quantity has been updated!';
        }

        return [
            'message' => $message,
            'response' => [
                'quantity' => $request->product_quantity,
            ]
        ];
    }
}
