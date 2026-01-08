<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_peminjaman')->constrained('peminjaman', 'id_peminjaman')->onDelete('cascade');
            $table->foreignId('id_eksemplar')->constrained('eksemplar', 'id_eksemplar')->onDelete('cascade');
            $table->date('tgl_kembali')->nullable();
            $table->enum('kondisi_kembali', ['baik', 'rusak', 'hilang'])->default('baik');
            $table->decimal('denda_item', 10, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('detail_peminjaman');
    }
};
