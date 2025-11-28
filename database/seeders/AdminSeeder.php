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

        User::create([
            'nama' => 'Super Admin Korpri',
            'username' => 'korpri_2025',
            'password' => Hash::make('M\*B"((L!aUSJ%j4'),
        ]);
    }
}
