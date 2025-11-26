<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public static function run(): void
    {
        $data = [
            [
                'nama_toko' => 'Toko Sinar Jaya',
                'kode_toko' => '10542', // 5 digit
            ],
            [
                'nama_toko' => 'Toko Berkah Abadi',
                'kode_toko' => '220451', // 6 digit
            ],
            [
                'nama_toko' => 'Toko Maju Mundur',
                'kode_toko' => '55901', // 5 digit
            ],
            [
                'nama_toko' => 'Toko Sumber Rejeki',
                'kode_toko' => '881023', // 6 digit
            ],
            [
                'nama_toko' => 'Toko Serba Ada',
                'kode_toko' => '90124', // 5 digit
            ],
        ];

        foreach ($data as $item) {
            Store::firstOrCreate(
                ['kode_toko' => $item['kode_toko']],
                ['nama_toko' => $item['nama_toko']]
            );
        }
    }
}
