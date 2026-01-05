<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Models\ScheduledCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $commands = ScheduledCommand::where('enabled', true)->get();

        foreach ($commands as $cmd) {
            $event = $schedule->command($cmd->command);
            if ($cmd->expression === 'daily' && $cmd->time) {
                $event->dailyAt($cmd->time);
            } elseif ($cmd->expression === 'hourly') {
                $event->hourly();
            } else {
                $event->cron($cmd->expression); // cho phép custom cron
            }
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
