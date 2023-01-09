<?php

namespace App\Collections;

class CartCollection extends ModelCollection
{

    public function getAll()
    {
        return $this->map(function ($model) {
            $model->product_count = $model->product_count;
            $model->total_price = $model->total_price;
            return $model;
        });
    }

    public function authCheck($param)
    {
        if (\auth()->check()) {
            return $param;
        }

        return 0;
    }
}
