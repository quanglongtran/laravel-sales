<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'value',
        'expired'
    ];

    public function getExpiredAttribute()
    {
        return Carbon::parse($this->attributes['expired'])->format('Y-m-d');
    }
}
