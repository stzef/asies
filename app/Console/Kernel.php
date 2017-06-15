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
		$date = date("Ym");
		$filePath = base_path()."/public/schedule/logs/log_$date.log";
		$schedule
			->command("ASIES_Tareas:verificarFechas")
			->everyMinute()
			->timezone('America/Bogota')
			->appendOutputTo($filePath);;
	}
}
