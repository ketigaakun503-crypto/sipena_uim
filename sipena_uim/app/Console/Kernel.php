<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        // Cek kontrak yang akan berakhir setiap hari jam 08.00
        $schedule->call(function () {
            app(\App\Services\KontrakKerjaService::class)->cekKontrakAkanBerakhir();
        })->dailyAt('08:00')->name('cek-kontrak-berakhir');
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}