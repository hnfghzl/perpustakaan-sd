<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Buku;
use Carbon\Carbon;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bukus = [
            // Fiksi (kategori_id: 1)
            ['judul' => 'Laskar Pelangi', 'no_panggil' => '899.221 HID l', 'kategori_id' => 1],
            ['judul' => 'Bumi Manusia', 'no_panggil' => '899.221 TOE b', 'kategori_id' => 1],
            ['judul' => 'Negeri 5 Menara', 'no_panggil' => '899.221 FUA n', 'kategori_id' => 1],
            ['judul' => 'Ayat-Ayat Cinta', 'no_panggil' => '899.221 SHI a', 'kategori_id' => 1],
            ['judul' => 'Dilan: Dia adalah Dilanku Tahun 1990', 'no_panggil' => '899.221 PRA d', 'kategori_id' => 1],
            ['judul' => 'Perahu Kertas', 'no_panggil' => '899.221 DEE p', 'kategori_id' => 1],
            ['judul' => 'Sang Pemimpi', 'no_panggil' => '899.221 HID s', 'kategori_id' => 1],

            // Non-Fiksi (kategori_id: 2)
            ['judul' => 'Indonesia dalam Arus Sejarah', 'no_panggil' => '959.8 IND', 'kategori_id' => 2],
            ['judul' => 'Filosofi Teras', 'no_panggil' => '188 MAN f', 'kategori_id' => 2],
            ['judul' => 'Sapiens: Riwayat Singkat Umat Manusia', 'no_panggil' => '930 HAR s', 'kategori_id' => 2],
            ['judul' => 'Homo Deus: Masa Depan Umat Manusia', 'no_panggil' => '303.4 HAR h', 'kategori_id' => 2],
            ['judul' => 'Berani Tidak Disukai', 'no_panggil' => '158.1 KIS b', 'kategori_id' => 2],

            // Referensi (kategori_id: 3)
            ['judul' => 'Kamus Besar Bahasa Indonesia', 'no_panggil' => 'R 499.221 KAM', 'kategori_id' => 3],
            ['judul' => 'Ensiklopedia Indonesia', 'no_panggil' => 'R 030 ENS', 'kategori_id' => 3],
            ['judul' => 'Kamus Inggris-Indonesia', 'no_panggil' => 'R 423.21 ECH', 'kategori_id' => 3],
            ['judul' => 'Kamus Sinonim Bahasa Indonesia', 'no_panggil' => 'R 499.221 KAM s', 'kategori_id' => 3],

            // Sains & Teknologi (kategori_id: 4)
            ['judul' => 'Fisika untuk SMA Kelas X', 'no_panggil' => '530.076 FIS', 'kategori_id' => 4],
            ['judul' => 'Kimia Dasar', 'no_panggil' => '540 PET k', 'kategori_id' => 4],
            ['judul' => 'Biologi Campbell', 'no_panggil' => '570 REE b', 'kategori_id' => 4],
            ['judul' => 'Matematika SMA Kelas XI', 'no_panggil' => '510.076 MAT', 'kategori_id' => 4],
            ['judul' => 'Komputer dan Jaringan', 'no_panggil' => '004.6 KOM', 'kategori_id' => 4],
            ['judul' => 'Pemrograman Web dengan PHP', 'no_panggil' => '005.133 PHP', 'kategori_id' => 4],
            ['judul' => 'Database MySQL', 'no_panggil' => '005.756 MYS', 'kategori_id' => 4],

            // Sejarah (kategori_id: 5)
            ['judul' => 'Sejarah Indonesia Modern', 'no_panggil' => '959.8 RIC s', 'kategori_id' => 5],
            ['judul' => 'Sejarah Nasional Indonesia', 'no_panggil' => '959.8 SEJ', 'kategori_id' => 5],
            ['judul' => 'Panglima Besar Jenderal Sudirman', 'no_panggil' => '923.2 SUD p', 'kategori_id' => 5],
            ['judul' => 'Perang Kemerdekaan Indonesia', 'no_panggil' => '959.803 PER', 'kategori_id' => 5],

            // Biografi (kategori_id: 6)
            ['judul' => 'Soekarno: Biografi Lengkap', 'no_panggil' => '923.2 SOE', 'kategori_id' => 6],
            ['judul' => 'BJ Habibie: Detik-Detik yang Menentukan', 'no_panggil' => '923.2 HAB', 'kategori_id' => 6],
            ['judul' => 'Steve Jobs', 'no_panggil' => '923.2 ISA s', 'kategori_id' => 6],
            ['judul' => 'Biografi Kartini', 'no_panggil' => '923.2 KAR', 'kategori_id' => 6],

            // Agama (kategori_id: 7)
            ['judul' => 'Al-Quran dan Terjemahan', 'no_panggil' => '297.122 ALQ', 'kategori_id' => 7],
            ['judul' => 'Fiqih Islam Lengkap', 'no_panggil' => '297.3 SUL f', 'kategori_id' => 7],
            ['judul' => 'Kisah-Kisah dalam Al-Quran', 'no_panggil' => '297.122 KIS', 'kategori_id' => 7],
            ['judul' => 'Hadits Shahih Bukhari', 'no_panggil' => '297.124 HAD', 'kategori_id' => 7],
            ['judul' => 'Akhlak Mulia', 'no_panggil' => '297.5 AKH', 'kategori_id' => 7],

            // Anak-Anak (kategori_id: 8)
            ['judul' => 'Si Juki: Komik Anak', 'no_panggil' => 'J 741.5 FAZ s', 'kategori_id' => 8],
            ['judul' => 'Dongeng Anak Nusantara', 'no_panggil' => 'J 398.2 DON', 'kategori_id' => 8],
            ['judul' => 'Seri Aku Anak Cerdas', 'no_panggil' => 'J 372.4 SER', 'kategori_id' => 8],
            ['judul' => 'Cerita Hewan untuk Anak', 'no_panggil' => 'J 398.2 CER', 'kategori_id' => 8],
            ['judul' => 'Petualangan Si Kancil', 'no_panggil' => 'J 398.2 PET', 'kategori_id' => 8],
            ['judul' => 'Belajar Mengenal Angka', 'no_panggil' => 'J 372.7 BEL', 'kategori_id' => 8],

            // Majalah (kategori_id: 9)
            ['judul' => 'National Geographic Indonesia', 'no_panggil' => 'M 910.5 NAT', 'kategori_id' => 9],
            ['judul' => 'Bobo - Majalah Anak', 'no_panggil' => 'M 050 BOB', 'kategori_id' => 9],
            ['judul' => 'Tempo Edisi Khusus', 'no_panggil' => 'M 070 TEM', 'kategori_id' => 9],

            // Komik (kategori_id: 10)
            ['judul' => 'Tintin: Petualangan di Tibet', 'no_panggil' => 'K 741.5 HER t', 'kategori_id' => 10],
            ['judul' => 'Naruto Vol. 1', 'no_panggil' => 'K 741.5 MAS n', 'kategori_id' => 10],
            ['judul' => 'One Piece Vol. 1', 'no_panggil' => 'K 741.5 ODA o', 'kategori_id' => 10],
            ['judul' => 'Detektif Conan Vol. 1', 'no_panggil' => 'K 741.5 AOY d', 'kategori_id' => 10],
            ['judul' => 'Doraemon: Petualangan Nobita', 'no_panggil' => 'K 741.5 FUJ d', 'kategori_id' => 10]
        ];

        foreach ($bukus as $buku) {
            Buku::create($buku);
        }
    }
}
