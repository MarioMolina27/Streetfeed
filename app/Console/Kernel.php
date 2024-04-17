<?php

namespace App\Console;

use App\Models\Launch_Pack;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('app:reset-markers')->dailyAt('16:20')->timezone('Europe/Madrid');
        $schedule->command('app:reset-markers')->dailyAt('18:00')->timezone('Europe/Madrid');
        $schedule->command('app:reset-markers')->dailyAt('00:00')->timezone('Europe/Madrid');
        $schedule->command('app:reset-launchpacks')->daily()->timezone('Europe/Madrid');
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
