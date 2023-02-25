<?php

namespace App\Repositories\Order;

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

    public function getByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->latest('id')->paginate(12);
    }

    public function cancel($id)
    {
        if ($this->update($id, ['status' => 'canceled'])) {
            return true;
        }

        return false;
    }
}
