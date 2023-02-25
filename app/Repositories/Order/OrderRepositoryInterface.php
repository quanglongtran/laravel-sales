<?php

namespace App\Repositories\Order;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getWithPaginateBy(int $user_id);

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
