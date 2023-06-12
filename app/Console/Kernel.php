<?php

namespace App\Console;

use App\Console\Commands\EarthquakeCorn;
use App\Console\Commands\FloodCorn;
use App\Console\Commands\WeatherCorn;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        FloodCorn::class,
        EarthquakeCorn::class,
        WeatherCorn::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('flood:corn')->everyFifteenMinutes()->runInBackground();
        $schedule->command('earthquake:corn')->everyMinute()->runInBackground();
        $schedule->command('weather:corn')->dailyAt('21:00')->runInBackground();
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
