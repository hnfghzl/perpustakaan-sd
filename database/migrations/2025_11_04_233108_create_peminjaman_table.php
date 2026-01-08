<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id('id_peminjaman');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('id_anggota')->constrained('anggota', 'id_anggota')->onDelete('cascade');
            $table->date('tgl_pinjam');
            $table->date('tgl_jatuh_tempo');
            $table->decimal('denda_total', 10, 2)->default(0);
            $table->integer('jumlah_peminjaman')->default(1);
            $table->enum('status_buku', ['dipinjam', 'kembali', 'hilang', 'rusak'])->default('dipinjam');
            $table->string('kode_transaksi')->unique();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('peminjaman');
    }
};
