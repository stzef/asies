<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;

use asies\Models\Planes;
use asies\Models\Tareas;
use asies\User;
use asies\Models\Personas;
use asies\Models\Evidencias;
use asies\Models\TiRelaciones;
use asies\Models\TiPlanes;
use asies\Models\TareasUsuarios;
use \View;

class APIController extends Controller
{
	public function __construct()
	{
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}
	public function planes()
	{
		$planes = Planes::getArbolPlanes(true);
		return response()->json($planes );
	}
	public function plan($cplan)
	{
		$plan = Planes::with('puntuacion')->with('tiplan')->where("cplan",$cplan)->first();
		if ( $plan ){
			$plan->subplanes = Planes::getSubplanes($plan->cplan,true);
		}else{
			return response()->json(array("obj"=>null),404);
		}
		return response()->json($plan );
	}
	public function tarea($ctarea)
	{
		$tarea = Tareas::where("ctarea",$ctarea)->first();
		if ( $tarea ){
			return response()->json($tarea);
		}else{
			return response()->json(array("obj"=>null),404);
		}
	}
	public function tareas()
	{

		$ctiplan_prod_min = 4;
		$productos = Planes::where("ctiplan",$ctiplan_prod_min)->get();
		foreach ($productos as $producto) {
			$producto->tareas = Tareas::where("cplan",$producto->cplan)->get();
		}
		return response()->json($productos->toArray());
	}
	public function tirelaciones()
	{
		$tirelaciones = TiRelaciones::all();
		return response()->json($tirelaciones);
	}
	public function tiplanes()
	{
		$tiplanes = TiPlanes::all();
		return response()->json($tiplanes);
	}
	public function usuarios()
	{
		$usuarios = User::all();
		return response()->json($usuarios);
	}
	public function update_evidencia(Request $request,$cevidencia){
		$dataBody = $request->all();
		foreach ($dataBody as $data) {
			Evidencias::where("cevidencia",$cevidencia)->update([$data["0"]=>$data["1"]]);
		}
		return response()->json(array("message"=>"ok"));
	}
	public function usuarios_plan($ctarea)
	{
		$usuarios = TareasUsuarios::where('ctarea', $ctarea)->get();
		return response()->json($usuarios);
	}
}
