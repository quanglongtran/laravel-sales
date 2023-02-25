<?php

namespace App\Repositories\Coupon;

use App\Repositories\BaseRepository;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Coupon::class;
    }

    public function apply($request)
    {
        $name = $request->input('coupon_code');
        $coupon = $this->model->firstWithExpired($name, auth()->user()->getAuthIdentifier());
        $couponSessions = \collect(['coupon_id' => optional($coupon)->id, 'discount_amount_price' => optional($coupon)->value, 'coupon_code' => $name]);

        if ($coupon) {
            $couponSessions->each(fn ($value, $key) => session([$key => $value]));
            return jsonResponse(true, 'Coupon successfully applied coupon code', [
                'coupon_code' => $name,
                'discount_amount_price' => $coupon->value,
                'coupon_id' => $coupon->id
            ]);
        } else {
            session()->forget(\json_decode($couponSessions->keys()));
            return jsonResponse(false, 'Coupon code applied failed');
        }
    }
}
