<?php

namespace App\Console;

use App\Console\Commands\ClearVoiceMessages;
use App\Console\Commands\CreateUser;
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
        CreateUser::class,
        ClearVoiceMessages::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(ClearVoiceMessages::class)->dailyAt('00:00');
        $schedule->command('queue:monitor database:default --max=100')->everyMinute();

        if (config('eventsdon.enableBackups')) {
            $schedule->command('backup:run')->dailyAt('01:00');
        }

        // delete the previous weeks's data
        $schedule->command('telescope:prune --hours=168')->monthly();
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
