<?php

namespace App\Imports;

use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class StoreImport implements ToCollection, WithChunkReading
{
    public function collection(Collection $rows)
    {
        $dataToInsert = [];
        $now = Carbon::now();

        foreach ($rows as $row) {
            
            $valKode = trim($row[0] ?? '');

            // --- FILTER SAKTI ---
            // 1. Cek kosong
            if (empty($valKode)) continue;

            // 2. Cek Tulisan Header (Manual)
            // Kita bersihkan dulu stringnya dari karakter aneh biar yakin
            $cleanStr = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $valKode));
            if ($cleanStr == 'kodetoko') continue;

            // 3. FILTER PAMUNGKAS: Cek Numeric
            // Header "Kode Toko" itu BUKAN angka. Data "10542" itu angka.
            // Jadi kalau BUKAN angka, kita anggap itu header/sampah, SKIP aja.
            if (!is_numeric($valKode)) {
                continue; 
            }
            // --------------------

            $dataToInsert[] = [
                'kode_toko'    => $valKode,
                'nama_toko'    => $row[1],
                'jenis_produk' => $row[2] ?? 'Umum',
                // Pastikan stok jadi angka, default 0
                'stok'         => isset($row[3]) && is_numeric($row[3]) ? $row[3] : 0, 
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }

        if (!empty($dataToInsert)) {
            Store::upsert(
                $dataToInsert,
                ['kode_toko'],
                ['nama_toko', 'jenis_produk', 'stok', 'updated_at']
            );
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}