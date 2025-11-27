<?php

namespace App\Imports;

use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StoreImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $dataToInsert = [];
        $now = Carbon::now();

        foreach ($rows as $row) {
            // Validasi sederhana: Jika kode toko atau nama toko kosong, skip
            // Enaknya pakai WithHeadingRow, kita panggil pakai nama key array-nya
            // Excel: "Kode Toko" -> PHP: $row['kode_toko']

            if (empty($row['kode_toko']) || empty($row['nama_toko'])) {
                continue;
            }

            $dataToInsert[] = [
                'kode_toko'    => trim($row['kode_toko']), // Sesuaikan dengan Header di Excel
                'nama_toko'    => $row['nama_toko'],
                'jenis_produk' => $row['jenis_produk'] ?? 'Umum', // Default jika kosong
                'stok'         => $row['stok'] ?? 0,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }

        // Upsert Database
        if (!empty($dataToInsert)) {
            Store::upsert(
                $dataToInsert,
                ['kode_toko'], // Kolom Unik (Acuan update)
                ['nama_toko', 'jenis_produk', 'stok', 'updated_at'] // Kolom yang diupdate jika ada
            );
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
