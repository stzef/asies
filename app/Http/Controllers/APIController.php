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

use asies\Models\ChecklistDeta;

use \View;
use Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class APIController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function testerror(){
		response()->json([],404);
	}
	public function testsuccess(){
		response()->json([],200);
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

	public function verificar_usuario( $cactividad, $ctarea, $iduser){
		$flag = false;
		if ( AsignacionTareas::where("user",$iduser)->where("cactividad",$cactividad)->where("ctarea",$ctarea)->exists() ){
			$flag = true;
		}
		return $flag;
	}

	/*
	public function users(Request $request,$cactividad,$ctarea){
		$actividad = Actividades::where('cactividad', $cactividad)->first();
		if ($request->isMethod("POST")){
			$user = Auth::user();
			Log::info('Asignacion usuario ,',['user' => $user->id ]);
			$dataBody = $request->all();
			$dataBody["tareasusuarios"]["ctarea"] = $ctarea;
			$dataBody["tareasusuarios"]["cactividad"] = $cactividad;

			$validator = Validator::make($dataBody["tareasusuarios"],
				[
					'ctarea' => 'required',
					'cactividad' => 'required',
					'user' => 'required|max:255',
					'ctirelacion' => 'required',
				],
				[
					'ctarea.required' => 'El nombre del plan es requerido',
					'cactividad.required' => 'El nombre del plan es requerido',
				]
			);

			if ($validator->fails()){
				$messages = $validator->messages();
				return response()->json(array("errors_form" => $messages),400);
			}else{

				$tarea = Tareas::where('ctarea', $ctarea)->first();
				$user = Auth::user();
				Log::info('Asignacion usuario a tarea ,',['user' => $user->id, 'tarea' => $tarea->ctarea]);
				$response = $actividad->add_task_user(
					array(
						"ctarea" => $dataBody["tareasusuarios"]["ctarea"],
						"user" => $dataBody["tareasusuarios"]["user"],
						"ctirelacion" => $dataBody["tareasusuarios"]["ctirelacion"]
					)
				);
				if ( $response["obj"] ) $response["obj"] = $response["obj"]->toArray();
				return response()->json($response);
			}
		}
	}
	*/

	public function answer_checklist( Request $request, $cchecklist ){

		$dataBody = $request->all();

		$response = [
			"message" => "Se contesto el Checklist",
			"answers" => [],
		];

		$dataBody["cchecklist"] = $cchecklist;

		$validator = Validator::make($dataBody,
			[
				'cchecklist' => 'required|numeric|exists:checklist,cchecklist',
				'answers.*.cpregunta' => 'numeric|exists:preguntas,cpregunta',
				'answers.*.cpregunta' => 'nullable|numeric|exists:opciones,copcion',
			]
		);

		foreach ($dataBody["answers"] as $answer) {


			$queryRespuesta = ChecklistDeta::where("cchecklist",$cchecklist)->where("cpregunta",$answer["cpregunta"]);

			$arr = [
				"cpregunta" => $answer["cpregunta"],
				"anotaciones" => $answer["anotaciones"]
			];

			$status = $arr;

			if ( $answer["isOpenQuestion"] )
				{ $arr["respuesta"] = $answer["respuesta"]; }
			else
				{ $arr["copcion"] = $answer["copcion"]; }

			if ( $queryRespuesta->first() ){
				$queryRespuesta->update($arr);
				$status["message"] = "La respuesta se edito.";
			}else{
				$arr["cchecklist"] = $dataBody["cchecklist"];
				ChecklistDeta::create($arr);
				$status["message"] = "La respuesta se creo.";
			}

			array_push($response["answers"], $status);
		}

		return response()->json($response);
	}

	public function remove_tarea_asignada( Request $request, $cactividad ){


		$dataBody = $request->all();
		$dataBody["cactividad"] = $cactividad;

		$validator = Validator::make($dataBody,
			[
				'ctarea' => 'required',
				'cactividad' => 'required',
			],
			[
				'ctarea.required' => 'El nombre del plan es requerido',
				'cactividad.required' => 'El nombre del plan es requerido',
			]
		);

		$actividad = Actividades::where('cactividad', $cactividad)->first();
		$user = Auth::user();

		if( AsignacionTareas::where( $dataBody )->exists() ){
			AsignacionTareas::where( $dataBody )->delete();
			Log::info('Asignacion Borrada,',['user (borro)' => $user->id, '' => $actividad->cactividad ,'tarea' => $dataBody['ctarea'] ]);
			$data = array("msg"=>"Se Borro la <b>Asignacion</b> del Usuario.");
		}else{
			$data = array("msg"=>"La Asignacion No Existe");
		}
		return response()->json($data);
	}

	public function asignar_tarea( Request $request, $cactividad ){
		$response = array();
		$dataBody = $request->all();

		$dataBody["cactividad"] = $cactividad;

		$validator = Validator::make($dataBody,
			[
				'ctarea' => 'required|exists:tareas,ctarea',
				'cactividad' => 'required|exists:actividades,cactividad',
				'user' => 'required|exists:users,id',
				'ctirelacion' => 'required|exists:tirelaciones,ctirelacion',
			],
			[
				'ctarea.required' => 'El valor "ctarea" es requerido',
				'cactividad.required' => 'El valor "cactividad" es requerido',
				'user.required' => 'El valor "user" es requerido',
				'ctirelacion.required' => 'El valor "ctirelacion" es requerido',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors" => $messages),400);
		}else{

			$actividad = Actividades::where("cactividad",$cactividad)->first();

			$asignacion = AsignacionTareas::where([ 'cactividad' => $actividad->cactividad, 'ctarea' => $dataBody["ctarea"] ] )->exists();
			if( $asignacion ){
				$asignacion = AsignacionTareas::where([ 'cactividad' => $actividad->cactividad, 'ctarea' => $dataBody["ctarea"] ] )->update($dataBody);
				$obj = AsignacionTareas::where( [ 'cactividad' => $actividad->cactividad, 'ctarea' => $dataBody["ctarea"] ] )->first();
				$data = array("msg"=>"Se edito la <b>asignacion</b> de la tarea.");
			}else{
				$dataBody["ifhecha"] = 0;
				$dataBody["valor_tarea"] = 1;

				$obj = AsignacionTareas::create($dataBody);
				$data = array("msg"=>"Se <b>asigno</b> exitosamente la tarea.");
			}
			$data["obj"] = $obj;



			return response()->json($data);
		}

	}
	public function realizar_tarea( $cactividad, $ctarea ){
		$asignaciones = AsignacionTareas::where("cactividad",$cactividad)->where("ctarea",$ctarea)->get();

		$actividad = Actividades::where("cactividad",$cactividad)->first();

		$response = array( "ok" => true );
		$user = Auth::user();
		if ( count($asignaciones) != 0 ){

			foreach ($asignaciones as $asignacion ) {
				// if ( $this->verificar_usuario($cactividad, $ctarea, $user->id) ){
				if ( true ){
					$ifhecha = ( $asignacion->ifhecha == "1" ) ? "0" : "1";
					$asignacion->ifhecha = $ifhecha;
					if ( $asignacion->save() ){
						$response["msg"] = "Se cambio el estado de la tarea.";
						if ( $asignacion->ifhecha == "1" ){ $response["msg"] .= " <br> Estado Actual <b>Realizada</b>"; }
						else{ $response["msg"] .= " <br> Estado Actual <b>No Realizada</b>"; }

						$actividad->updateState();

						$noactividad = Actividades::where("cactividad",$cactividad)->first();
						// dump($noactividad);exit();
						if ( $noactividad->ifhecha == "1" ) $response["msg"] .= "La Actividad se ha completado";
					}else{
						$response["ok"] = false;
						$response["msg"] = "No se pudo cambiar el estado de la tarea.";
					}
				}else{
					$response["ok"] = false;
					$response["msg"] = "La tarea no esta asignada al usuario.";
				}
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
