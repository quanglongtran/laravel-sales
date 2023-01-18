<?php

namespace App\Repositories\Admin\Order;

use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Order::class;
    }

    public function getWithPaginateBy($user_id)
    {
        return $this->model->whereUserId($user_id)->latest('id')->paginate(12);
    }
}
