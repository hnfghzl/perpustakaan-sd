<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel: buku
        Schema::table('buku', function (Blueprint $table) {
            $table->index('kategori_id', 'idx_buku_kategori');
            $table->index('judul', 'idx_buku_judul');
            $table->index('no_panggil', 'idx_buku_no_panggil');
        });

        // Tabel: eksemplar
        Schema::table('eksemplar', function (Blueprint $table) {
            $table->index('id_buku', 'idx_eksemplar_buku');
            $table->index('status_eksemplar', 'idx_eksemplar_status');
            $table->index(['id_buku', 'status_eksemplar'], 'idx_eksemplar_buku_status');
        });

        // Tabel: peminjaman
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->index('id_user', 'idx_peminjaman_user');
            $table->index('id_anggota', 'idx_peminjaman_anggota');
            $table->index('status_buku', 'idx_peminjaman_status');
            $table->index('tgl_pinjam', 'idx_peminjaman_tgl_pinjam');
            $table->index('tgl_jatuh_tempo', 'idx_peminjaman_jatuh_tempo');
            $table->index('status_pembayaran', 'idx_peminjaman_pembayaran');
            // Composite indexes untuk query kompleks
            $table->index(['id_anggota', 'status_buku'], 'idx_peminjaman_anggota_status');
            $table->index(['status_buku', 'tgl_jatuh_tempo'], 'idx_peminjaman_status_tempo');
        });

        // Tabel: detail_peminjaman
        Schema::table('detail_peminjaman', function (Blueprint $table) {
            $table->index('id_peminjaman', 'idx_detail_peminjaman');
            $table->index('id_eksemplar', 'idx_detail_eksemplar');
            $table->index('kondisi_kembali', 'idx_detail_kondisi');
        });

        // Tabel: anggota
        Schema::table('anggota', function (Blueprint $table) {
            $table->index('nama_anggota', 'idx_anggota_nama');
            $table->index('jenis_anggota', 'idx_anggota_jenis');
            $table->index('email', 'idx_anggota_email');
        });

        // Tabel: log_aktivitas
        Schema::table('log_aktivitas', function (Blueprint $table) {
            $table->index('id_user', 'idx_log_user');
            $table->index('waktu', 'idx_log_waktu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tabel: buku
        Schema::table('buku', function (Blueprint $table) {
            $table->dropIndex('idx_buku_kategori');
            $table->dropIndex('idx_buku_judul');
            $table->dropIndex('idx_buku_no_panggil');
        });

        // Tabel: eksemplar
        Schema::table('eksemplar', function (Blueprint $table) {
            $table->dropIndex('idx_eksemplar_buku');
            $table->dropIndex('idx_eksemplar_status');
            $table->dropIndex('idx_eksemplar_buku_status');
        });

        // Tabel: peminjaman
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropIndex('idx_peminjaman_user');
            $table->dropIndex('idx_peminjaman_anggota');
            $table->dropIndex('idx_peminjaman_status');
            $table->dropIndex('idx_peminjaman_tgl_pinjam');
            $table->dropIndex('idx_peminjaman_jatuh_tempo');
            $table->dropIndex('idx_peminjaman_pembayaran');
            $table->dropIndex('idx_peminjaman_anggota_status');
            $table->dropIndex('idx_peminjaman_status_tempo');
        });

        // Tabel: detail_peminjaman
        Schema::table('detail_peminjaman', function (Blueprint $table) {
            $table->dropIndex('idx_detail_peminjaman');
            $table->dropIndex('idx_detail_eksemplar');
            $table->dropIndex('idx_detail_kondisi');
        });

        // Tabel: anggota
        Schema::table('anggota', function (Blueprint $table) {
            $table->dropIndex('idx_anggota_nama');
            $table->dropIndex('idx_anggota_jenis');
            $table->dropIndex('idx_anggota_email');
        });

        // Tabel: log_aktivitas
        Schema::table('log_aktivitas', function (Blueprint $table) {
            $table->dropIndex('idx_log_user');
            $table->dropIndex('idx_log_waktu');
        });
    }
};
