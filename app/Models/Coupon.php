<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function firstWithExpired($name, $user_id)
    {
        return $this->whereName($name)->whereDoesntHave('users', fn ($q) => $q->where('users.id', $user_id))->whereDate('expired', '>=', Carbon::now())->first();
    }
}
