<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert email configuration settings
        DB::table('pengaturan')->insert([
            [
                'key' => 'email_host',
                'value' => 'smtp.gmail.com',
                'label' => 'Email Host (SMTP)',
                'tipe' => 'text',
                'deskripsi' => 'SMTP server host untuk mengirim email (contoh: smtp.gmail.com)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'email_port',
                'value' => '465',
                'label' => 'Email Port',
                'tipe' => 'number',
                'deskripsi' => 'Port SMTP (465 untuk SSL, 587 untuk TLS)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'email_encryption',
                'value' => 'ssl',
                'label' => 'Email Encryption',
                'tipe' => 'select',
                'deskripsi' => 'Tipe enkripsi email (ssl atau tls)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'email_username',
                'value' => 'hanifhanati700@gmail.com',
                'label' => 'Email Username',
                'tipe' => 'email',
                'deskripsi' => 'Email address yang digunakan untuk login SMTP',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'email_password',
                'value' => 'opjxxgeeohgvvkge',
                'label' => 'Email Password / App Password',
                'tipe' => 'password',
                'deskripsi' => 'Password email atau App Password (untuk Gmail gunakan App Password)',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'email_from_address',
                'value' => 'hanifhanati700@gmail.com',
                'label' => 'Email Pengirim (From Address)',
                'tipe' => 'email',
                'deskripsi' => 'Email address yang ditampilkan sebagai pengirim',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'email_from_name',
                'value' => 'SD Muhammadiyah Karangwaru',
                'label' => 'Nama Pengirim (From Name)',
                'tipe' => 'text',
                'deskripsi' => 'Nama institusi yang ditampilkan sebagai pengirim email',
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
        DB::table('pengaturan')->whereIn('key', [
            'email_host',
            'email_port',
            'email_encryption',
            'email_username',
            'email_password',
            'email_from_address',
            'email_from_name'
        ])->delete();
    }
};
