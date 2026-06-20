<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            // Jadikan id_user nullable agar peminjaman dari portal anggota bisa dibuat tanpa id_user
            $table->foreignId('id_user')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->foreignId('id_user')->nullable(false)->change();
        });
    }
};
