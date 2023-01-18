<?php

namespace App\Repositories\Client\Order;

use App\Repositories\RepositoryInterface;
use App\Models\Order;

interface OrderRepositoryInterface extends RepositoryInterface
{
    /**
     * Get order by user id
     *
     * @param  int $userId
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function getByUserId(int $userId);

    /**
     * Cancel an order
     *
     * @param  int $id
     * @return bool
     */
    public function cancel(int $id);
}
