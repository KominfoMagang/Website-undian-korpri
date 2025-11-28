<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public static function run(): void
    {
        Setting::create([
            'key' => 'status_absensi',
            'value' => 'tutup'
        ]);

        Setting::create([
            'key' => 'limit_voucher',
            'value' => '1'
        ]);
    }
}
