<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled tasks
|--------------------------------------------------------------------------
| Requires ONE server cron entry: * * * * * php /path/artisan schedule:run
| (see docs/deployment-cloudpanel.md). Add project schedules below.
*/

// Housekeeping — prune old logs & read notifications, daily at 02:00.
Schedule::command('kit:cleanup')->dailyAt('02:00')->withoutOverlapping();

// Examples — uncomment & implement the commands for your project:
// Schedule::command('reminders:send')->everyThirtyMinutes();       // reminders
// Schedule::command('reports:daily')->dailyAt('06:00');            // report generation
// Schedule::command('queue:prune-failed --hours=168')->weekly();   // clean failed jobs
