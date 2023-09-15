<?php

namespace Src\Common\Infrastructure\Laravel\Kernel;

use Illuminate\Console\Scheduling\Schedule;
use Src\Common\Presentation\CLI\CreateQueryCmd;
use Src\Common\Presentation\CLI\CreateDomainCmd;
use Src\Common\Presentation\CLI\CreateRoutesCmd;
use Src\Common\Presentation\CLI\CreateCommandCmd;
use Src\Common\Presentation\CLI\CreateControllerCmd;
use Src\Common\Presentation\CLI\CreateLaravelSetupCmd;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Console extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CreateDomainCmd::class,
        CreateCommandCmd::class,
        CreateQueryCmd::class,
        CreateControllerCmd::class,
        CreateRoutesCmd::class,
        CreateLaravelSetupCmd::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
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
