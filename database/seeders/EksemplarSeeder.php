<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\Eksemplar;
use Carbon\Carbon;

class EksemplarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua buku
        $bukus = Buku::all();

        // Untuk setiap buku, buat 2-5 eksemplar
        foreach ($bukus as $buku) {
            // Random jumlah eksemplar antara 2-5
            $jumlahEksemplar = rand(2, 5);

            for ($i = 1; $i <= $jumlahEksemplar; $i++) {
                // Generate kode eksemplar: ID_BUKU-NOMOR (contoh: 1-001, 1-002)
                $kodeEksemplar = $buku->id_buku . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);

                // Random status - kebanyakan tersedia (80%), sisanya dipinjam/rusak
                $rand = rand(1, 100);
                if ($rand <= 80) {
                    $status = 'tersedia';
                } elseif ($rand <= 95) {
                    $status = 'dipinjam';
                } else {
                    $status = 'rusak';
                }

                // Generate data lokasi rak
                $lokasiRak = 'RAK-' . chr(65 + rand(0, 5)) . '-' . rand(1, 10); // RAK-A-1 sampai RAK-F-10

                Eksemplar::create([
                    'id_buku' => $buku->id_buku,
                    'kode_eksemplar' => $kodeEksemplar,
                    'lokasi_rak' => $lokasiRak,
                    'tipe_lokasi' => 'perpustakaan',
                    'status_eksemplar' => $status,
                    'harga' => rand(50000, 500000), // Harga antara 50rb - 500rb
                    'tgl_diterima' => Carbon::now()->subDays(rand(30, 1000)), // 30 hari sampai 3 tahun yang lalu
                    'sumber_perolehan' => rand(0, 1) ? 'beli' : 'hadiah',
                    'faktur' => 'FKT-' . date('Ymd') . '-' . rand(1000, 9999)
                ]);
            }
        }
    }
}
