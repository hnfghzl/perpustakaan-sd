<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\Eksemplar;
use Carbon\Carbon;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $bukus = [];

        // 1. Buku Tematik Terpadu Kelas 1-6 (Kurikulum 2013) - 54 Buku
        // Kategori: 11 (Buku Pelajaran)
        $temaNames = ['Diriku', 'Kegemaranku', 'Kegiatanku', 'Keluargaku', 'Pengalamanku', 'Lingkungan Bersih', 'Benda, Hewan, dan Tanaman', 'Peristiwa Alam', 'Pramuka'];
        for ($kelas = 1; $kelas <= 6; $kelas++) {
            for ($tema = 1; $tema <= 9; $tema++) {
                $judul = "Buku Siswa Tematik Kelas $kelas Tema $tema: " . ($temaNames[$tema-1] ?? "Tema $tema");
                $bukus[] = [
                    'judul' => $judul, 'pengarang' => 'Kemdikbud', 'penerbit' => 'Kemdikbud RI', 'tahun_terbit' => 2018,
                    'no_panggil' => "372.1 KEM b", 'kategori_id' => 11, 'eksemplar' => 32 // 32 copy per kelas
                ];
            }
        }

        // 2. Pendidikan Agama Islam & Matematika & Pancasila - 13 Buku
        for ($i = 1; $i <= 6; $i++) {
            $bukus[] = ['judul' => "Pendidikan Agama Islam dan Budi Pekerti Kelas $i", 'pengarang' => 'Andi Prastowo', 'penerbit' => 'Kemdikbud RI', 'tahun_terbit' => 2018, 'no_panggil' => "297.07 AND p", 'kategori_id' => 11, 'eksemplar' => 32];
        }
        foreach([4,5,6] as $i) {
            $bukus[] = ['judul' => "Buku Siswa Matematika SD/MI Kelas $i", 'pengarang' => 'Gunanto & Dhesy Adhalia', 'penerbit' => 'Penerbit Erlangga', 'tahun_terbit' => 2019, 'no_panggil' => "510 GUN m", 'kategori_id' => 11, 'eksemplar' => 32];
        }
        foreach([1,2,4,5] as $i) {
            $bukus[] = ['judul' => "Buku Siswa Pendidikan Pancasila Kelas $i", 'pengarang' => 'Pusat Kurikulum', 'penerbit' => 'Kemdikbudristek', 'tahun_terbit' => 2022, 'no_panggil' => "320.5 PUS p", 'kategori_id' => 11, 'eksemplar' => 32];
        }

        // 3. Cerita Rakyat Nusantara (34 Buku)
        // Kategori: 8 (Anak-Anak)
        $folklore = [
            'Danau Toba (Sumatera Utara)', 'Malin Kundang (Sumatera Barat)', 'Bawang Merah Bawang Putih (Riau)', 'Sangkuriang (Jawa Barat)', 'Lutung Kasarung (Jawa Barat)',
            'Timun Mas (Jawa Tengah)', 'Keong Mas (Jawa Timur)', 'Ande-Ande Lumut (Jawa Timur)', 'Jaka Tarub (Jawa Tengah)', 'Roro Jonggrang (DI Yogyakarta)',
            'Si Pitung (DKI Jakarta)', 'Legenda Gunung Bromo (Jawa Timur)', 'Asal Mula Selat Bali (Bali)', 'Batu Menangis (Kalimantan Barat)', 'Legenda Pesut Mahakam (Kalimantan Timur)',
            'Cindelaras (Jawa Timur)', 'Kisah Pulau Senoa (Kepulauan Riau)', 'Kisah Tangkuban Perahu (Jawa Barat)', 'Asal Usul Danau Lipan (Kalimantan Timur)', 'Telaga Bidadari (Kalimantan Selatan)',
            'Legenda Ular N\'daung (Bengkulu)', 'Asal Mula Nama Kota Palembang (Sumatera Selatan)', 'Legenda Danau Dendam Tak Sudah (Bengkulu)', 'Kisah Si Lancang (Riau)', 'Putri Pandan Berduri (Kepulauan Riau)',
            'Kisah Roro Mendut (Jawa Tengah)', 'Legenda Candi Prambanan (DI Yogyakarta)', 'Arya Penangsang (Jawa Tengah)', 'Misteri Gunung Kelud (Jawa Timur)', 'Asal Usul Kota Surabaya (Jawa Timur)',
            'Kisah Telaga Sarangan (Jawa Timur)', 'Legenda Reog Ponorogo (Jawa Timur)', 'Joko Dolog (Jawa Timur)', 'Legenda Pulau Kemaro (Sumatera Selatan)'
        ];
        foreach ($folklore as $cerita) {
            $bukus[] = ['judul' => "Cerita Rakyat Nusantara: $cerita", 'pengarang' => 'Dian K.', 'penerbit' => 'Bhuana Ilmu Populer', 'tahun_terbit' => 2016, 'no_panggil' => "398.2 DIA c", 'kategori_id' => 8, 'eksemplar' => 2];
        }

        // 4. Kisah 25 Nabi dan Rasul (25 Buku)
        // Kategori: 7 (Agama)
        $nabis = ['Adam', 'Idris', 'Nuh', 'Hud', 'Sholeh', 'Ibrahim', 'Luth', 'Ismail', 'Ishaq', 'Yaqub', 'Yusuf', 'Ayyub', 'Syu\'aib', 'Musa', 'Harun', 'Dzulkifli', 'Daud', 'Sulaiman', 'Ilyas', 'Ilyasa', 'Yunus', 'Zakariyya', 'Yahya', 'Isa', 'Muhammad'];
        foreach ($nabis as $nabi) {
            $bukus[] = ['judul' => "Kisah Teladan Nabi $nabi AS", 'pengarang' => 'MB. Rahimsyah', 'penerbit' => 'Serba Jaya', 'tahun_terbit' => 2010, 'no_panggil' => "297.24 RAH k", 'kategori_id' => 7, 'eksemplar' => 3];
        }

        // 5. Seri Pahlawan Nasional (15 Buku)
        // Kategori: 6 (Biografi)
        $pahlawans = ['Soekarno', 'Mohammad Hatta', 'Jenderal Sudirman', 'Pangeran Diponegoro', 'Cut Nyak Dien', 'Ki Hajar Dewantara', 'R.A. Kartini', 'Pattimura', 'Tuanku Imam Bonjol', 'Teuku Umar', 'Sultan Hasanuddin', 'Kapitan Pattimura', 'Martha Christina Tiahahu', 'Cut Meutia', 'Dewi Sartika'];
        foreach ($pahlawans as $p) {
            $bukus[] = ['judul' => "Mengenal Pahlawan Nasional: $p", 'pengarang' => 'Watiek Ideo', 'penerbit' => 'Bhuana Ilmu Populer', 'tahun_terbit' => 2018, 'no_panggil' => "923 WAT m", 'kategori_id' => 6, 'eksemplar' => 2];
        }

        // 6. Ensiklopedia (10 Buku)
        // Kategori: 3 (Referensi)
        $ensiklopedia = ['Luar Angkasa', 'Dinosaurus', 'Tubuh Manusia', 'Hewan Mamalia', 'Serangga', 'Bumi dan Alam Semesta', 'Teknologi dan Penemuan', 'Negara-Negara di Dunia', 'Kendaraan dan Transportasi', 'Tumbuhan dan Bunga'];
        foreach ($ensiklopedia as $e) {
            $bukus[] = ['judul' => "Ensiklopedia Anak Pintar: $e", 'pengarang' => 'Tim Nuansa', 'penerbit' => 'Nuansa Cendekia', 'tahun_terbit' => 2021, 'no_panggil' => "R 030 TIM e", 'kategori_id' => 3, 'eksemplar' => 3];
        }

        // 7. KKPK (Kecil-Kecil Punya Karya) - Fiksi Anak (20 Buku)
        // Kategori: 1 (Fiksi)
        for ($i=1; $i<=20; $i++) {
            $tahun = rand(2015, 2023);
            $bukus[] = ['judul' => "KKPK: Petualangan Misteri ke-$i", 'pengarang' => 'Muthia Fadhila', 'penerbit' => 'DAR! Mizan', 'tahun_terbit' => $tahun, 'no_panggil' => "813 MUT k", 'kategori_id' => 1, 'eksemplar' => 2];
        }

        // 8. Pengetahuan Seri WHY? (10 Buku)
        // Kategori: 4 (Sains & Teknologi)
        $whys = ['Komputer', 'Robot', 'Bumi', 'Sains Sehari-hari', 'Lingkungan', 'Cuaca', 'Cahaya dan Suara', 'Air', 'Pubertas', 'Alat Transportasi'];
        foreach ($whys as $w) {
            $bukus[] = ['judul' => "Why? - $w", 'pengarang' => 'YeaRimDang', 'penerbit' => 'Elex Media Komputindo', 'tahun_terbit' => 2019, 'no_panggil' => "500 YEA w", 'kategori_id' => 4, 'eksemplar' => 3];
        }

        // 9. Majalah Anak (10 Buku)
        // Kategori: 9 (Majalah)
        for ($i=1; $i<=10; $i++) {
            $bukus[] = ['judul' => "Majalah Bobo Edisi No. $i Tahun 2024", 'pengarang' => 'Redaksi Bobo', 'penerbit' => 'Kompas Gramedia', 'tahun_terbit' => 2024, 'no_panggil' => "M 050 RED m", 'kategori_id' => 9, 'eksemplar' => 1];
        }

        // 10. Komik Doraemon (9 Buku)
        // Kategori: 10 (Komik)
        for ($i=1; $i<=9; $i++) {
            $bukus[] = ['judul' => "Doraemon Vol. $i", 'pengarang' => 'Fujiko F. Fujio', 'penerbit' => 'Elex Media Komputindo', 'tahun_terbit' => 2010+$i, 'no_panggil' => "K 741.5 FUJ d", 'kategori_id' => 10, 'eksemplar' => 2];
        }

        // === INSERT INTO DATABASE ===
        // To be safe with memory and execution time, we process them one by one.
        foreach ($bukus as $index => $b) {
            $jumlahEks = $b['eksemplar'];
            unset($b['eksemplar']); // Remove virtual property before insert
            
            $bukuModel = Buku::create($b);

            // Create Eksemplar
            $eksemplarData = [];
            for ($j=1; $j<=$jumlahEks; $j++) {
                $status = 'tersedia';
                // Some realistic statuses:
                $rand = rand(1, 100);
                if ($rand > 95) $status = 'hilang';
                elseif ($rand > 90) $status = 'rusak';
                elseif ($rand > 80) $status = 'dipinjam';

                $eksemplarData[] = [
                    'id_buku' => $bukuModel->id_buku,
                    'kode_eksemplar' => $bukuModel->id_buku . '-' . str_pad($j, 3, '0', STR_PAD_LEFT),
                    'lokasi_rak' => 'RAK-' . chr(64 + $b['kategori_id']) . '-' . rand(1, 5),
                    'tipe_lokasi' => 'perpustakaan',
                    'status_eksemplar' => $status,
                    'harga' => rand(25, 80) * 1000,
                    'tgl_diterima' => Carbon::now()->subDays(rand(10, 1000))->format('Y-m-d'),
                    'sumber_perolehan' => (rand(1,10) > 2) ? 'beli' : 'hadiah',
                    'faktur' => 'FKT-' . date('Y') . '-' . rand(1000,9999),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            }
            // Insert array in chunks for speed
            Eksemplar::insert($eksemplarData);
        }
    }
}
