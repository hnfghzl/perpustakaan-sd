<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Ubah enum status_buku — tambah nilai 'menunggu' dan 'ditolak'
        //    MySQL tidak bisa ALTER COLUMN enum langsung kalau ada default,
        //    jadi kita ubah via raw SQL.
        DB::statement("
            ALTER TABLE peminjaman
            MODIFY COLUMN status_buku
                ENUM('menunggu','dipinjam','kembali','ditolak','hilang','rusak')
                NOT NULL DEFAULT 'dipinjam'
        ");

        Schema::table('peminjaman', function (Blueprint $table) {
            // 2. Kolom alasan_penolakan — diisi saat pustakawan menolak pengajuan
            $table->string('alasan_penolakan')->nullable()->after('status_buku');

            // 3. tgl_pinjam & tgl_jatuh_tempo menjadi nullable
            //    Saat anggota mengajukan (status 'menunggu'), tanggal belum ditetapkan.
            //    Tanggal baru diisi saat pustakawan menyetujui.
            $table->date('tgl_pinjam')->nullable()->change();
            $table->date('tgl_jatuh_tempo')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('alasan_penolakan');
            $table->date('tgl_pinjam')->nullable(false)->change();
            $table->date('tgl_jatuh_tempo')->nullable(false)->change();
        });

        // Kembalikan enum ke nilai asli
        DB::statement("
            ALTER TABLE peminjaman
            MODIFY COLUMN status_buku
                ENUM('dipinjam','kembali','hilang','rusak')
                NOT NULL DEFAULT 'dipinjam'
        ");
    }
};
