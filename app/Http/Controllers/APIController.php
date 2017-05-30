<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;

use asies\Models\Planes;
use asies\User;
use asies\Models\Personas;
use asies\Models\Evidencias;
use asies\Models\TiRelaciones;
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
		$plan = Planes::with('tiplan')->where("cplan",$cplan)->first();
		$plan->subplanes = Planes::getSubplanes($plan->cplan,true);
		return response()->json($plan );
	}
	public function tirelaciones()
	{
		$tirelaciones = TiRelaciones::all();
		return response()->json($tirelaciones);
	}
	public function usuarios()
	{
		$usuarios = User::all();
		/*foreach ($usuarios as $usuario) {
			$persona = Personas::where('usuario', $usuario->id)->first();
			$usuario->persona = $persona;
		}*/
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
		/*foreach ($usuarios as $usuario) {
			$persona = Personas::where('usuario', $usuario->id)->first();
			$usuario->persona = $persona;
		}*/
		return response()->json($usuarios);
	}
}
