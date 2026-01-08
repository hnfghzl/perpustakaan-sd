<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('anggota', function (Blueprint $table) {
            $table->id('id_anggota');
            $table->string('nama_anggota');
            $table->enum('jenis_anggota', ['guru', 'siswa']);
            $table->date('tgl_lahir')->nullable();
            $table->date('anggota_sejak')->nullable();
            $table->date('tgl_registrasi')->nullable();
            $table->date('berlaku_hingga')->nullable();
            $table->string('institusi')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan']);
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('anggota');
    }
};
