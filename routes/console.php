<?php

use App\Console\Commands\SendWaReminder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Kirim WA reminder H-1 dan overdue H+ setiap hari jam 07.00 pagi
Schedule::command('wa:kirim-reminder')->dailyAt('07:00')->name('wa-reminder')->withoutOverlapping();
