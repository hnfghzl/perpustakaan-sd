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
        Schema::table('buku', function (Blueprint $table) {
            $table->string('pengarang')->nullable()->after('judul');
            $table->string('penerbit')->nullable()->after('pengarang');
            $table->year('tahun_terbit')->nullable()->after('penerbit');
        });
    }

    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['pengarang', 'penerbit', 'tahun_terbit']);
        });
    }
};
