<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Participant;
use App\Models\Store;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Pest\Support\Str;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public static function run(): void
    {
        $faker = Faker::create('id_ID');

        $units = [
            'Dinas Pendidikan',
            'Dinas Kesehatan',
            'Dinas PUPR',
            'BAPPEDA',
            'BKPSDM',
            'Inspektorat',
            'Satpol PP',
            'Dinas Perhubungan',
            'Kecamatan Ciamis',
            'Kecamatan Cikoneng',
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
                'nip' => $faker->unique()->numerify('19##########1#####'),
                'unit_kerja' => $faker->randomElement($units),
                'foto' => null,
                'status_hadir' => 'Tidak hadir',
                'latitude' => null,
                'longitude' => null,
                'sudah_menang' => false,
            ]);
        }

        // foreach (range(1, 5) as $i) {
        //     $participant = Participant::create([
        //         'nama' => $faker->name,
        //         'nip' => $faker->unique()->numerify('19##########1#####'),
        //         'unit_kerja' => $faker->randomElement($units),
        //         'foto' => null,
        //         'status_hadir' => 'Hadir',
        //         'latitude' => '-7.230316356025819',
        //         'longitude' => '108.1546012707976',
        //         'sudah_menang' => false,
        //     ]);

        //     Coupon::create([
        //         'participant_id' => $participant->id,
        //         'kode_kupon' => mt_rand(100000, 999999),
        //         'status_kupon' => 'Aktif',
        //     ]);
        // }

        // foreach(range(1,5) as $i){
        //     Store::create([
        //         'nama_toko'=> $faker->company,
        //         'kode_toko'=> str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT)
        //     ]);
        // }
    }
}
