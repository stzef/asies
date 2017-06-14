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
		$filePath = base_path()."/public/log_emails.log";
		$schedule->command("ASIES_Tareas:verificarFechas")->everyMinute()->timezone('America/Bogota')->appendOutputTo($filePath);;
	}
}
