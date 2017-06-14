<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use asies\Models\Evidencias;
use asies\Models\Actividades;
use View;

class EvidenciaController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}
	public function index($cactividad=null){
		if ( $cactividad ){
			$actividad = Actividades::where("cactividad",$cactividad)->first();
			$evidencias = $actividad->getEvidencias();
		}else{
			$evidencias = Evidencias::all();
			$actividad = null;
		}
		return view('evidencias/list',[
			"evidencias" => $evidencias,
			"actividad" => $actividad,
		]);
	}
}
