<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'total',
        'ship',
        'customer_name',
        'customer_email',
        'customer_address',
        'customer_phone',
        'note',
        'payment',
        'user_id'
    ];

    public function getWithPaginateBy($user_id)
    {
        return $this->whereUserId($user_id)->latest('id')->paginate(12);
    }
}
