<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        // * * * * * cd /www/wwwroot/daypush && /www/server/php/74/bin/php artisan schedule:run >> /dev/null 2>&1

        // * * * * * cd /你的项目路径 && php artisan schedule:run >> /dev/null 2>&1
        $schedule->command('good_morning')->dailyAt('09:00');
//        $schedule->command('good_morning')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
