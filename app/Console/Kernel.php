<?php

namespace App\Console;

use App\Console\Commands\CreatePersonalAccessToken;
use App\Console\Commands\CurrentPersonalAccessToken;
use App\Console\Commands\DeletePersonalAccessToken;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel
 * @package App\Console
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CreatePersonalAccessToken::class,
        CurrentPersonalAccessToken::class,
        DeletePersonalAccessToken::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }
}
