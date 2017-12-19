<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use asies\Models\Actividades; 
use asies\Models\AsignacionTareas; 
use asies\Http\Requests;

use View;

class AppController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function dashboard(){

		$user = \Auth::user();
		$asignaciones = $user->getAsignacion();
		$encuestas = $user->getEncuestas();

		$now = Carbon::now();
		$now->hour   = 0;
		$now->minute = 0;
		$now->second = 0;

		$actividades_proximas = AsignacionTareas::
			join("actividades","asignaciontareas.cactividad","=","actividades.cactividad")
			->select("actividades.*")
			->whereDate('actividades.fini', '=', $now )
			->where("user","=",$user->id)
			->groupBy("actividades.cactividad")
			->get();
		if ( count($actividades_proximas) == 0 ) {
			$tommorrow = $now->addDay();
			$actividades_proximas = AsignacionTareas::
				join("actividades","asignaciontareas.cactividad","=","actividades.cactividad")
				->select("actividades.*")
				->whereDate('actividades.fini', '=', $tommorrow )
				->where("user","=",$user->id)
				->groupBy("actividades.cactividad")
				->get();
		}
		return view('dashboard',[
			'actividades_proximas' => $actividades_proximas,
			'asignaciones' => $asignaciones,
			'encuestas' => $encuestas,
		]);
	}
	public function tutoriales(){
		return view('/tutoriales');
	}
}
