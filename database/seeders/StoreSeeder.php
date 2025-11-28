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
                'kode_toko' => '123', // 5 digit
                'jenis_produk' => 'Bakso',
                'stok' => 50,
            ],
            [
                'nama_toko' => 'Toko Berkah Abadi',
                'kode_toko' => '567', // 6 digit
                'jenis_produk' => 'Mie Ayam',
                'stok' => 50,
            ],
            [
                'nama_toko' => 'Toko Maju Mundur',
                'kode_toko' => '241', // 5 digit
                'jenis_produk' => 'Batagor',
                'stok' => 50,
            ],
            [
                'nama_toko' => 'Toko Sumber Rejeki',
                'kode_toko' => '578', // 6 digit
                'jenis_produk' => 'Bakso Ikan',
                'stok' => 50,
            ],
            [
                'nama_toko' => 'Toko Serba Ada',
                'kode_toko' => '983', // 5 digit
                'jenis_produk' => 'Cilok',
                'stok' => 50,
            ],
        ];

        foreach ($data as $item) {
            Store::firstOrCreate(
                // Argumen 1: Kunci Pencarian (Cek apakah kode_toko ini ada?)
                ['kode_toko' => $item['kode_toko']],

                // Argumen 2: Data Create (Jika tidak ada, buat baru dengan data LENGKAP ini)
                [
                    'nama_toko' => $item['nama_toko'],
                    'jenis_produk' => $item['jenis_produk'], // Masukkan disini
                    'stok' => $item['stok']                  // Dan disini
                ]
            );
        }
    }
}
