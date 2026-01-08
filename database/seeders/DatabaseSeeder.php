<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 🔹 Jalankan seeder UserSeeder
        $this->call(UserSeeder::class);

        // 🔹 Jalankan seeder AnggotaSeeder
        $this->call(AnggotaSeeder::class);

        // 🔹 Jalankan seeder KategoriSeeder
        $this->call(KategoriSeeder::class);

        // 🔹 Jalankan seeder BukuSeeder
        $this->call(BukuSeeder::class);

        // 🔹 Jalankan seeder EksemplarSeeder
        $this->call(EksemplarSeeder::class);
    }
}
