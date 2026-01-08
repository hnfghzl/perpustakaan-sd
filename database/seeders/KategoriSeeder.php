<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;
use Carbon\Carbon;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama' => 'Fiksi',
                'deskripsi' => 'Buku cerita fiksi, novel, dan karya sastra',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Non-Fiksi',
                'deskripsi' => 'Buku pengetahuan umum dan fakta',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Referensi',
                'deskripsi' => 'Kamus, ensiklopedia, dan buku referensi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Sains & Teknologi',
                'deskripsi' => 'Buku ilmu pengetahuan alam dan teknologi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Sejarah',
                'deskripsi' => 'Buku sejarah lokal, nasional, dan dunia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Biografi',
                'deskripsi' => 'Kisah hidup tokoh-tokoh terkenal',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Agama',
                'deskripsi' => 'Buku agama dan spiritualitas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Anak-Anak',
                'deskripsi' => 'Buku cerita dan pengetahuan untuk anak-anak',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Majalah',
                'deskripsi' => 'Majalah pendidikan dan umum',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nama' => 'Komik',
                'deskripsi' => 'Komik edukatif dan hiburan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}
