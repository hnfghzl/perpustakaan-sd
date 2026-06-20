<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $keys = [
            'nama_sekolah',
            'alamat_sekolah',
            'telp_sekolah',
            'kota_sekolah',
            'nama_kepala_sekolah',
            'nip_kepala_sekolah',
            'logo_daerah',
            'logo_sekolah',
        ];

        $defaults = [
            [
                'key'        => 'nama_sekolah',
                'value'      => 'SD MUHAMMADIYAH KARANGWARU',
                'label'      => 'Nama Sekolah',
                'tipe'       => 'text',
                'deskripsi'  => 'Nama lengkap sekolah yang tampil di kartu anggota',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key'        => 'alamat_sekolah',
                'value'      => 'Jl. Karangwaru Lor No. 1, Yogyakarta',
                'label'      => 'Alamat Sekolah',
                'tipe'       => 'text',
                'deskripsi'  => 'Alamat sekolah yang tampil di kartu anggota',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key'        => 'telp_sekolah',
                'value'      => '(0274) 000000',
                'label'      => 'Telepon Sekolah',
                'tipe'       => 'text',
                'deskripsi'  => 'Nomor telepon sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key'        => 'kota_sekolah',
                'value'      => 'Yogyakarta',
                'label'      => 'Kota Sekolah',
                'tipe'       => 'text',
                'deskripsi'  => 'Nama kota untuk kop surat / kartu anggota',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key'        => 'nama_kepala_sekolah',
                'value'      => 'Kepala Sekolah',
                'label'      => 'Nama Kepala Sekolah',
                'tipe'       => 'text',
                'deskripsi'  => 'Nama kepala sekolah yang tampil di kartu anggota',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key'        => 'nip_kepala_sekolah',
                'value'      => '',
                'label'      => 'NIP Kepala Sekolah',
                'tipe'       => 'text',
                'deskripsi'  => 'NIP kepala sekolah (kosongkan jika tidak ada)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($defaults as $row) {
            // Hanya insert jika key belum ada
            if (! DB::table('pengaturan')->where('key', $row['key'])->exists()) {
                DB::table('pengaturan')->insert($row);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('pengaturan')->whereIn('key', [
            'nama_sekolah',
            'alamat_sekolah',
            'telp_sekolah',
            'kota_sekolah',
            'nama_kepala_sekolah',
            'nip_kepala_sekolah',
            'logo_daerah',
            'logo_sekolah',
        ])->delete();
    }
};
