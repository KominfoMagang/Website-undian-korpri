<?php

namespace Database\Seeders;

use App\Models\Reward;
use App\Models\RewardCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public static function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Reward::truncate();
        RewardCategory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Buat Kategori Dulu
        $utama = RewardCategory::create(['nama_kategori' => 'Utama']);
        $umum = RewardCategory::create(['nama_kategori' => 'Umum']);

        // 2. Buat Hadiah (Rewards)
        // Menggunakan ID dari kategori yang baru dibuat di atas

        Reward::create([
            'reward_category_id' => $utama->id,
            'nama_hadiah' => 'Umroh',
            'gambar' => null, 
            'stok' => 1,
            'status_hadiah' => 'Aktif',
        ]);

        Reward::create([
            'reward_category_id' => $umum->id,
            'nama_hadiah' => 'Sepeda Gunung Polygon',
            'gambar' => null,
            'stok' => 10,
            'status_hadiah' => 'Aktif',
        ]);
    }
}
