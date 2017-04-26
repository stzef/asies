<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;

use asies\Models\Tareas;
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

		return view('perfil.misplanes', array( "tareas" => $tareas, "actividades" => $actividades ) );

	}
}
