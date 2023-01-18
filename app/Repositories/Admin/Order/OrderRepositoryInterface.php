<?php

namespace App\Repositories\Admin\Order;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getWithPaginateBy(int $user_id);
}
