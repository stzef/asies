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
		'asies\Console\Commands\Scaffolding',
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
			//->everyMinute()
			->daily()
			->timezone('America/Bogota')
			->appendOutputTo($filePath);;
	}
}
