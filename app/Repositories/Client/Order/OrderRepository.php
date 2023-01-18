<?php

namespace App\Repositories\Client\Order;

use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\Order::class;
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
