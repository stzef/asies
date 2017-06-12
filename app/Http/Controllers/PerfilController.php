<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;

use asies\Models\Tareas;
use asies\Models\Actividades;
use View;

use \Auth;

class PerfilController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function actividades(Request $request){
		$user = Auth::user();
		$tareas = $user->getTareas();
		$actividades = $user->getActividades();

		foreach ($actividades as $actividad) {
			$actividad->calcularDias();
			//$objactividad = Actividades::where("cactividad",$actividad->cactividad)->first();
			$actividad->tareas = $actividad->getTareas($user->id);
			//$actividad->n_eviencias = $actividad->getEvidencias(true);
		}

		return view('perfil/dashboard', array( "tareas" => $tareas, "actividades" => $actividades ) );
	}
}
