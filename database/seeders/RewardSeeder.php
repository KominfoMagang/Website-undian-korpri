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
        // 1. Bersihkan Data Lama
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Reward::truncate();
        RewardCategory::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. Buat Kategori
        $utama = RewardCategory::create(['nama_kategori' => 'Utama']);
        $umum  = RewardCategory::create(['nama_kategori' => 'Umum']);

        // 3. HADIAH UTAMA (UMROH)
        Reward::create([
            'reward_category_id' => $utama->id,
            'nama_hadiah'        => 'Paket Umroh',
            'stok'               => 1,
            'status_hadiah'      => 'Aktif',
            'gambar'             => null,
        ]);

        // 4. HADIAH UMUM (Sesuai List Gambar)
        $daftarHadiahUmum = [
            ['nama' => 'Uang Tabungan RP 1 Juta', 'gambar' => 'tabungan.png', 'stok' => 10],
            ['nama' => 'TV 43 Inch', 'gambar' => 'Tv.png',  'stok' => 1],
            ['nama' => 'Lemari Es',  'gambar' => 'kulkas.png',       'stok' => 1],
            ['nama' => 'Mesin Cuci', 'gambar' => 'mesin_cuci.png',    'stok' => 1],
            ['nama' => 'Dispenser', 'gambar' => 'dispenser.png',   'stok' => 2],
            ['nama' => 'Kompor Gas', 'gambar' => 'kompor.png',   'stok' => 5],
            ['nama' => 'Microwave',  'gambar' => 'microwave.png',    'stok' => 1],
            ['nama' => 'Rice Cooker', 'gambar' => 'rice_cooker.png',   'stok' => 5],
        ];

        foreach ($daftarHadiahUmum as $item) {
            Reward::create([
                'reward_category_id' => $umum->id,
                'nama_hadiah'        => $item['nama'],
                'stok'               => $item['stok'],
                'status_hadiah'      => 'Aktif',
                'gambar'             => null,
            ]);
        }
    }
}
