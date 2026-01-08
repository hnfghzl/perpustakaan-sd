<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id('id_logaktivitas');
            $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
            $table->string('aktivitas');
            $table->timestamp('waktu')->useCurrent();
        });
    }
    public function down(): void {
        Schema::dropIfExists('log_aktivitas');
    }
};
