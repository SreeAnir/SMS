<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('send:student-notification')->dailyAt('6:00');
        $schedule->command('send:student-fee-reminder')->dailyAt('6:00');
        $schedule->call(function () {
            file_get_contents(route('attendance.update')); // Replace with your actual URL
        })->everyFourHours();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
