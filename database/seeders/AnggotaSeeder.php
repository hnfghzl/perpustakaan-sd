<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        $institusi      = 'SD Muhammadiyah Karangwaru';
        $tglRegistrasi  = '2024-07-15';
        $anggotaSejak   = '2024-07-15';
        $berlakuHingga  = '2026-06-30';
        $now            = now();

        // Password = tanggal lahir format d-m-Y tanpa nol di depan, misal: 5032018
        $pwd = fn(string $tgl): string => Carbon::parse($tgl)->format('dmY');

        // ═══════════════════════════════════════════════════════════════
        // GURU — 50 orang (NIS field digunakan untuk menyimpan NIP)
        // ═══════════════════════════════════════════════════════════════
        $guru = [
            // ── Kepala Sekolah & Senior ──
            ['nis'=>'196804172000031001','nama'=>'Drs. H. Supriyadi, M.Pd.', 'jk'=>'laki-laki',  'tgl_lahir'=>'1968-04-17','email'=>'supriyadi@sdmuhkarangwaru.sch.id',        'no_hp'=>'628521000001','alamat'=>'Jl. Kyai Mojo No. 14, Karangwaru, Tegalrejo, Yogyakarta'],
            ['nis'=>'197209232003022001','nama'=>'Sri Wahyuni, S.Pd., M.Pd.',  'jk'=>'perempuan', 'tgl_lahir'=>'1972-09-23','email'=>'sri.wahyuni@sdmuhkarangwaru.sch.id',       'no_hp'=>'628521000002','alamat'=>'Jl. AM Sangaji No. 7, Jetis, Yogyakarta'],
            ['nis'=>'197506122005011003','nama'=>'Bambang Sutrisno, S.Pd.',    'jk'=>'laki-laki',  'tgl_lahir'=>'1975-06-12','email'=>'bambang.sutrisno@sdmuhkarangwaru.sch.id', 'no_hp'=>'628521000003','alamat'=>'Jl. Diponegoro No. 33, Jetis, Yogyakarta'],
            ['nis'=>'197802282006022010','nama'=>'Endang Purwanti, S.Pd.SD.',  'jk'=>'perempuan', 'tgl_lahir'=>'1978-02-28','email'=>'endang.purwanti@sdmuhkarangwaru.sch.id',  'no_hp'=>'628521000004','alamat'=>'Jl. Magelang No. 45, Tegalrejo, Yogyakarta'],
            ['nis'=>'198011152006031005','nama'=>'Haryanto, S.Pd.',            'jk'=>'laki-laki',  'tgl_lahir'=>'1980-11-15','email'=>'haryanto@sdmuhkarangwaru.sch.id',         'no_hp'=>'628521000005','alamat'=>'Jl. Tentara Pelajar No. 12, Tegalrejo, Yogyakarta'],
            // ── Guru Kelas ──
            ['nis'=>'198205072007022015','nama'=>'Retno Wulandari, S.Pd.SD.',  'jk'=>'perempuan', 'tgl_lahir'=>'1982-05-07','email'=>'retno.wulandari@sdmuhkarangwaru.sch.id',  'no_hp'=>'628521000006','alamat'=>'Jl. HOS Cokroaminoto No. 88, Tegalrejo, Yogyakarta'],
            ['nis'=>'198308202008011012','nama'=>'Agus Prasetyo, S.Pd.',       'jk'=>'laki-laki',  'tgl_lahir'=>'1983-08-20','email'=>'agus.prasetyo@sdmuhkarangwaru.sch.id',    'no_hp'=>'628521000007','alamat'=>'Jl. Kricak No. 21, Kricak, Tegalrejo, Yogyakarta'],
            ['nis'=>'198503142009022008','nama'=>'Sari Dewi Lestari, S.Pd.',   'jk'=>'perempuan', 'tgl_lahir'=>'1985-03-14','email'=>'sari.lestari@sdmuhkarangwaru.sch.id',      'no_hp'=>'628521000008','alamat'=>'Jl. Pingit No. 9, Bumijo, Jetis, Yogyakarta'],
            ['nis'=>'197712032004031002','nama'=>'Tri Wahyono, S.Pd.',         'jk'=>'laki-laki',  'tgl_lahir'=>'1977-12-03','email'=>'tri.wahyono@sdmuhkarangwaru.sch.id',      'no_hp'=>'628521000009','alamat'=>'Jl. Letjen Suprapto No. 56, Gowongan, Jetis, Yogyakarta'],
            ['nis'=>'197907192005022007','nama'=>'Umi Kulsum, S.Pd.SD.',       'jk'=>'perempuan', 'tgl_lahir'=>'1979-07-19','email'=>'umi.kulsum@sdmuhkarangwaru.sch.id',        'no_hp'=>'628521000010','alamat'=>'Jl. Bener No. 17, Bener, Tegalrejo, Yogyakarta'],
            ['nis'=>'198410252010011011','nama'=>'Eko Budi Santoso, S.Pd.',    'jk'=>'laki-laki',  'tgl_lahir'=>'1984-10-25','email'=>'eko.santoso@sdmuhkarangwaru.sch.id',      'no_hp'=>'628521000011','alamat'=>'Jl. Banteng No. 38, Badran, Jetis, Yogyakarta'],
            ['nis'=>'198601112011022009','nama'=>'Nining Suryani, S.Pd.SD.',   'jk'=>'perempuan', 'tgl_lahir'=>'1986-01-11','email'=>'nining.suryani@sdmuhkarangwaru.sch.id',   'no_hp'=>'628521000012','alamat'=>'Perum Bumi Tegalrejo No. 5, Tegalrejo, Yogyakarta'],
            ['nis'=>'198806302012022014','nama'=>'Dwi Rahmawati, S.Pd.',       'jk'=>'perempuan', 'tgl_lahir'=>'1988-06-30','email'=>'dwi.rahmawati@sdmuhkarangwaru.sch.id',    'no_hp'=>'628521000013','alamat'=>'Jl. Godean No. 77, Gamping, Sleman'],
            ['nis'=>'198104082007031006','nama'=>'Yusuf Hidayat, S.Pd.I.',     'jk'=>'laki-laki',  'tgl_lahir'=>'1981-04-08','email'=>'yusuf.hidayat@sdmuhkarangwaru.sch.id',    'no_hp'=>'628521000014','alamat'=>'Jl. Wates No. 44, Kasihan, Bantul'],
            ['nis'=>'198309222009022011','nama'=>'Siti Aminah, S.Pd.I.',       'jk'=>'perempuan', 'tgl_lahir'=>'1983-09-22','email'=>'siti.aminah@sdmuhkarangwaru.sch.id',       'no_hp'=>'628521000015','alamat'=>'Jl. Monjali No. 22, Mlati, Sleman'],
            ['nis'=>'197603052003031004','nama'=>'Budi Purwoko, S.Pd.',        'jk'=>'laki-laki',  'tgl_lahir'=>'1976-03-05','email'=>'budi.purwoko@sdmuhkarangwaru.sch.id',     'no_hp'=>'628521000016','alamat'=>'Jl. Palagan Tentara Pelajar No. 88, Mlati, Sleman'],
            ['nis'=>'199007182013022020','nama'=>'Rini Handayani, S.Pd.',      'jk'=>'perempuan', 'tgl_lahir'=>'1990-07-18','email'=>'rini.handayani@sdmuhkarangwaru.sch.id',   'no_hp'=>'628521000017','alamat'=>'Jl. Kaliurang No. 65, Ngaglik, Sleman'],
            ['nis'=>'198711272012011008','nama'=>'Sigit Purnomo, S.Pd.',       'jk'=>'laki-laki',  'tgl_lahir'=>'1987-11-27','email'=>'sigit.purnomo@sdmuhkarangwaru.sch.id',    'no_hp'=>'628521000018','alamat'=>'Jl. Seturan No. 30, Depok, Sleman'],
            ['nis'=>'198904132012022016','nama'=>'Wahyu Ningsih, S.Pd.SD.',    'jk'=>'perempuan', 'tgl_lahir'=>'1989-04-13','email'=>'wahyu.ningsih@sdmuhkarangwaru.sch.id',    'no_hp'=>'628521000019','alamat'=>'Jl. Nogopuro No. 11, Catur Tunggal, Depok, Sleman'],
            ['nis'=>'199102092014011013','nama'=>'Fajar Setiawan, S.Pd.',      'jk'=>'laki-laki',  'tgl_lahir'=>'1991-02-09','email'=>'fajar.setiawan@sdmuhkarangwaru.sch.id',   'no_hp'=>'628521000020','alamat'=>'Jl. Imogiri Barat No. 55, Kasihan, Bantul'],
            ['nis'=>'198808162013022021','nama'=>'Nuning Rahayu, S.Pd.',       'jk'=>'perempuan', 'tgl_lahir'=>'1988-08-16','email'=>'nuning.rahayu@sdmuhkarangwaru.sch.id',    'no_hp'=>'628521000021','alamat'=>'Jl. Kyai Mojo No. 37, Karangwaru, Tegalrejo, Yogyakarta'],
            ['nis'=>'197412012001031001','nama'=>'Hartono, S.Pd.',             'jk'=>'laki-laki',  'tgl_lahir'=>'1974-12-01','email'=>'hartono@sdmuhkarangwaru.sch.id',          'no_hp'=>'628521000022','alamat'=>'Jl. AM Sangaji No. 60, Jetis, Yogyakarta'],
            ['nis'=>'198005242006022013','nama'=>'Sumarni, S.Pd.SD.',          'jk'=>'perempuan', 'tgl_lahir'=>'1980-05-24','email'=>'sumarni@sdmuhkarangwaru.sch.id',           'no_hp'=>'628521000023','alamat'=>'Jl. Diponegoro No. 19, Jetis, Yogyakarta'],
            ['nis'=>'199301072016011001','nama'=>'Aan Kurniawan, S.Pd.',       'jk'=>'laki-laki',  'tgl_lahir'=>'1993-01-07','email'=>'aan.kurniawan@sdmuhkarangwaru.sch.id',    'no_hp'=>'628521000024','alamat'=>'Jl. Magelang No. 102, Tegalrejo, Yogyakarta'],
            ['nis'=>'199406152017022001','nama'=>'Destri Permata Sari, S.Pd.', 'jk'=>'perempuan', 'tgl_lahir'=>'1994-06-15','email'=>'destri.sari@sdmuhkarangwaru.sch.id',      'no_hp'=>'628521000025','alamat'=>'Jl. Tentara Pelajar No. 44, Tegalrejo, Yogyakarta'],
            ['nis'=>'199209032015011002','nama'=>'Rizal Fauzan, S.Pd.',        'jk'=>'laki-laki',  'tgl_lahir'=>'1992-09-03','email'=>'rizal.fauzan@sdmuhkarangwaru.sch.id',     'no_hp'=>'628521000026','alamat'=>'Jl. HOS Cokroaminoto No. 71, Tegalrejo, Yogyakarta'],
            ['nis'=>'198602192010022012','nama'=>'Ambar Wati, S.Pd.SD.',       'jk'=>'perempuan', 'tgl_lahir'=>'1986-02-19','email'=>'ambar.wati@sdmuhkarangwaru.sch.id',        'no_hp'=>'628521000027','alamat'=>'Jl. Kricak No. 8, Kricak, Tegalrejo, Yogyakarta'],
            ['nis'=>'198507282010011010','nama'=>'Gunawan Saputra, S.Pd.',     'jk'=>'laki-laki',  'tgl_lahir'=>'1985-07-28','email'=>'gunawan.saputra@sdmuhkarangwaru.sch.id',  'no_hp'=>'628521000028','alamat'=>'Jl. Pingit No. 24, Bumijo, Jetis, Yogyakarta'],
            ['nis'=>'199111062014022018','nama'=>'Lilis Suryani, S.Pd.',       'jk'=>'perempuan', 'tgl_lahir'=>'1991-11-06','email'=>'lilis.suryani@sdmuhkarangwaru.sch.id',    'no_hp'=>'628521000029','alamat'=>'Jl. Letjen Suprapto No. 40, Gowongan, Jetis, Yogyakarta'],
            ['nis'=>'199004222013011007','nama'=>'Prasetya Aji, S.Pd.',        'jk'=>'laki-laki',  'tgl_lahir'=>'1990-04-22','email'=>'prasetya.aji@sdmuhkarangwaru.sch.id',     'no_hp'=>'628521000030','alamat'=>'Jl. Bener No. 33, Bener, Tegalrejo, Yogyakarta'],
            // ── Guru Mata Pelajaran & Staf ──
            ['nis'=>'198708102012022017','nama'=>'Yuni Astuti, S.Pd.',         'jk'=>'perempuan', 'tgl_lahir'=>'1987-08-10','email'=>'yuni.astuti@sdmuhkarangwaru.sch.id',      'no_hp'=>'628521000031','alamat'=>'Jl. Banteng No. 15, Badran, Jetis, Yogyakarta'],
            ['nis'=>'198403172009031004','nama'=>'Muhammad Ridwan, S.Pd.I.',   'jk'=>'laki-laki',  'tgl_lahir'=>'1984-03-17','email'=>'m.ridwan@sdmuhkarangwaru.sch.id',         'no_hp'=>'628521000032','alamat'=>'Perum Bumi Tegalrejo No. 18, Tegalrejo, Yogyakarta'],
            ['nis'=>'197810292006031009','nama'=>'Slamet Riyadi, S.Pd.',       'jk'=>'laki-laki',  'tgl_lahir'=>'1978-10-29','email'=>'slamet.riyadi@sdmuhkarangwaru.sch.id',    'no_hp'=>'628521000033','alamat'=>'Jl. Godean No. 13, Gamping, Sleman'],
            ['nis'=>'198206042008022013','nama'=>'Kartini, S.Pd.SD.',          'jk'=>'perempuan', 'tgl_lahir'=>'1982-06-04','email'=>'kartini@sdmuhkarangwaru.sch.id',           'no_hp'=>'628521000034','alamat'=>'Jl. Wates No. 88, Kasihan, Bantul'],
            ['nis'=>'199502142018011001','nama'=>'Andika Permana, S.Pd.',      'jk'=>'laki-laki',  'tgl_lahir'=>'1995-02-14','email'=>'andika.permana@sdmuhkarangwaru.sch.id',   'no_hp'=>'628521000035','alamat'=>'Jl. Monjali No. 55, Mlati, Sleman'],
            ['nis'=>'199608312019022001','nama'=>'Fitria Nur Azizah, S.Pd.',   'jk'=>'perempuan', 'tgl_lahir'=>'1996-08-31','email'=>'fitria.azizah@sdmuhkarangwaru.sch.id',    'no_hp'=>'628521000036','alamat'=>'Jl. Palagan Tentara Pelajar No. 30, Mlati, Sleman'],
            ['nis'=>'197901202005031008','nama'=>'Joko Susanto, S.Pd.',        'jk'=>'laki-laki',  'tgl_lahir'=>'1979-01-20','email'=>'joko.susanto@sdmuhkarangwaru.sch.id',     'no_hp'=>'628521000037','alamat'=>'Jl. Kaliurang No. 122, Ngaglik, Sleman'],
            ['nis'=>'198305082009022010','nama'=>'Wiwik Sulistyowati, S.Pd.',  'jk'=>'perempuan', 'tgl_lahir'=>'1983-05-08','email'=>'wiwik.sulistyowati@sdmuhkarangwaru.sch.id','no_hp'=>'628521000038','alamat'=>'Jl. Seturan No. 7, Depok, Sleman'],
            ['nis'=>'198809142013011006','nama'=>'Deny Kurniawan, S.T.',       'jk'=>'laki-laki',  'tgl_lahir'=>'1988-09-14','email'=>'deny.kurniawan@sdmuhkarangwaru.sch.id',   'no_hp'=>'628521000039','alamat'=>'Jl. Nogopuro No. 42, Catur Tunggal, Depok, Sleman'],
            ['nis'=>'199703252020022001','nama'=>'Suci Ramadhani, S.Pd.',      'jk'=>'perempuan', 'tgl_lahir'=>'1997-03-25','email'=>'suci.ramadhani@sdmuhkarangwaru.sch.id',   'no_hp'=>'628521000040','alamat'=>'Jl. Imogiri Barat No. 23, Kasihan, Bantul'],
            ['nis'=>'198612112011011007','nama'=>'Hendra Wijaya, S.Pd.',       'jk'=>'laki-laki',  'tgl_lahir'=>'1986-12-11','email'=>'hendra.wijaya@sdmuhkarangwaru.sch.id',    'no_hp'=>'628521000041','alamat'=>'Jl. Kyai Mojo No. 62, Karangwaru, Tegalrejo, Yogyakarta'],
            ['nis'=>'199307042016022002','nama'=>'Nova Rahmawati, S.Pd.',      'jk'=>'perempuan', 'tgl_lahir'=>'1993-07-04','email'=>'nova.rahmawati@sdmuhkarangwaru.sch.id',   'no_hp'=>'628521000042','alamat'=>'Jl. AM Sangaji No. 29, Jetis, Yogyakarta'],
            ['nis'=>'199105162014011014','nama'=>'Arif Budiman, S.Pd.',        'jk'=>'laki-laki',  'tgl_lahir'=>'1991-05-16','email'=>'arif.budiman@sdmuhkarangwaru.sch.id',     'no_hp'=>'628521000043','alamat'=>'Jl. Diponegoro No. 74, Jetis, Yogyakarta'],
            ['nis'=>'199410082017022002','nama'=>'Indah Puspitasari, S.Pd.',   'jk'=>'perempuan', 'tgl_lahir'=>'1994-10-08','email'=>'indah.puspitasari@sdmuhkarangwaru.sch.id','no_hp'=>'628521000044','alamat'=>'Jl. Magelang No. 56, Tegalrejo, Yogyakarta'],
            ['nis'=>'198208232008031011','nama'=>'Rohmat Setiawan, S.Pd.I.',   'jk'=>'laki-laki',  'tgl_lahir'=>'1982-08-23','email'=>'rohmat.setiawan@sdmuhkarangwaru.sch.id',  'no_hp'=>'628521000045','alamat'=>'Jl. Tentara Pelajar No. 67, Tegalrejo, Yogyakarta'],
            ['nis'=>'198904012012022015','nama'=>'Rina Kusumawati, S.Pd.',     'jk'=>'perempuan', 'tgl_lahir'=>'1989-04-01','email'=>'rina.kusumawati@sdmuhkarangwaru.sch.id',  'no_hp'=>'628521000046','alamat'=>'Jl. HOS Cokroaminoto No. 34, Tegalrejo, Yogyakarta'],
            ['nis'=>'197711172004031003','nama'=>'Dedi Santoso, S.Pd.',        'jk'=>'laki-laki',  'tgl_lahir'=>'1977-11-17','email'=>'dedi.santoso@sdmuhkarangwaru.sch.id',     'no_hp'=>'628521000047','alamat'=>'Jl. Kricak No. 45, Kricak, Tegalrejo, Yogyakarta'],
            ['nis'=>'198502062010022011','nama'=>'Marlina, S.Pd.SD.',          'jk'=>'perempuan', 'tgl_lahir'=>'1985-02-06','email'=>'marlina@sdmuhkarangwaru.sch.id',           'no_hp'=>'628521000048','alamat'=>'Jl. Pingit No. 3, Bumijo, Jetis, Yogyakarta'],
            ['nis'=>'198007132006031007','nama'=>'Choirul Anwar, S.Pd.I.',     'jk'=>'laki-laki',  'tgl_lahir'=>'1980-07-13','email'=>'choirul.anwar@sdmuhkarangwaru.sch.id',    'no_hp'=>'628521000049','alamat'=>'Jl. Letjen Suprapto No. 11, Gowongan, Jetis, Yogyakarta'],
            ['nis'=>'199201282015022003','nama'=>'Yayuk Tri Astuti, S.Pd.',    'jk'=>'perempuan', 'tgl_lahir'=>'1992-01-28','email'=>'yayuk.astuti@sdmuhkarangwaru.sch.id',     'no_hp'=>'628521000050','alamat'=>'Jl. Bener No. 50, Bener, Tegalrejo, Yogyakarta'],
        ];

        // ═══════════════════════════════════════════════════════════════
        // SISWA — 200 orang
        // NIS format: TAHUN_MASUK(4) + KELAS(2) + ROMBEL(2) + URUT(2)
        // Kelas 1 masuk 2024, Kelas 2 masuk 2023, dst.
        // Rombel: A=01, B=02, C=03
        // ═══════════════════════════════════════════════════════════════

        // Pool alamat sekitar Karangwaru, Yogyakarta
        $alamatPool = [
            'Jl. Kyai Mojo No. %d, Karangwaru, Tegalrejo, Yogyakarta',
            'Jl. Magelang No. %d, Tegalrejo, Yogyakarta',
            'Jl. Kricak No. %d, Kricak, Tegalrejo, Yogyakarta',
            'Jl. Tentara Pelajar No. %d, Tegalrejo, Yogyakarta',
            'Jl. HOS Cokroaminoto No. %d, Tegalrejo, Yogyakarta',
            'Jl. AM Sangaji No. %d, Jetis, Yogyakarta',
            'Jl. Diponegoro No. %d, Jetis, Yogyakarta',
            'Jl. Banteng No. %d, Badran, Jetis, Yogyakarta',
            'Jl. Pingit No. %d, Bumijo, Jetis, Yogyakarta',
            'Jl. Letjen Suprapto No. %d, Gowongan, Jetis, Yogyakarta',
            'Jl. Bener No. %d, Bener, Tegalrejo, Yogyakarta',
            'Perum Bumi Tegalrejo Blok %s No. %d, Tegalrejo, Yogyakarta',
            'Jl. Godean No. %d, Gamping, Sleman',
            'Jl. Monjali No. %d, Mlati, Sleman',
            'Jl. Palagan Tentara Pelajar No. %d, Mlati, Sleman',
            'Jl. Kaliurang No. %d, Ngaglik, Sleman',
            'Jl. Wates No. %d, Kasihan, Bantul',
            'Jl. Imogiri Barat No. %d, Kasihan, Bantul',
            'Jl. Nogopuro No. %d, Catur Tunggal, Depok, Sleman',
            'Jl. Seturan No. %d, Depok, Sleman',
        ];

        $blok  = ['A','B','C','D','E'];
        $nomor = 1;
        $getAlamat = function () use (&$nomor, $alamatPool, $blok): string {
            $tpl = $alamatPool[($nomor - 1) % count($alamatPool)];
            $hasil = str_contains($tpl, 'Blok')
                ? sprintf($tpl, $blok[($nomor - 1) % count($blok)], ($nomor % 20) + 1)
                : sprintf($tpl, ($nomor * 3) % 98 + 2);
            $nomor++;
            return $hasil;
        };

        $siswa = [
            // ═══ KELAS 1 — lahir 2017–2018, masuk 2024 ═══
            // 1A (12 siswa)
            ['nis'=>'2024010101','nama'=>'Arya Putra Pratama',      'jk'=>'laki-laki', 'tgl_lahir'=>'2018-03-05','email'=>null],
            ['nis'=>'2024010102','nama'=>'Nayla Azzahra Putri',     'jk'=>'perempuan','tgl_lahir'=>'2018-05-22','email'=>null],
            ['nis'=>'2024010103','nama'=>'Daffa Rizky Nugroho',     'jk'=>'laki-laki', 'tgl_lahir'=>'2017-12-14','email'=>null],
            ['nis'=>'2024010104','nama'=>'Salwa Nuraini',           'jk'=>'perempuan','tgl_lahir'=>'2018-08-09','email'=>null],
            ['nis'=>'2024010105','nama'=>'Farhan Akbar',            'jk'=>'laki-laki', 'tgl_lahir'=>'2018-01-30','email'=>null],
            ['nis'=>'2024010106','nama'=>'Keisha Amalia',           'jk'=>'perempuan','tgl_lahir'=>'2017-11-03','email'=>null],
            ['nis'=>'2024010107','nama'=>'Raka Firmansyah',         'jk'=>'laki-laki', 'tgl_lahir'=>'2018-04-17','email'=>null],
            ['nis'=>'2024010108','nama'=>'Tiara Cahyani',           'jk'=>'perempuan','tgl_lahir'=>'2018-07-25','email'=>null],
            ['nis'=>'2024010109','nama'=>'Ibnu Agung Prayogo',      'jk'=>'laki-laki', 'tgl_lahir'=>'2018-02-14','email'=>null],
            ['nis'=>'2024010110','nama'=>'Hana Salsabila',          'jk'=>'perempuan','tgl_lahir'=>'2018-06-03','email'=>null],
            ['nis'=>'2024010111','nama'=>'Fadhlan Adi Saputra',     'jk'=>'laki-laki', 'tgl_lahir'=>'2017-10-08','email'=>null],
            ['nis'=>'2024010112','nama'=>'Anisa Rahmawati',         'jk'=>'perempuan','tgl_lahir'=>'2017-09-19','email'=>null],
            // 1B (11 siswa)
            ['nis'=>'2024010201','nama'=>'Bagas Adi Permana',       'jk'=>'laki-laki', 'tgl_lahir'=>'2018-03-22','email'=>null],
            ['nis'=>'2024010202','nama'=>'Cantika Putri Dewi',      'jk'=>'perempuan','tgl_lahir'=>'2018-01-11','email'=>null],
            ['nis'=>'2024010203','nama'=>'Erlangga Putra Wijaya',   'jk'=>'laki-laki', 'tgl_lahir'=>'2017-11-28','email'=>null],
            ['nis'=>'2024010204','nama'=>'Fatimah Nur Azizah',      'jk'=>'perempuan','tgl_lahir'=>'2018-05-06','email'=>null],
            ['nis'=>'2024010205','nama'=>'Galang Satria',           'jk'=>'laki-laki', 'tgl_lahir'=>'2018-08-14','email'=>null],
            ['nis'=>'2024010206','nama'=>'Hani Maharani',           'jk'=>'perempuan','tgl_lahir'=>'2017-12-20','email'=>null],
            ['nis'=>'2024010207','nama'=>'Ilham Maulana',           'jk'=>'laki-laki', 'tgl_lahir'=>'2018-04-09','email'=>null],
            ['nis'=>'2024010208','nama'=>'Jasmine Putri Lestari',   'jk'=>'perempuan','tgl_lahir'=>'2018-07-03','email'=>null],
            ['nis'=>'2024010209','nama'=>'Kevin Aria Santosa',      'jk'=>'laki-laki', 'tgl_lahir'=>'2017-10-17','email'=>null],
            ['nis'=>'2024010210','nama'=>'Laila Nur Hidayah',       'jk'=>'perempuan','tgl_lahir'=>'2018-02-28','email'=>null],
            ['nis'=>'2024010211','nama'=>'Mahesa Aji Putra',        'jk'=>'laki-laki', 'tgl_lahir'=>'2018-06-15','email'=>null],
            // 1C (11 siswa)
            ['nis'=>'2024010301','nama'=>'Naufal Rizky Saputra',    'jk'=>'laki-laki', 'tgl_lahir'=>'2018-01-07','email'=>null],
            ['nis'=>'2024010302','nama'=>'Olive Sari Wulandari',    'jk'=>'perempuan','tgl_lahir'=>'2018-04-23','email'=>null],
            ['nis'=>'2024010303','nama'=>'Pandu Aditya Kusuma',     'jk'=>'laki-laki', 'tgl_lahir'=>'2017-11-12','email'=>null],
            ['nis'=>'2024010304','nama'=>'Qoriah Hasanah',          'jk'=>'perempuan','tgl_lahir'=>'2018-08-30','email'=>null],
            ['nis'=>'2024010305','nama'=>'Radit Putra Wibawa',      'jk'=>'laki-laki', 'tgl_lahir'=>'2018-02-18','email'=>null],
            ['nis'=>'2024010306','nama'=>'Shinta Dewi Laksana',     'jk'=>'perempuan','tgl_lahir'=>'2017-12-05','email'=>null],
            ['nis'=>'2024010307','nama'=>'Tegar Wibowo',            'jk'=>'laki-laki', 'tgl_lahir'=>'2018-05-27','email'=>null],
            ['nis'=>'2024010308','nama'=>'Uma Kirana Putri',        'jk'=>'perempuan','tgl_lahir'=>'2018-03-11','email'=>null],
            ['nis'=>'2024010309','nama'=>'Vino Aji Santosa',        'jk'=>'laki-laki', 'tgl_lahir'=>'2017-10-25','email'=>null],
            ['nis'=>'2024010310','nama'=>'Wina Rahmawati',          'jk'=>'perempuan','tgl_lahir'=>'2018-07-16','email'=>null],
            ['nis'=>'2024010311','nama'=>'Yusuf Al Farabi',         'jk'=>'laki-laki', 'tgl_lahir'=>'2018-09-02','email'=>null],

            // ═══ KELAS 2 — lahir 2016–2017, masuk 2023 ═══
            // 2A (11 siswa)
            ['nis'=>'2023020101','nama'=>'Zayd Ikhwan Maulana',     'jk'=>'laki-laki', 'tgl_lahir'=>'2017-04-18','email'=>null],
            ['nis'=>'2023020102','nama'=>'Hana Putri Salsabila',    'jk'=>'perempuan','tgl_lahir'=>'2017-06-27','email'=>null],
            ['nis'=>'2023020103','nama'=>'Rafi Aditya Prayogo',     'jk'=>'laki-laki', 'tgl_lahir'=>'2016-09-11','email'=>null],
            ['nis'=>'2023020104','nama'=>'Aulia Rahma Saputri',     'jk'=>'perempuan','tgl_lahir'=>'2017-02-08','email'=>null],
            ['nis'=>'2023020105','nama'=>'Hafiz Maulana Ibrahim',   'jk'=>'laki-laki', 'tgl_lahir'=>'2017-07-23','email'=>null],
            ['nis'=>'2023020106','nama'=>'Putri Maharani Dewi',     'jk'=>'perempuan','tgl_lahir'=>'2016-12-01','email'=>null],
            ['nis'=>'2023020107','nama'=>'Andi Wibowo Santoso',     'jk'=>'laki-laki', 'tgl_lahir'=>'2017-05-14','email'=>null],
            ['nis'=>'2023020108','nama'=>'Bella Kusuma Dewi',       'jk'=>'perempuan','tgl_lahir'=>'2016-10-30','email'=>null],
            ['nis'=>'2023020109','nama'=>'Cahaya Ramadhan',         'jk'=>'laki-laki', 'tgl_lahir'=>'2017-03-08','email'=>null],
            ['nis'=>'2023020110','nama'=>'Dini Putri Rahayu',       'jk'=>'perempuan','tgl_lahir'=>'2017-08-21','email'=>null],
            ['nis'=>'2023020111','nama'=>'Erlangga Wijaya',         'jk'=>'laki-laki', 'tgl_lahir'=>'2016-11-15','email'=>null],
            // 2B (11 siswa)
            ['nis'=>'2023020201','nama'=>'Fathia Nur Rahmah',       'jk'=>'perempuan','tgl_lahir'=>'2017-01-24','email'=>null],
            ['nis'=>'2023020202','nama'=>'Galih Prasetyo',          'jk'=>'laki-laki', 'tgl_lahir'=>'2016-08-07','email'=>null],
            ['nis'=>'2023020203','nama'=>'Hikmah Auliyana',         'jk'=>'perempuan','tgl_lahir'=>'2017-05-31','email'=>null],
            ['nis'=>'2023020204','nama'=>'Irfan Maulana Akbar',     'jk'=>'laki-laki', 'tgl_lahir'=>'2017-03-16','email'=>null],
            ['nis'=>'2023020205','nama'=>'Jihan Ayu Lestari',       'jk'=>'perempuan','tgl_lahir'=>'2016-10-04','email'=>null],
            ['nis'=>'2023020206','nama'=>'Kharis Adi Nugroho',      'jk'=>'laki-laki', 'tgl_lahir'=>'2017-07-09','email'=>null],
            ['nis'=>'2023020207','nama'=>'Luna Cahya Ningrum',      'jk'=>'perempuan','tgl_lahir'=>'2016-12-22','email'=>null],
            ['nis'=>'2023020208','nama'=>'Mirza Fikri Ramadhan',    'jk'=>'laki-laki', 'tgl_lahir'=>'2017-04-05','email'=>null],
            ['nis'=>'2023020209','nama'=>'Nisa Auliawati',          'jk'=>'perempuan','tgl_lahir'=>'2017-02-17','email'=>null],
            ['nis'=>'2023020210','nama'=>'Okta Bagus Santoso',      'jk'=>'laki-laki', 'tgl_lahir'=>'2016-09-28','email'=>null],
            ['nis'=>'2023020211','nama'=>'Pita Ramadhani',          'jk'=>'perempuan','tgl_lahir'=>'2017-06-13','email'=>null],
            // 2C (11 siswa)
            ['nis'=>'2023020301','nama'=>'Qori Bagas Firmansyah',   'jk'=>'laki-laki', 'tgl_lahir'=>'2017-01-02','email'=>null],
            ['nis'=>'2023020302','nama'=>'Reva Putri Ariani',       'jk'=>'perempuan','tgl_lahir'=>'2016-08-19','email'=>null],
            ['nis'=>'2023020303','nama'=>'Satria Aji Wibowo',       'jk'=>'laki-laki', 'tgl_lahir'=>'2017-05-06','email'=>null],
            ['nis'=>'2023020304','nama'=>'Tasya Nur Aini',          'jk'=>'perempuan','tgl_lahir'=>'2016-11-24','email'=>null],
            ['nis'=>'2023020305','nama'=>'Ufara Putra Jaya',        'jk'=>'laki-laki', 'tgl_lahir'=>'2017-03-30','email'=>null],
            ['nis'=>'2023020306','nama'=>'Viona Kirana',            'jk'=>'perempuan','tgl_lahir'=>'2016-07-16','email'=>null],
            ['nis'=>'2023020307','nama'=>'Wahyu Prasetya',          'jk'=>'laki-laki', 'tgl_lahir'=>'2017-09-11','email'=>null],
            ['nis'=>'2023020308','nama'=>'Xena Putri Halimah',      'jk'=>'perempuan','tgl_lahir'=>'2017-02-27','email'=>null],
            ['nis'=>'2023020309','nama'=>'Yandra Putra Kusuma',     'jk'=>'laki-laki', 'tgl_lahir'=>'2016-10-13','email'=>null],
            ['nis'=>'2023020310','nama'=>'Zariya Anggraini',        'jk'=>'perempuan','tgl_lahir'=>'2017-06-28','email'=>null],
            ['nis'=>'2023020311','nama'=>'Afrizal Haikal',          'jk'=>'laki-laki', 'tgl_lahir'=>'2016-12-09','email'=>null],

            // ═══ KELAS 3 — lahir 2015–2016, masuk 2022 ═══
            // 3A (11 siswa)
            ['nis'=>'2022030101','nama'=>'Bintang Cahya Putra',     'jk'=>'laki-laki', 'tgl_lahir'=>'2016-03-17','email'=>null],
            ['nis'=>'2022030102','nama'=>'Zahra Fauziyyah',         'jk'=>'perempuan','tgl_lahir'=>'2015-10-25','email'=>null],
            ['nis'=>'2022030103','nama'=>'Yoga Dwi Permana',        'jk'=>'laki-laki', 'tgl_lahir'=>'2016-01-06','email'=>null],
            ['nis'=>'2022030104','nama'=>'Nabila Putri Utami',      'jk'=>'perempuan','tgl_lahir'=>'2015-08-14','email'=>null],
            ['nis'=>'2022030105','nama'=>'Ilham Raditya Saputra',   'jk'=>'laki-laki', 'tgl_lahir'=>'2015-11-20','email'=>null],
            ['nis'=>'2022030106','nama'=>'Adinda Nur Fatimah',      'jk'=>'perempuan','tgl_lahir'=>'2016-05-13','email'=>null],
            ['nis'=>'2022030107','nama'=>'Bagas Wahyu Nugroho',     'jk'=>'laki-laki', 'tgl_lahir'=>'2016-02-08','email'=>null],
            ['nis'=>'2022030108','nama'=>'Citra Ayu Pratiwi',       'jk'=>'perempuan','tgl_lahir'=>'2015-09-22','email'=>null],
            ['nis'=>'2022030109','nama'=>'Dendi Kurniawan',         'jk'=>'laki-laki', 'tgl_lahir'=>'2016-04-30','email'=>null],
            ['nis'=>'2022030110','nama'=>'Eva Nur Khalida',         'jk'=>'perempuan','tgl_lahir'=>'2015-12-07','email'=>null],
            ['nis'=>'2022030111','nama'=>'Fahri Rizky Maulana',     'jk'=>'laki-laki', 'tgl_lahir'=>'2016-07-18','email'=>null],
            // 3B (11 siswa)
            ['nis'=>'2022030201','nama'=>'Gita Permata Sari',       'jk'=>'perempuan','tgl_lahir'=>'2016-01-24','email'=>null],
            ['nis'=>'2022030202','nama'=>'Hendra Saputra',          'jk'=>'laki-laki', 'tgl_lahir'=>'2015-08-30','email'=>null],
            ['nis'=>'2022030203','nama'=>'Indri Wulandari',         'jk'=>'perempuan','tgl_lahir'=>'2016-05-15','email'=>null],
            ['nis'=>'2022030204','nama'=>'Jafar Sidiq',             'jk'=>'laki-laki', 'tgl_lahir'=>'2015-11-08','email'=>null],
            ['nis'=>'2022030205','nama'=>'Khairina Aziza',          'jk'=>'perempuan','tgl_lahir'=>'2016-02-26','email'=>null],
            ['nis'=>'2022030206','nama'=>'Lukman Hakim Santoso',    'jk'=>'laki-laki', 'tgl_lahir'=>'2015-07-13','email'=>null],
            ['nis'=>'2022030207','nama'=>'Mia Kusuma Wardani',      'jk'=>'perempuan','tgl_lahir'=>'2016-04-01','email'=>null],
            ['nis'=>'2022030208','nama'=>'Naufal Izzul Haq',        'jk'=>'laki-laki', 'tgl_lahir'=>'2015-09-18','email'=>null],
            ['nis'=>'2022030209','nama'=>'Orlin Putri Handayani',   'jk'=>'perempuan','tgl_lahir'=>'2015-12-24','email'=>null],
            ['nis'=>'2022030210','nama'=>'Pandu Saka Wijaya',       'jk'=>'laki-laki', 'tgl_lahir'=>'2016-03-10','email'=>null],
            ['nis'=>'2022030211','nama'=>'Qisthi Nabila',           'jk'=>'perempuan','tgl_lahir'=>'2015-10-06','email'=>null],
            // 3C (11 siswa)
            ['nis'=>'2022030301','nama'=>'Rangga Aditya Pratama',   'jk'=>'laki-laki', 'tgl_lahir'=>'2015-07-22','email'=>null],
            ['nis'=>'2022030302','nama'=>'Sherly Ramadhani',        'jk'=>'perempuan','tgl_lahir'=>'2016-01-08','email'=>null],
            ['nis'=>'2022030303','nama'=>'Taufik Hidayatullah',     'jk'=>'laki-laki', 'tgl_lahir'=>'2015-09-03','email'=>null],
            ['nis'=>'2022030304','nama'=>'Umi Kalsum',              'jk'=>'perempuan','tgl_lahir'=>'2016-05-28','email'=>null],
            ['nis'=>'2022030305','nama'=>'Vito Putra Perdana',      'jk'=>'laki-laki', 'tgl_lahir'=>'2015-11-14','email'=>null],
            ['nis'=>'2022030306','nama'=>'Wening Putri',            'jk'=>'perempuan','tgl_lahir'=>'2016-02-20','email'=>null],
            ['nis'=>'2022030307','nama'=>'Xander Wahyu Saputra',    'jk'=>'laki-laki', 'tgl_lahir'=>'2015-08-06','email'=>null],
            ['nis'=>'2022030308','nama'=>'Yuanita Sari',            'jk'=>'perempuan','tgl_lahir'=>'2015-12-16','email'=>null],
            ['nis'=>'2022030309','nama'=>'Zulfikar Aqila',          'jk'=>'laki-laki', 'tgl_lahir'=>'2016-04-24','email'=>null],
            ['nis'=>'2022030310','nama'=>'Amelia Putri Sabrina',    'jk'=>'perempuan','tgl_lahir'=>'2015-07-09','email'=>null],
            ['nis'=>'2022030311','nama'=>'Bima Arjuna',             'jk'=>'laki-laki', 'tgl_lahir'=>'2016-06-02','email'=>null],

            // ═══ KELAS 4 — lahir 2014–2015, masuk 2021 ═══
            // 4A (11 siswa)
            ['nis'=>'2021040101','nama'=>'Raka Ananda Putra',       'jk'=>'laki-laki', 'tgl_lahir'=>'2014-07-08','email'=>'raka.ananda@gmail.com'],
            ['nis'=>'2021040102','nama'=>'Farah Dwi Lestari',       'jk'=>'perempuan','tgl_lahir'=>'2014-04-02','email'=>'farah.lestari@gmail.com'],
            ['nis'=>'2021040103','nama'=>'Zaky Maulidan Arifin',    'jk'=>'laki-laki', 'tgl_lahir'=>'2014-10-30','email'=>'zaky.arifin@gmail.com'],
            ['nis'=>'2021040104','nama'=>'Alya Nadia Rahmawati',    'jk'=>'perempuan','tgl_lahir'=>'2013-12-19','email'=>'alya.nadia@gmail.com'],
            ['nis'=>'2021040105','nama'=>'Candra Yudistira',        'jk'=>'laki-laki', 'tgl_lahir'=>'2014-03-15','email'=>'candra.yudistira@gmail.com'],
            ['nis'=>'2021040106','nama'=>'Della Anggraini',         'jk'=>'perempuan','tgl_lahir'=>'2014-08-27','email'=>'della.anggraini@gmail.com'],
            ['nis'=>'2021040107','nama'=>'Eka Prasetyo Aji',        'jk'=>'laki-laki', 'tgl_lahir'=>'2014-01-11','email'=>'eka.prasetyo@gmail.com'],
            ['nis'=>'2021040108','nama'=>'Fadhila Aulia Sari',      'jk'=>'perempuan','tgl_lahir'=>'2013-11-23','email'=>'fadhila.aulia@gmail.com'],
            ['nis'=>'2021040109','nama'=>'Gilang Nugroho Santoso',  'jk'=>'laki-laki', 'tgl_lahir'=>'2014-06-04','email'=>'gilang.nugroho@gmail.com'],
            ['nis'=>'2021040110','nama'=>'Hesti Pratiwi',           'jk'=>'perempuan','tgl_lahir'=>'2014-09-16','email'=>'hesti.pratiwi@gmail.com'],
            ['nis'=>'2021040111','nama'=>'Iqbal Ramadhan',          'jk'=>'laki-laki', 'tgl_lahir'=>'2013-12-30','email'=>'iqbal.ramadhan@gmail.com'],
            // 4B (11 siswa)
            ['nis'=>'2021040201','nama'=>'Jihan Maharani',          'jk'=>'perempuan','tgl_lahir'=>'2014-02-19','email'=>'jihan.maharani@gmail.com'],
            ['nis'=>'2021040202','nama'=>'Kevin Aditya Putra',      'jk'=>'laki-laki', 'tgl_lahir'=>'2014-07-31','email'=>'kevin.aditya@gmail.com'],
            ['nis'=>'2021040203','nama'=>'Layla Syafira',           'jk'=>'perempuan','tgl_lahir'=>'2014-04-14','email'=>'layla.syafira@gmail.com'],
            ['nis'=>'2021040204','nama'=>'Mirza Habibi',            'jk'=>'laki-laki', 'tgl_lahir'=>'2013-10-26','email'=>'mirza.habibi@gmail.com'],
            ['nis'=>'2021040205','nama'=>'Nisa Mutiara Putri',      'jk'=>'perempuan','tgl_lahir'=>'2014-08-08','email'=>'nisa.mutiara@gmail.com'],
            ['nis'=>'2021040206','nama'=>'Omar Aji Kusuma',         'jk'=>'laki-laki', 'tgl_lahir'=>'2014-03-22','email'=>'omar.aji@gmail.com'],
            ['nis'=>'2021040207','nama'=>'Pita Yulianda',           'jk'=>'perempuan','tgl_lahir'=>'2014-11-04','email'=>'pita.yulianda@gmail.com'],
            ['nis'=>'2021040208','nama'=>'Qori Fajrin',             'jk'=>'laki-laki', 'tgl_lahir'=>'2013-09-17','email'=>'qori.fajrin@gmail.com'],
            ['nis'=>'2021040209','nama'=>'Rani Ayu Safira',         'jk'=>'perempuan','tgl_lahir'=>'2014-01-29','email'=>'rani.safira@gmail.com'],
            ['nis'=>'2021040210','nama'=>'Safar Al Ghifari',        'jk'=>'laki-laki', 'tgl_lahir'=>'2014-06-10','email'=>'safar.ghifari@gmail.com'],
            ['nis'=>'2021040211','nama'=>'Tika Wulandari',          'jk'=>'perempuan','tgl_lahir'=>'2014-10-21','email'=>'tika.wulandari@gmail.com'],
            // 4C (11 siswa)
            ['nis'=>'2021040301','nama'=>'Umar Hakim',              'jk'=>'laki-laki', 'tgl_lahir'=>'2014-02-06','email'=>'umar.hakim@gmail.com'],
            ['nis'=>'2021040302','nama'=>'Vika Permata Sari',       'jk'=>'perempuan','tgl_lahir'=>'2014-07-18','email'=>'vika.permata@gmail.com'],
            ['nis'=>'2021040303','nama'=>'Wahyu Adi Laksana',       'jk'=>'laki-laki', 'tgl_lahir'=>'2013-11-30','email'=>'wahyu.adi@gmail.com'],
            ['nis'=>'2021040304','nama'=>'Xena Halimah',            'jk'=>'perempuan','tgl_lahir'=>'2014-04-12','email'=>'xena.halimah@gmail.com'],
            ['nis'=>'2021040305','nama'=>'Yuda Firmansyah',         'jk'=>'laki-laki', 'tgl_lahir'=>'2014-09-23','email'=>'yuda.firmansyah@gmail.com'],
            ['nis'=>'2021040306','nama'=>'Zahra Auliyana',          'jk'=>'perempuan','tgl_lahir'=>'2013-12-15','email'=>'zahra.auliyana@gmail.com'],
            ['nis'=>'2021040307','nama'=>'Agus Tri Mulyono',        'jk'=>'laki-laki', 'tgl_lahir'=>'2014-03-27','email'=>'agus.tri@gmail.com'],
            ['nis'=>'2021040308','nama'=>'Bella Intan Puspita',     'jk'=>'perempuan','tgl_lahir'=>'2014-08-09','email'=>'bella.intan@gmail.com'],
            ['nis'=>'2021040309','nama'=>'Cahya Budi Santoso',      'jk'=>'laki-laki', 'tgl_lahir'=>'2014-01-21','email'=>'cahya.budi@gmail.com'],
            ['nis'=>'2021040310','nama'=>'Dara Permata Sari',       'jk'=>'perempuan','tgl_lahir'=>'2013-10-04','email'=>'dara.permata@gmail.com'],
            ['nis'=>'2021040311','nama'=>'Elang Adi Wicaksono',     'jk'=>'laki-laki', 'tgl_lahir'=>'2014-06-16','email'=>'elang.adi@gmail.com'],

            // ═══ KELAS 5 — lahir 2013–2014, masuk 2020 ═══
            // 5A (12 siswa)
            ['nis'=>'2020050101','nama'=>'Azka Fathurrahman',       'jk'=>'laki-laki', 'tgl_lahir'=>'2013-03-11','email'=>'azka.fathur@gmail.com'],
            ['nis'=>'2020050102','nama'=>'Tiara Cahyani Putri',     'jk'=>'perempuan','tgl_lahir'=>'2013-07-29','email'=>'tiara.cahyani@gmail.com'],
            ['nis'=>'2020050103','nama'=>'Rehan Putra Wijaya',      'jk'=>'laki-laki', 'tgl_lahir'=>'2012-11-04','email'=>'rehan.wijaya@gmail.com'],
            ['nis'=>'2020050104','nama'=>'Nadia Sari Utami',        'jk'=>'perempuan','tgl_lahir'=>'2013-01-15','email'=>'nadia.sari@gmail.com'],
            ['nis'=>'2020050105','nama'=>'Ghifari Ilham Akbar',     'jk'=>'laki-laki', 'tgl_lahir'=>'2013-05-07','email'=>'ghifari.ilham@gmail.com'],
            ['nis'=>'2020050106','nama'=>'Salsabila Nur Azizah',    'jk'=>'perempuan','tgl_lahir'=>'2012-08-20','email'=>'salsabila.azizah@gmail.com'],
            ['nis'=>'2020050107','nama'=>'Dimas Hari Setiawan',     'jk'=>'laki-laki', 'tgl_lahir'=>'2013-02-26','email'=>'dimas.hari@gmail.com'],
            ['nis'=>'2020050108','nama'=>'Ema Novitasari',          'jk'=>'perempuan','tgl_lahir'=>'2013-06-14','email'=>'ema.novita@gmail.com'],
            ['nis'=>'2020050109','nama'=>'Farid Hidayatullah',      'jk'=>'laki-laki', 'tgl_lahir'=>'2012-10-01','email'=>'farid.hidayat@gmail.com'],
            ['nis'=>'2020050110','nama'=>'Gita Ayu Ramadhani',      'jk'=>'perempuan','tgl_lahir'=>'2013-04-18','email'=>'gita.ayu@gmail.com'],
            ['nis'=>'2020050111','nama'=>'Haikal Putra Nugraha',    'jk'=>'laki-laki', 'tgl_lahir'=>'2013-08-05','email'=>'haikal.putra@gmail.com'],
            ['nis'=>'2020050112','nama'=>'Inaya Putri Salsabila',   'jk'=>'perempuan','tgl_lahir'=>'2012-12-22','email'=>'inaya.putri@gmail.com'],
            // 5B (11 siswa)
            ['nis'=>'2020050201','nama'=>'Joko Tri Wahyudi',        'jk'=>'laki-laki', 'tgl_lahir'=>'2013-01-30','email'=>'joko.wahyudi@gmail.com'],
            ['nis'=>'2020050202','nama'=>'Kirana Maharani',         'jk'=>'perempuan','tgl_lahir'=>'2013-05-16','email'=>'kirana.maharani@gmail.com'],
            ['nis'=>'2020050203','nama'=>'Luthfi Adi Nugroho',      'jk'=>'laki-laki', 'tgl_lahir'=>'2012-09-02','email'=>'luthfi.adi@gmail.com'],
            ['nis'=>'2020050204','nama'=>'Maulida Ayu Rahayu',      'jk'=>'perempuan','tgl_lahir'=>'2013-03-19','email'=>'maulida.ayu@gmail.com'],
            ['nis'=>'2020050205','nama'=>'Nizar Maulana',           'jk'=>'laki-laki', 'tgl_lahir'=>'2012-11-27','email'=>'nizar.maulana@gmail.com'],
            ['nis'=>'2020050206','nama'=>'Olive Rahmawati',         'jk'=>'perempuan','tgl_lahir'=>'2013-07-04','email'=>'olive.rahmawati@gmail.com'],
            ['nis'=>'2020050207','nama'=>'Pandu Satria Wijaya',     'jk'=>'laki-laki', 'tgl_lahir'=>'2013-02-11','email'=>'pandu.satria@gmail.com'],
            ['nis'=>'2020050208','nama'=>'Qisthi Aulia Noor',       'jk'=>'perempuan','tgl_lahir'=>'2012-08-28','email'=>'qisthi.aulia@gmail.com'],
            ['nis'=>'2020050209','nama'=>'Rizky Aditya Nugraha',    'jk'=>'laki-laki', 'tgl_lahir'=>'2013-04-24','email'=>'rizky.aditya@gmail.com'],
            ['nis'=>'2020050210','nama'=>'Salma Dewi Rahayu',       'jk'=>'perempuan','tgl_lahir'=>'2013-09-10','email'=>'salma.dewi@gmail.com'],
            ['nis'=>'2020050211','nama'=>'Teguh Santoso',           'jk'=>'laki-laki', 'tgl_lahir'=>'2012-10-17','email'=>'teguh.santoso@gmail.com'],
            // 5C (11 siswa)
            ['nis'=>'2020050301','nama'=>'Ulfa Meidina',            'jk'=>'perempuan','tgl_lahir'=>'2013-01-05','email'=>'ulfa.meidina@gmail.com'],
            ['nis'=>'2020050302','nama'=>'Vino Bagus Setiawan',     'jk'=>'laki-laki', 'tgl_lahir'=>'2012-09-21','email'=>'vino.bagus@gmail.com'],
            ['nis'=>'2020050303','nama'=>'Wida Putri Rahayu',       'jk'=>'perempuan','tgl_lahir'=>'2013-05-28','email'=>'wida.putri@gmail.com'],
            ['nis'=>'2020050304','nama'=>'Xander Satrya Nugroho',   'jk'=>'laki-laki', 'tgl_lahir'=>'2013-02-13','email'=>'xander.satrya@gmail.com'],
            ['nis'=>'2020050305','nama'=>'Yasmin Auliyana Putri',   'jk'=>'perempuan','tgl_lahir'=>'2012-10-30','email'=>'yasmin.auliyana@gmail.com'],
            ['nis'=>'2020050306','nama'=>'Zafira Kurniasih',        'jk'=>'perempuan','tgl_lahir'=>'2013-06-16','email'=>'zafira.kurniasih@gmail.com'],
            ['nis'=>'2020050307','nama'=>'Abid Maulana Ihsan',      'jk'=>'laki-laki', 'tgl_lahir'=>'2013-03-01','email'=>'abid.maulana@gmail.com'],
            ['nis'=>'2020050308','nama'=>'Bella Mega Putri',        'jk'=>'perempuan','tgl_lahir'=>'2012-11-18','email'=>'bella.mega@gmail.com'],
            ['nis'=>'2020050309','nama'=>'Candra Putra Aji',        'jk'=>'laki-laki', 'tgl_lahir'=>'2013-07-24','email'=>'candra.putra@gmail.com'],
            ['nis'=>'2020050310','nama'=>'Dira Puspa Sari',         'jk'=>'perempuan','tgl_lahir'=>'2013-01-28','email'=>'dira.puspa@gmail.com'],
            ['nis'=>'2020050311','nama'=>'Elsha Ramadhani',         'jk'=>'perempuan','tgl_lahir'=>'2012-09-05','email'=>'elsha.ramadhani@gmail.com'],

            // ═══ KELAS 6 — lahir 2011–2012, masuk 2019 ═══
            // 6A (11 siswa)
            ['nis'=>'2019060101','nama'=>'Akbar Ramadhan Hakim',    'jk'=>'laki-laki', 'tgl_lahir'=>'2012-06-10','email'=>'akbar.ramadhan@gmail.com'],
            ['nis'=>'2019060102','nama'=>'Intan Permata Sari',      'jk'=>'perempuan','tgl_lahir'=>'2012-04-03','email'=>'intan.permata@gmail.com'],
            ['nis'=>'2019060103','nama'=>'Farrel Naufal Habibie',   'jk'=>'laki-laki', 'tgl_lahir'=>'2012-09-28','email'=>'farrel.naufal@gmail.com'],
            ['nis'=>'2019060104','nama'=>'Anastasia Putri Ningrum', 'jk'=>'perempuan','tgl_lahir'=>'2011-12-31','email'=>'anastasia.ningrum@gmail.com'],
            ['nis'=>'2019060105','nama'=>'Bayu Adi Saputra',        'jk'=>'laki-laki', 'tgl_lahir'=>'2012-03-17','email'=>'bayu.adi@gmail.com'],
            ['nis'=>'2019060106','nama'=>'Cynthia Maharani',        'jk'=>'perempuan','tgl_lahir'=>'2012-07-25','email'=>'cynthia.maharani@gmail.com'],
            ['nis'=>'2019060107','nama'=>'Dika Putra Wibowo',       'jk'=>'laki-laki', 'tgl_lahir'=>'2011-11-08','email'=>'dika.putra@gmail.com'],
            ['nis'=>'2019060108','nama'=>'Eva Rahmawati',           'jk'=>'perempuan','tgl_lahir'=>'2012-02-20','email'=>'eva.rahmawati@gmail.com'],
            ['nis'=>'2019060109','nama'=>'Fadel Muhammad',          'jk'=>'laki-laki', 'tgl_lahir'=>'2012-05-14','email'=>'fadel.muhammad@gmail.com'],
            ['nis'=>'2019060110','nama'=>'Gina Nur Azizah',         'jk'=>'perempuan','tgl_lahir'=>'2012-08-31','email'=>'gina.nur@gmail.com'],
            ['nis'=>'2019060111','nama'=>'Habib Maulana Yusuf',     'jk'=>'laki-laki', 'tgl_lahir'=>'2011-10-22','email'=>'habib.maulana@gmail.com'],
            // 6B (11 siswa)
            ['nis'=>'2019060201','nama'=>'Rizal Haditama Putra',    'jk'=>'laki-laki', 'tgl_lahir'=>'2012-02-17','email'=>'rizal.haditama@gmail.com'],
            ['nis'=>'2019060202','nama'=>'Cantika Dewi Anggraini',  'jk'=>'perempuan','tgl_lahir'=>'2011-10-09','email'=>'cantika.dewi@gmail.com'],
            ['nis'=>'2019060203','nama'=>'M. Fakhri Ramadhan',      'jk'=>'laki-laki', 'tgl_lahir'=>'2012-07-05','email'=>'m.fakhri@gmail.com'],
            ['nis'=>'2019060204','nama'=>'Aisyah Nur Ramadhani',    'jk'=>'perempuan','tgl_lahir'=>'2011-05-24','email'=>'aisyah.ramadhani@gmail.com'],
            ['nis'=>'2019060205','nama'=>'Ilham Setiawan Putra',    'jk'=>'laki-laki', 'tgl_lahir'=>'2012-03-12','email'=>'ilham.setiawan@gmail.com'],
            ['nis'=>'2019060206','nama'=>'Juwita Rahmadani',        'jk'=>'perempuan','tgl_lahir'=>'2012-08-29','email'=>'juwita.rahmadani@gmail.com'],
            ['nis'=>'2019060207','nama'=>'Khairu Rijal',            'jk'=>'laki-laki', 'tgl_lahir'=>'2011-11-15','email'=>'khairu.rijal@gmail.com'],
            ['nis'=>'2019060208','nama'=>'Lana Dewi Saputri',       'jk'=>'perempuan','tgl_lahir'=>'2012-01-27','email'=>'lana.dewi@gmail.com'],
            ['nis'=>'2019060209','nama'=>'Muhamad Arif Nugroho',    'jk'=>'laki-laki', 'tgl_lahir'=>'2012-06-20','email'=>'m.arif.nugroho@gmail.com'],
            ['nis'=>'2019060210','nama'=>'Nanda Putri Rahayu',      'jk'=>'perempuan','tgl_lahir'=>'2011-09-04','email'=>'nanda.putri@gmail.com'],
            ['nis'=>'2019060211','nama'=>'Oscar Adi Nugraha',       'jk'=>'laki-laki', 'tgl_lahir'=>'2012-04-16','email'=>'oscar.adi@gmail.com'],
            // 6C (11 siswa)
            ['nis'=>'2019060301','nama'=>'Pipit Nur Rahmah',        'jk'=>'perempuan','tgl_lahir'=>'2012-01-11','email'=>'pipit.nur@gmail.com'],
            ['nis'=>'2019060302','nama'=>'Rafif Adi Nugraha',       'jk'=>'laki-laki', 'tgl_lahir'=>'2011-10-28','email'=>'rafif.adi@gmail.com'],
            ['nis'=>'2019060303','nama'=>'Suci Puji Lestari',       'jk'=>'perempuan','tgl_lahir'=>'2012-05-24','email'=>'suci.puji@gmail.com'],
            ['nis'=>'2019060304','nama'=>'Tegar Arif Wibowo',       'jk'=>'laki-laki', 'tgl_lahir'=>'2011-12-06','email'=>'tegar.arif@gmail.com'],
            ['nis'=>'2019060305','nama'=>'Umi Nur Hanifah',         'jk'=>'perempuan','tgl_lahir'=>'2012-03-19','email'=>'umi.hanifah@gmail.com'],
            ['nis'=>'2019060306','nama'=>'Valentino Putra Wijaya',  'jk'=>'laki-laki', 'tgl_lahir'=>'2012-08-01','email'=>'valentino.putra@gmail.com'],
            ['nis'=>'2019060307','nama'=>'Wulan Mustika Sari',      'jk'=>'perempuan','tgl_lahir'=>'2011-09-17','email'=>'wulan.mustika@gmail.com'],
            ['nis'=>'2019060308','nama'=>'Xanviar Aldi',            'jk'=>'laki-laki', 'tgl_lahir'=>'2012-02-04','email'=>'xanviar.aldi@gmail.com'],
            ['nis'=>'2019060309','nama'=>'Yolanda Apriani',         'jk'=>'perempuan','tgl_lahir'=>'2012-06-28','email'=>'yolanda.apriani@gmail.com'],
            ['nis'=>'2019060310','nama'=>'Zaenuri Akbar',           'jk'=>'laki-laki', 'tgl_lahir'=>'2011-11-10','email'=>'zaenuri.akbar@gmail.com'],
            ['nis'=>'2019060311','nama'=>'Adelia Safitri',          'jk'=>'perempuan','tgl_lahir'=>'2012-04-21','email'=>'adelia.safitri@gmail.com'],
        ];

        // ── Insert GURU ──
        $hpGuru = 628521000001;
        foreach ($guru as $g) {
            DB::table('anggota')->insertOrIgnore([
                'nis'            => $g['nis'],
                'nama_anggota'   => $g['nama'],
                'email'          => $g['email'],
                'no_hp'          => $g['no_hp'],
                'jenis_anggota'  => 'guru',
                'jenis_kelamin'  => $g['jk'],
                'tgl_lahir'      => $g['tgl_lahir'],
                'alamat'         => $g['alamat'],
                'institusi'      => $institusi,
                'anggota_sejak'  => $anggotaSejak,
                'tgl_registrasi' => $tglRegistrasi,
                'berlaku_hingga' => $berlakuHingga,
                'password'       => Hash::make($pwd($g['tgl_lahir'])),
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }

        // ── Insert SISWA ──
        $hpSiswa = 628813000001; // nomor WA orang tua
        foreach ($siswa as $s) {
            DB::table('anggota')->insertOrIgnore([
                'nis'            => $s['nis'],
                'nama_anggota'   => $s['nama'],
                'email'          => $s['email'],
                'no_hp'          => (string) $hpSiswa++,
                'jenis_anggota'  => 'siswa',
                'jenis_kelamin'  => $s['jk'],
                'tgl_lahir'      => $s['tgl_lahir'],
                'alamat'         => $getAlamat(),
                'institusi'      => $institusi,
                'anggota_sejak'  => $anggotaSejak,
                'tgl_registrasi' => $tglRegistrasi,
                'berlaku_hingga' => $berlakuHingga,
                'password'       => Hash::make($pwd($s['tgl_lahir'])),
                'created_at'     => $now,
                'updated_at'     => $now,
            ]);
        }
    }
}
