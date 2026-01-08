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
        Schema::table('peminjaman', function (Blueprint $table) {
            // Breakdown denda untuk audit trail
            $table->decimal('denda_keterlambatan', 10, 2)->default(0)->after('denda_total')
                  ->comment('Denda dari keterlambatan pengembalian (Rp/hari/buku)');
            $table->decimal('denda_kerusakan', 10, 2)->default(0)->after('denda_keterlambatan')
                  ->comment('Total denda dari kerusakan/kehilangan buku');
            
            // Status pembayaran denda
            $table->enum('status_pembayaran', ['belum_dibayar', 'sudah_dibayar'])->default('belum_dibayar')
                  ->after('denda_kerusakan')->comment('Status pembayaran denda');
            $table->date('tgl_pembayaran')->nullable()->after('status_pembayaran')
                  ->comment('Tanggal lunas pembayaran denda');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn([
                'denda_keterlambatan',
                'denda_kerusakan', 
                'status_pembayaran',
                'tgl_pembayaran'
            ]);
        });
    }
};
