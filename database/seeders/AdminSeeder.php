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
            'email' => 'admin@korpri.id',
            'password' => Hash::make('password'), // Password default: 'password'
            'email_verified_at' => now(),
        ]);

        // Buat Akun Cadangan (Misal untuk Operator)
        User::create([
            'nama' => 'Operator Undian',
            'email' => 'operator@korpri.id',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }
}
