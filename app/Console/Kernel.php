<?php

namespace App\Console;

use App\Console\Commands\SendAssignmentMails;
use App\Console\Commands\UpdateBlogFeeds;
use App\Console\Commands\UpdateWeathers;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands
        = [
            SendAssignmentMails::class,
            UpdateBlogFeeds::class,
            UpdateWeathers::class,
        ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('custom:send_assignment_mails')->dailyAt('22:30');
        $schedule->command('custom:update_blog_feeds')->everyFiveMinutes();
        $schedule->command('custom:update_weathers')->twiceDaily(6, 9);
        $schedule->command('custom:update_weathers')->twiceDaily(12, 15);
        $schedule->command('custom:update_weathers')->twiceDaily(18, 21);
        $schedule->command('telescope:prune')->daily();
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
