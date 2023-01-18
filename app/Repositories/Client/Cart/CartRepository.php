<?php

namespace App\Repositories\Client\Cart;

use App\Repositories\Client\Order\OrderRepository;
use App\Repositories\BaseRepository;
use App\Repositories\Client\Coupon\CouponRepository;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    private $query;

    public function getModel()
    {
        return \App\Models\Cart::class;
    }

    public function firstOrCreate()
    {
        $this->query = $this->model->firstOrCreate(['user_id' => \auth()->user()->getAuthIdentifier()]);
        return $this;
    }

    public function getRelationships()
    {
        return [
            'cart' => $this->query,
            'cartProducts' => $this->query->cartProducts()->get(),
        ];
    }

    public function execute()
    {
        return $this->query;
    }

    public function checkout()
    {
        return $this->firstOrCreate()->execute()->loadMissing('cartProducts');
    }

    public function checkoutHandle($request)
    {
        $couponRepo = new CouponRepository;
        $orderRepo = new OrderRepository;

        $orderRepo->create(\array_merge($request->all(), [
            'user_id' => \auth()->user()->getAuthIdentifier(),
            'status' => 'pending'
        ]));

        if ($couponId = \session()->get('coupon_id')) {
            if ($coupon = $couponRepo->findOrFail($couponId)) {
                $coupon->users()->attach(auth()->user()->id, ['value' => $coupon->value]);
            }
        }

        $cart = $this->firstOrCreate()->execute();
        $cart->cartProducts->each->delete();

        session()->forget(['coupon_code', 'discount_amount_price', 'coupon_id']);
    }
}
