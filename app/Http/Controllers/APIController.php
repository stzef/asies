<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;

use asies\Models\Planes;
use asies\Models\Tareas;
use asies\Models\Actividades;
use asies\User;
use asies\Models\Personas;
use asies\Models\Evidencias;
use asies\Models\TiRelaciones;
use asies\Models\TiPlanes;
use asies\Models\TareasUsuarios;
use asies\Models\AsignacionTareas;
use \View;

use Illuminate\Support\Facades\Validator;


class APIController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	/* API Planes */
	public function plan($cplan){
		$plan = Planes::with('puntuacion')->with('tiplan')->where("cplan",$cplan)->first();
		if ( $plan ){
			$plan->subplanes = Planes::getSubplanes($plan->cplan,true);
		}else{
			return response()->json(array("obj"=>null),404);
		}
		return response()->json($plan );
	}

	public function planes(){
		$planes = Planes::getArbolPlanes(true);
		return response()->json($planes );
	}
	/* API Planes */

	/* API Tareas */
	public function tarea($ctarea){
		$tarea = Tareas::where("ctarea",$ctarea)->first();
		if ( $tarea ){
			return response()->json($tarea);
		}else{
			return response()->json(array("obj"=>null),404);
		}
	}

	public function tareas(){
		$ctiplan_prod_min = 4;
		$productos = Planes::where("ctiplan",$ctiplan_prod_min)->get();
		foreach ($productos as $producto) {
			$producto->tareas = Tareas::where("cplan",$producto->cplan)->get();
		}
		return response()->json($productos->toArray());
	}
	/* API Tareas */

	/* API Tirelaciones */
	public function tirelaciones(){
		$tirelaciones = TiRelaciones::all();
		return response()->json($tirelaciones);
	}
	/* API Tirelaciones */

	/* API Tiplanes */
	public function tiplanes(){
		$tiplanes = TiPlanes::all();
		return response()->json($tiplanes);
	}
	/* API Tiplanes */

	/* API Usuarios */
	public function usuarios(){
		$usuarios = User::all();
		return response()->json($usuarios);
	}
	/* API Usuarios */

	/* API Actividades */

	public function realizar_tarea( $catividad, $ctarea ){
		$asignacion = AsignacionTareas::where("catividad",$catividad)->where("ctarea",$ctarea)->first();
		$response = array( "ok" => true );
		if ( $asignacion ){
			$ifhecha = ( $asignacion->ifhecha == "1" ) ? "0" : "1";
			$asignacion->ifhecha = $ifhecha;
			if ( $asignacion->save() ){
				$response["msg"] = "Se cambio el estado de la tarea.";
				if ( $asignacion->ifhecha == "1" ){ $response["msg"] .= " <br> Estado Actual <b>Realizada</b>"; }
				else{ $response["msg"] .= " <br> Estado Actual <b>No Realizada</b>"; }
			}else{
				$response["ok"] = false;
				$response["msg"] = "No se pudo cambiar el estado de la tarea.";
			}
		}else{
			$response["ok"] = false;
			$response["msg"] = "No se encontro la asignacion";
		}
		return response()->json($response);
	}

	public function actividades(){
		$actividades = Actividades::all();
		return response()->json($actividades->toArray());
	}
	public function property(Request $request,$model,$id){
		$response = array(
			"error" => False,
			"object" => array(),
		);

		$dataBody = $request->all();
		$validator = Validator::make($dataBody,
			[
				'property' => 'required',
			],
			[
				'property.required' => 'El valor "propiedad" es requerido',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors" => $messages),400);
		}else{
			$property = $request->get("property");
			$value = $request->get("value");
			if( $model == "User" ){
				$class = "asies\\$model";
			}else{
				$class = "asies\Models\\$model";
			}
			$keyName = \App::make($class)->getKeyName();

			$object = $class::where($keyName,$id)->first();

			if ( $object ){
				if ( $value != "" ){
					$object[$property] = $value;
					if( !$object->save() ){
						$response["message"] = "No se actualizo la propiedad";
						$response["error"] = True;
					}
				}else{
					$response["object"][$property] = $object[$property];
				}
			}else{
				$response["message"] = "No se encontro el objeto";
				$response["error"] = True;
			}

			/*
				$.ajax({
					url : "/api/User/1/property?property=name&value=Carlos",
					type : "POST",
					dataType : "json",
					success : function(response){
						console.log(response)
					}
				})
			*/

			return response()->json($response);
		}


	}
	/* API Actividades */

	public function update_evidencia(Request $request,$cevidencia){
		$dataBody = $request->all();
		foreach ($dataBody as $data) {
			Evidencias::where("cevidencia",$cevidencia)->update([$data["0"]=>$data["1"]]);
		}
		return response()->json(array("message"=>"ok"));
	}

	public function usuarios_plan($ctarea){
		$usuarios = TareasUsuarios::where('ctarea', $ctarea)->get();
		return response()->json($usuarios);
	}
}
