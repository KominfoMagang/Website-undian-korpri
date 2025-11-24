<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardCategory extends Model
{
    protected $guarded = ['id'];

    public function rewards()
    {
        return $this->hasMany(Reward::class, 'reward_category_id');
    }
}
