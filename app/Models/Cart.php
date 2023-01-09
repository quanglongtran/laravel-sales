<?php

namespace App\Models;

use App\Collections\CartCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    /**
     * Custom collection
     *
     * @param  mixed $models
     * @return void
     */
    public function newCollection(array $models = [])
    {
        return new CartCollection($models);
    }

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function getBy($user_id)
    {
        return Cart::whereUserId($user_id)->first();
    }

    public function firstOrCreateBy($user_id)
    {
        $cart = $this->getBy($user_id);

        if (!$cart) {
            $cart = $this->create(['user_id' => $user_id]);
        }

        return $cart;
    }

    public function getProductCountAttribute()
    {
        return $this->authCheck($this->cartProducts()->count());
    }

    public function getTotalPriceAttribute()
    {
        return $this->authCheck($this->cartProducts()->with('product')->get()->reduce(function ($init, $current) {
            return $init + $current->product->price;
        }));
    }

    public function authCheck($param)
    {
        if (\auth()->check()) {
            return $param;
        }

        return 0;
    }
}
