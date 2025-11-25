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
        $katKendaraan = RewardCategory::create(['nama_kategori' => 'Kendaraan']);
        $katElektronik = RewardCategory::create(['nama_kategori' => 'Elektronik']);
        $katRumahTangga = RewardCategory::create(['nama_kategori' => 'Peralatan Rumah Tangga']);
        $katVoucher = RewardCategory::create(['nama_kategori' => 'Voucher & Uang Tunai']);

        // 2. Buat Hadiah (Rewards)
        // Menggunakan ID dari kategori yang baru dibuat di atas

        // --- KATEGORI KENDARAAN ---
        Reward::create([
            'reward_category_id' => $katKendaraan->id,
            'nama_hadiah' => 'Sepeda Motor Listrik Polytron',
            'gambar' => null, // Nanti bisa diupload manual, atau isi URL dummy
            'stok' => 1,
            'status_hadiah' => 'Aktif',
        ]);

        Reward::create([
            'reward_category_id' => $katKendaraan->id,
            'nama_hadiah' => 'Sepeda Gunung Polygon',
            'gambar' => null,
            'stok' => 3,
            'status_hadiah' => 'Aktif',
        ]);

        // --- KATEGORI ELEKTRONIK ---
        Reward::create([
            'reward_category_id' => $katElektronik->id,
            'nama_hadiah' => 'Smart TV Samsung 43 Inch',
            'gambar' => null,
            'stok' => 2,
            'status_hadiah' => 'Aktif',
        ]);

        Reward::create([
            'reward_category_id' => $katElektronik->id,
            'nama_hadiah' => 'Kulkas 2 Pintu Sharp',
            'gambar' => null,
            'stok' => 2,
            'status_hadiah' => 'Aktif',
        ]);

        Reward::create([
            'reward_category_id' => $katElektronik->id,
            'nama_hadiah' => 'Mesin Cuci 1 Tabung',
            'gambar' => null,
            'stok' => 2,
            'status_hadiah' => 'Aktif',
        ]);

        Reward::create([
            'reward_category_id' => $katElektronik->id,
            'nama_hadiah' => 'Smartphone Samsung Galaxy A series',
            'gambar' => null,
            'stok' => 5,
            'status_hadiah' => 'Aktif',
        ]);

        // --- KATEGORI RUMAH TANGGA ---
        Reward::create([
            'reward_category_id' => $katRumahTangga->id,
            'nama_hadiah' => 'Magic Com Philips',
            'gambar' => null,
            'stok' => 10,
            'status_hadiah' => 'Aktif',
        ]);

        Reward::create([
            'reward_category_id' => $katRumahTangga->id,
            'nama_hadiah' => 'Kompor Gas Rinnai 2 Tungku',
            'gambar' => null,
            'stok' => 10,
            'status_hadiah' => 'Aktif',
        ]);

        Reward::create([
            'reward_category_id' => $katRumahTangga->id,
            'nama_hadiah' => 'Kipas Angin Cosmos Standing',
            'gambar' => null,
            'stok' => 15,
            'status_hadiah' => 'Aktif',
        ]);

        Reward::create([
            'reward_category_id' => $katRumahTangga->id,
            'nama_hadiah' => 'Setrika Listrik',
            'gambar' => null,
            'stok' => 20,
            'status_hadiah' => 'Aktif',
        ]);

        // --- KATEGORI VOUCHER (Contoh hadiah tidak aktif) ---
        Reward::create([
            'reward_category_id' => $katVoucher->id,
            'nama_hadiah' => 'Voucher Belanja 500rb (Tahun Lalu)',
            'gambar' => null,
            'stok' => 0,
            'status_hadiah' => 'Tidak aktif',
        ]);
    }
}
