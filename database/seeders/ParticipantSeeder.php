<?php

namespace Database\Seeders;

use App\Models\Participant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public static function run(): void
    {
        $faker = Faker::create('id_ID');

        $units = [
            'Dinas Pendidikan', 'Dinas Kesehatan', 'Dinas PUPR',
            'BAPPEDA', 'BKPSDM', 'Inspektorat', 'Satpol PP',
            'Dinas Perhubungan', 'Kecamatan Ciamis', 'Kecamatan Cikoneng',
            'Sekretariat Daerah'
        ];

        // --- BAGIAN PERBAIKAN ---
        // 1. Matikan Cek Foreign Key
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // 2. Kosongkan Tabel
        Participant::truncate();
        
        // 3. Nyalakan Lagi Cek Foreign Key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // ------------------------

        foreach (range(1, 50) as $i) {
            Participant::create([
                'nama' => $faker->name,
                'nip' => $faker->unique()->numerify('19##########1###'),
                'unit_kerja' => $faker->randomElement($units),
                'foto' => null,
                'status_hadir' => 'Tidak hadir',
                'latitude' => null,
                'longitude' => null,
                'sudah_menang' => false,
            ]);
        }
    }
}
