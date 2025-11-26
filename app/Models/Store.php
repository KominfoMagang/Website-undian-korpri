<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $guarded = ['id'];

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'store_id');
    }
}
