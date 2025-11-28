<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            // Cek apakah pakai S3 atau Lokal (Opsional, biar fleksibel)
            // Kalau yakin S3 terus, langsung return Storage::disk('s3')->url($this->foto);

            return Storage::disk('s3')->url($this->foto);
        }

        // Return Avatar Default
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama) . '&background=random';
    }
}
