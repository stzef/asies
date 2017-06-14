<?php

namespace asies\Console\Commands;
use asies\Models\Tareas;

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
		//dump(\Config::get('database'));
		Tareas::on('mysql_demo')->where('ctarea',1)->update(["ntarea"=>"Hola"]);
	}
}
