<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Coupon\CouponRepositoryInterface;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public $coupon;

    public function __construct(CouponRepositoryInterface $coupon)
    {
        $this->coupon = $coupon;
    }

    public function apply(Request $request)
    {
        return $this->coupon->apply($request);
    }
}
