<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public static function run(): void
    {
        User::truncate();

        // Buat Akun Admin Utama
        User::create([
            'nama' => 'Super Admin Korpri',
            'username' => 'korpri@2025',
            'password' => Hash::make('korpri@2025'), 
        ]);

        // Buat Akun Cadangan (Misal untuk Operator)
        User::create([
            'nama' => 'Operator Undian',
            'username' => 'king@2025',
            'password' => Hash::make('king@2025'),
        ]);
    }
}
