<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $guarded = ['id'];

    public function coupons()
    {
        return $this->hasMany(Coupon::class, 'participant_id');
    }

    public function winning()
    {
        return $this->hasOne(Winner::class, 'participant_id');
    }
}
