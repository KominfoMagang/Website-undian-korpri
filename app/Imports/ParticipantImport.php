<?php

namespace App\Imports;

use App\Models\Participant;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ParticipantImport implements ToCollection, WithChunkReading
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
            if (trim($row[1]) == 'NIP' || empty($row[1])) {
                continue;
            }

            // Tampung data ke dalam Array dulu (JANGAN INSERT DISINI)
            $dataToInsert[] = [
                'nip'              => trim($row[1]),
                'nama'             => $row[2],
                'unit_kerja'       => $row[3],
                'created_at'       => $now,
                'updated_at'       => $now,
            ];
        }

        // 3. Eksekusi Masuk Database SEKALIGUS (Upsert)
        // Parameter 1: Array data
        // Parameter 2: Kolom unik (kunci pengecekan) -> 'nip'
        // Parameter 3: Kolom yang mau di-update kalau NIP sudah ada
        if (!empty($dataToInsert)) {
            Participant::upsert(
                $dataToInsert,
                ['nip'],
                ['nama', 'unit_kerja', 'updated_at']
            );
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
