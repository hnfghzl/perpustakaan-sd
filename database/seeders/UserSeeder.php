<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama_user' => 'Admin Perpus2',
            'bergabung_sejak' => now(),
            'tgl_registrasi' => now(),
            'berlaku_hingga' => now()->addYears(5),
            'role' => 'pustakawan',
            'email' => 'hanafi@perpus.com',
            'password' => Hash::make('hanafi123'),
        ]);

        User::create([
            'nama_user' => 'Kepala Sekolah',
            'bergabung_sejak' => now(),
            'tgl_registrasi' => now(),
            'berlaku_hingga' => now()->addYears(5),
            'role' => 'kepala',
            'email' => 'kepala@perpus.com',
            'password' => Hash::make('kepala123'),
        ]);
    }
}
