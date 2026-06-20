<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah key belum ada, baru insert
        if (!DB::table('pengaturan')->where('key', 'fonnte_token')->exists()) {
            DB::table('pengaturan')->insert([
                'key'         => 'fonnte_token',
                'value'       => '',
                'label'       => 'Token Fonnte (WhatsApp)',
                'tipe'        => 'password',
                'deskripsi'   => 'Token API Fonnte untuk mengirim notifikasi WhatsApp. Dapatkan di fonnte.com > Devices > Token.',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('pengaturan')->where('key', 'fonnte_token')->delete();
    }
};
