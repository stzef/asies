<?php

namespace asies\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use asies\Models\Tareas;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'asies\Console\Commands\ASIES',
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        dump("Hola 1");
        $filePath = base_path()."/public/log_emails.log";
        #$schedule->command("ASIES_Tareas:verificarFechas")->dailyAt('15:57')->timezone('America/Bogota');
        $schedule->command("ASIES_Tareas:verificarFechas")->everyMinute()->timezone('America/Bogota')->sendOutputTo($filePath);;
        /*$schedule->call(function () {
            Tareas::where('ctarea',1)->update(["ntarea"=>"Hola"]);
        })->dailyAt('14:48')
         ;*/
    }
}
