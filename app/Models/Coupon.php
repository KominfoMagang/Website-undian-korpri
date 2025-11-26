<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = ['id'];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function isRedeemed(): bool
    {
        return !is_null($this->store_id);
    }
}
