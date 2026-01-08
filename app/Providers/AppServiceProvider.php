<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load email configuration from database
        try {
            if (Schema::hasTable('pengaturan')) {
                $emailSettings = DB::table('pengaturan')
                    ->whereIn('key', [
                        'email_host',
                        'email_port',
                        'email_encryption',
                        'email_username',
                        'email_password',
                        'email_from_address',
                        'email_from_name'
                    ])
                    ->pluck('value', 'key');

                if ($emailSettings->count() > 0) {
                    Config::set('mail.mailers.smtp.host', $emailSettings['email_host'] ?? env('MAIL_HOST'));
                    Config::set('mail.mailers.smtp.port', $emailSettings['email_port'] ?? env('MAIL_PORT'));
                    Config::set('mail.mailers.smtp.encryption', $emailSettings['email_encryption'] ?? env('MAIL_ENCRYPTION'));
                    Config::set('mail.mailers.smtp.username', $emailSettings['email_username'] ?? env('MAIL_USERNAME'));
                    Config::set('mail.mailers.smtp.password', $emailSettings['email_password'] ?? env('MAIL_PASSWORD'));
                    Config::set('mail.from.address', $emailSettings['email_from_address'] ?? env('MAIL_FROM_ADDRESS'));
                    Config::set('mail.from.name', $emailSettings['email_from_name'] ?? env('MAIL_FROM_NAME'));
                }
            }
        } catch (\Exception $e) {
            // Jika tabel belum ada atau ada error, gunakan config default dari .env
        }
    }
}
