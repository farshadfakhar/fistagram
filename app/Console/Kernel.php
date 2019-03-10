<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;
use App\Activity;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\InstagramCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $activity = new Activity();
            $activity->account_id = 1;
            $activity->activity = 'schedule';
            $activity->details = "schedule runed";
            $activity->state = 'succsess';
            $activity->save();

        })->everyFifteenMinutes();
        $schedule->command('instagram:login')->everyMinute();
    }
}
