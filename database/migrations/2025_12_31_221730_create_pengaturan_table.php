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
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id('id_pengaturan');
            $table->string('key', 100)->unique()->comment('Kunci pengaturan');
            $table->string('value', 255)->comment('Nilai pengaturan');
            $table->string('label', 255)->comment('Label untuk UI');
            $table->string('tipe', 50)->default('text')->comment('text, number, date, select');
            $table->text('deskripsi')->nullable()->comment('Keterangan pengaturan');
            $table->timestamps();
        });

        // Insert default settings
        DB::table('pengaturan')->insert([
            [
                'key' => 'durasi_peminjaman_hari',
                'value' => '7',
                'label' => 'Durasi Peminjaman (Hari)',
                'tipe' => 'number',
                'deskripsi' => 'Jumlah hari maksimal peminjaman buku',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'denda_per_hari',
                'value' => '1000',
                'label' => 'Denda Keterlambatan per Hari',
                'tipe' => 'number',
                'deskripsi' => 'Denda per hari per buku (dalam Rupiah)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'denda_rusak',
                'value' => '50000',
                'label' => 'Denda Buku Rusak',
                'tipe' => 'number',
                'deskripsi' => 'Denda untuk buku yang dikembalikan dalam kondisi rusak (dalam Rupiah)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'denda_hilang',
                'value' => '100000',
                'label' => 'Denda Buku Hilang',
                'tipe' => 'number',
                'deskripsi' => 'Denda untuk buku yang hilang (dalam Rupiah)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'max_buku_per_peminjaman',
                'value' => '3',
                'label' => 'Maksimal Buku per Peminjaman',
                'tipe' => 'number',
                'deskripsi' => 'Jumlah maksimal buku yang bisa dipinjam dalam satu transaksi',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
