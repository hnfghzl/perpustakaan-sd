<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('eksemplar', function (Blueprint $table) {
            $table->id('id_eksemplar');
            $table->foreignId('id_buku')->constrained('buku', 'id_buku')->onDelete('cascade');
            $table->string('kode_eksemplar')->unique();
            $table->string('lokasi_rak')->nullable();
            $table->string('tipe_lokasi')->nullable();
            $table->enum('status_eksemplar', ['dipinjam', 'tersedia', 'hilang', 'rusak'])->default('tersedia');
            $table->decimal('harga', 10, 2)->nullable();
            $table->date('tgl_diterima')->nullable();
            $table->enum('sumber_perolehan', ['beli', 'hadiah'])->nullable();
            $table->string('faktur')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('eksemplar');
    }
};
