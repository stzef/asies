<?php

namespace asies\Console\Commands;
use asies\Models\Tareas;
use asies\Models\Actividades;
use asies\Models\Parametros;
use Carbon\Carbon;

use Illuminate\Console\Command;
use \DB;

class ASIES extends Command
{
	/**
	 * The name and signature of the console ASIES_Tareas.
	 *
	 * @var string
	 */
	protected $signature = 'ASIES_Tareas:verificarFechas';

	/**
	 * The console ASIES_Tareas description.
	 *
	 * @var string
	 */
	protected $description = 'ASIES_Tareas description';

	/**
	 * Create a new ASIES_Tareas instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console ASIES_Tareas.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$confdb = \Config::get('database');
		foreach ($confdb["connections"] as $key => $connection) {
			try {

				$ifsendreminders = Parametros::on($key)->where("cparam","REMINDERS__ENABLE_REMINDER_SENDING")->first()->val();
				//dump("ifsendreminders");
				//dump($ifsendreminders);
				if ( $ifsendreminders ){

					$ndias = Parametros::on($key)->where("cparam","REMINDERS__NUMBER_OF_DAYS_FOR_REMINDERS")->first()->val();

					$now = Carbon::now();
					$now->hour   = 0;
					$now->minute = 0;
					$now->second = 0;

					$actividades = Actividades::on($key)->whereDate('ffin', '>', $now->toDateString())->get();
					$actividades_filtradas = collect();
					foreach ($actividades as $actividad ) {
						$actividad->calcularDias();
						if ( $ndias ){
							if ( $actividad->dias_faltantas <= $ndias ){
								$actividades_filtradas->push($actividad);
							}
						}else{
							$actividades_filtradas->push($actividad);
						}
					}
					/*foreach ($actividades_filtradas as $actividad) {
						$status = Actividades::sendEmailsReminder($actividad);
						//dump($status);
					}*/
				}
			} catch ( \Exception $e){
				//dump("---------------------");
				//dump($e->getMessage());
				//dump("---------------------");
			}
		}
	}
}
