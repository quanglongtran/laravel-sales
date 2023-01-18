<?php

namespace App\Repositories\Admin\Coupon;

use App\Repositories\BaseRepository;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Coupon::class;
    }
}
