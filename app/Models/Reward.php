<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(RewardCategory::class, 'reward_category_id');
    }

    public function winners()
    {
        return $this->hasMany(Winner::class, 'reward_id');
    }
}
