<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggota;
use Carbon\Carbon;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $anggota = [
            // Data Guru
            [
                'nama_anggota' => 'Siti Nurjanah, S.Pd',
                'email' => 'siti.nurjanah@sdmuhkarangwaru.sch.id',
                'jenis_anggota' => 'guru',
                'tgl_lahir' => '1985-05-15',
                'anggota_sejak' => '2020-07-01',
                'tgl_registrasi' => '2020-07-01',
                'berlaku_hingga' => '2030-07-01',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Karangwaru No. 45, Yogyakarta',
            ],
            [
                'nama_anggota' => 'Ahmad Fauzi, S.Pd',
                'email' => 'ahmad.fauzi@sdmuhkarangwaru.sch.id',
                'jenis_anggota' => 'guru',
                'tgl_lahir' => '1980-03-22',
                'anggota_sejak' => '2019-01-15',
                'tgl_registrasi' => '2019-01-15',
                'berlaku_hingga' => '2029-01-15',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Magelang KM 5, Yogyakarta',
            ],
            [
                'nama_anggota' => 'Rina Wulandari, S.Pd',
                'email' => 'rina.wulandari@sdmuhkarangwaru.sch.id',
                'jenis_anggota' => 'guru',
                'tgl_lahir' => '1988-11-08',
                'anggota_sejak' => '2021-08-01',
                'tgl_registrasi' => '2021-08-01',
                'berlaku_hingga' => '2031-08-01',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Kaliurang KM 7, Sleman, Yogyakarta',
            ],
            [
                'nama_anggota' => 'Budi Santoso, S.Pd',
                'jenis_anggota' => 'guru',
                'tgl_lahir' => '1983-07-30',
                'anggota_sejak' => '2018-06-15',
                'tgl_registrasi' => '2018-06-15',
                'berlaku_hingga' => '2028-06-15',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Gejayan No. 12, Yogyakarta',
            ],
            [
                'nama_anggota' => 'Dewi Kusumawati, S.Pd',
                'jenis_anggota' => 'guru',
                'tgl_lahir' => '1990-02-14',
                'anggota_sejak' => '2022-01-10',
                'tgl_registrasi' => '2022-01-10',
                'berlaku_hingga' => '2032-01-10',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Seturan Raya No. 88, Sleman',
            ],

            // Data Siswa Kelas 6
            [
                'nama_anggota' => 'Muhammad Rizki Pratama',
                'email' => 'rizki.pratama.6a@sdmuhkarangwaru.sch.id',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2013-04-12',
                'anggota_sejak' => '2019-07-15',
                'tgl_registrasi' => '2019-07-15',
                'berlaku_hingga' => '2025-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Gondokusuman No. 23, Yogyakarta',
            ],
            [
                'nama_anggota' => 'Salsabila Putri Azzahra',
                'email' => 'salsabila.azzahra.6b@sdmuhkarangwaru.sch.id',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2013-08-25',
                'anggota_sejak' => '2019-07-15',
                'tgl_registrasi' => '2019-07-15',
                'berlaku_hingga' => '2025-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Affandi No. 15, Yogyakarta',
            ],

            // Data Siswa Kelas 5
            [
                'nama_anggota' => 'Farhan Maulana',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2014-03-18',
                'anggota_sejak' => '2020-07-15',
                'tgl_registrasi' => '2020-07-15',
                'berlaku_hingga' => '2026-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Kaliurang KM 5, Sleman',
            ],
            [
                'nama_anggota' => 'Zahra Aulia Rahman',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2014-11-05',
                'anggota_sejak' => '2020-07-15',
                'tgl_registrasi' => '2020-07-15',
                'berlaku_hingga' => '2026-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Palagan No. 77, Sleman',
            ],
            [
                'nama_anggota' => 'Aditya Kusuma Wijaya',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2014-06-20',
                'anggota_sejak' => '2020-07-15',
                'tgl_registrasi' => '2020-07-15',
                'berlaku_hingga' => '2026-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Janti No. 34, Banguntapan',
            ],

            // Data Siswa Kelas 4
            [
                'nama_anggota' => 'Nabila Syifa Kamila',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2015-09-10',
                'anggota_sejak' => '2021-07-15',
                'tgl_registrasi' => '2021-07-15',
                'berlaku_hingga' => '2027-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Magelang KM 3, Yogyakarta',
            ],
            [
                'nama_anggota' => 'Raffi Ahmad Nugroho',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2015-02-28',
                'anggota_sejak' => '2021-07-15',
                'tgl_registrasi' => '2021-07-15',
                'berlaku_hingga' => '2027-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Ringroad Utara No. 56, Sleman',
            ],

            // Data Siswa Kelas 3
            [
                'nama_anggota' => 'Kirana Putri Maharani',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2016-05-15',
                'anggota_sejak' => '2022-07-15',
                'tgl_registrasi' => '2022-07-15',
                'berlaku_hingga' => '2028-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Selokan Mataram No. 99, Sleman',
            ],
            [
                'nama_anggota' => 'Akbar Maulana Yusuf',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2016-12-03',
                'anggota_sejak' => '2022-07-15',
                'tgl_registrasi' => '2022-07-15',
                'berlaku_hingga' => '2028-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Kusumanegara No. 45, Yogyakarta',
            ],
            [
                'nama_anggota' => 'Alya Safira Putri',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2016-07-22',
                'anggota_sejak' => '2022-07-15',
                'tgl_registrasi' => '2022-07-15',
                'berlaku_hingga' => '2028-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Gejayan Santren No. 12, Yogyakarta',
            ],

            // Data Siswa Kelas 2
            [
                'nama_anggota' => 'Daffa Akbar Ramadhan',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2017-01-08',
                'anggota_sejak' => '2023-07-15',
                'tgl_registrasi' => '2023-07-15',
                'berlaku_hingga' => '2029-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Veteran No. 67, Yogyakarta',
            ],
            [
                'nama_anggota' => 'Nayla Zahra Azzahra',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2017-10-19',
                'anggota_sejak' => '2023-07-15',
                'tgl_registrasi' => '2023-07-15',
                'berlaku_hingga' => '2029-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Laksda Adisucipto KM 6, Sleman',
            ],

            // Data Siswa Kelas 1
            [
                'nama_anggota' => 'Rafka Abimanyu Putra',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2018-04-25',
                'anggota_sejak' => '2024-07-15',
                'tgl_registrasi' => '2024-07-15',
                'berlaku_hingga' => '2030-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Cik Di Tiro No. 88, Yogyakarta',
            ],
            [
                'nama_anggota' => 'Amira Khairunisa',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2018-08-14',
                'anggota_sejak' => '2024-07-15',
                'tgl_registrasi' => '2024-07-15',
                'berlaku_hingga' => '2030-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Kaliurang KM 10, Sleman',
            ],
            [
                'nama_anggota' => 'Fathan Naufal Ibrahim',
                'jenis_anggota' => 'siswa',
                'tgl_lahir' => '2018-11-30',
                'anggota_sejak' => '2024-07-15',
                'tgl_registrasi' => '2024-07-15',
                'berlaku_hingga' => '2030-06-30',
                'institusi' => 'SD MUHAMMADIYAH KARANGWARU',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Wates KM 5, Yogyakarta',
            ],
        ];

        foreach ($anggota as $data) {
            Anggota::create($data);
        }
    }
}
