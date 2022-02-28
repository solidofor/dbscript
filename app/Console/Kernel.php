<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\available_amount_first_run',
        'App\Console\Commands\daily_available_amount',
    ];

    /**
     * Define the application's command schedule.
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('daily_available_amount')->dailyAt('01:00')->withoutOverlapping(30);
        $schedule->command('daily_available_amount')->dailyAt('02:00')->withoutOverlapping(30);
        $schedule->command('daily_available_amount')->dailyAt('03:00')->withoutOverlapping(30);
        $schedule->command('daily_available_amount')->dailyAt('04:00')->withoutOverlapping(30);
        $schedule->command('daily_available_amount')->dailyAt('05:00')->withoutOverlapping(30);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
