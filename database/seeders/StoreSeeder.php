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
        $stores = [
            ['kode_toko' => '452', 'nama_toko' => 'Ari Food', 'jenis_produk' => 'Es Macha + Jajanan Basah', 'stok' => 50],
            ['kode_toko' => '695', 'nama_toko' => 'Zupa Gembrot', 'jenis_produk' => 'Zupa', 'stok' => 50],
            ['kode_toko' => '435', 'nama_toko' => 'D\'KULUB', 'jenis_produk' => 'Kukuluban', 'stok' => 50],
            ['kode_toko' => '546', 'nama_toko' => 'Zams Snack', 'jenis_produk' => 'paket risol mayo', 'stok' => 50],
            ['kode_toko' => '674', 'nama_toko' => 'Gorjum', 'jenis_produk' => 'es teler', 'stok' => 50],
            ['kode_toko' => '133', 'nama_toko' => 'Faaza food', 'jenis_produk' => 'Cilok Kuah Seblak', 'stok' => 50],
            ['kode_toko' => '981', 'nama_toko' => 'Teokboki', 'jenis_produk' => 'Sate Yakitori', 'stok' => 50],
            ['kode_toko' => '731', 'nama_toko' => 'Baso Pak Jenal', 'jenis_produk' => 'Mie Baso', 'stok' => 50],
            ['kode_toko' => '772', 'nama_toko' => 'Cilok Ceu Ohay', 'jenis_produk' => 'Nasi pepes dan Kolak', 'stok' => 50],
            ['kode_toko' => '499', 'nama_toko' => 'Jajanan Miku', 'jenis_produk' => 'Dimsum dan Nasi Goreng Ayam Mentega', 'stok' => 50],
            ['kode_toko' => '556', 'nama_toko' => 'Rins Snack', 'jenis_produk' => 'Pizza', 'stok' => 50],
            ['kode_toko' => '619', 'nama_toko' => 'Dometz', 'jenis_produk' => 'Roti', 'stok' => 50],
            ['kode_toko' => '473', 'nama_toko' => 'Chemchem Cakes', 'jenis_produk' => 'Mini Tart', 'stok' => 50],
            ['kode_toko' => '567', 'nama_toko' => 'Bolen Shofia', 'jenis_produk' => 'Bolen', 'stok' => 50],
            ['kode_toko' => '242', 'nama_toko' => 'Baso Basway', 'jenis_produk' => 'Baso Aci', 'stok' => 50],
            ['kode_toko' => '233', 'nama_toko' => 'The Archies', 'jenis_produk' => 'Origini dan minuman coklat', 'stok' => 50],
            ['kode_toko' => '191', 'nama_toko' => 'Sakinah Kitchen', 'jenis_produk' => 'Puding dan Minumal Jelly', 'stok' => 50],
            ['kode_toko' => '552', 'nama_toko' => 'Awug Ruhaeti', 'jenis_produk' => 'Awug + Jajan Pasar', 'stok' => 50],
            ['kode_toko' => '154', 'nama_toko' => 'Es Teler 38', 'jenis_produk' => 'Es Teller', 'stok' => 50],
            ['kode_toko' => '643', 'nama_toko' => 'Dapur Kurnia', 'jenis_produk' => 'Es Teler / Dimsum Ayam', 'stok' => 50],
            ['kode_toko' => '361', 'nama_toko' => 'Zsazsa Cake', 'jenis_produk' => 'Es Cendol', 'stok' => 50],
        ];

        foreach ($stores as $storeData) {
            Store::updateOrCreate(
                ['kode_toko' => $storeData['kode_toko']],
                $storeData 
            );
        }
    }
}
