<?php

namespace App\Console;


use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\ArticleAuditorConsole;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     * @var array
     */
    protected $commands = [
        ArticleAuditorConsole::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command(ArticleAuditorConsole::class)->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     * @return voids
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }

}