<?php

namespace App\Imports;

use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithStartRow;

// ⚠️ PERHATIKAN: Saya SUDAH MENGHAPUS 'WithHeadingRow' di baris ini
class StoreImport implements ToCollection, WithChunkReading, WithCustomCsvSettings, WithStartRow 
{
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';', // Tetap pakai titik koma
        ];
    }

    // Mulai baca dari baris ke-2 (Baris 1 Header dilewati otomatis)
    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        $dataToInsert = [];
        $now = Carbon::now();

        foreach ($rows as $row) {
            
            // Validasi data kosong
            // Kita pakai index angka karena WithHeadingRow sudah dihapus
            if (empty(trim($row[0] ?? '')) || empty(trim($row[1] ?? ''))) {
                continue;
            }

            $dataToInsert[] = [
                'kode_toko'    => trim($row[0]), 
                'nama_toko'    => $row[1],
                'jenis_produk' => $row[2] ?? 'Umum',
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