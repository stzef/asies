<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use View;
use \Auth;
use Illuminate\Support\Facades\Log;
use asies\Models\Actividades;
use asies\Models\Tareas;
use asies\Models\Planes;
use Illuminate\Support\Facades\Validator;

class TareasController extends Controller
{
	public function __construct()
	{
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function change_state(Request $request,$ctarea){

		$dataBody = $request->all();
		$validator = Validator::make($dataBody,
			[
				'ctarea' => 'required',
				'ifhecha' => 'required|boolean',
			],
			[
				'ctarea.required' => 'El nombre del plan es requerido',
				'ifhecha.required' => 'El nombre del plan es requerido',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors_form" => $messages),400);
		}else{

			$user = Auth::user();
			$tarea = Tareas::where('ctarea', $ctarea)->first();
			$estadant=$tarea->ifhecha;

			$response["ok"] = true;
			if ( $tarea->checkUser($user->id) ){
				Tareas::where('ctarea', $ctarea)->update(['ifhecha' => $dataBody["ifhecha"]]);//->first();
				if ( $tarea->ifhecha ){
					$response["message"] = "";
				}else{
					$response["message"] = "";
				}
			}else{
				$response["message"] = "Esta tarea no esta asignada al usuario";
				$response["ok"] = false;
			}
			$tarea = Tareas::where('ctarea', $ctarea)->first();
			$response["hecha"]=$tarea->ifhecha;
			Log::info('Cambio estado de tarea,',['tarea' => $tarea->ctarea, 'user' => $user->id, 'estado anterior' => $estadant, 'estado actual'=>$tarea->ifhecha]);
			return response()->json($response);
		}
	}

	public function edit(Request $request, $ctarea){
		$tarea = Tareas::where("ctarea",$ctarea)->first();

		if ( !$tarea ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La Tarea $ctarea no existe" ));

		if ($request->isMethod('get')){
			return view( 'tareas.create', array(
				"ajax" => array(
					"url" => "/tareas/edit/$ctarea" ,
					"method" => "POST" ,
				),
				"action" => "edit",
				"crud_action" => "edit",
				"tarea" => $tarea,
				)
			);

		}

		$dataBody = $request->all();
		$validator = Validator::make($dataBody["tarea"],
			[
				'ctarea' => 'required|exists:tareas,ctarea',
				'cplan' => 'required|exists:planes,cplan',
				'ntarea' => 'required|max:255',
				'valor_tarea' => 'required|numeric',
				'ifhecha' => 'required|boolean',
			],
			[
				'ctarea.required' => 'Eliga una Tarea',
				'ctarea.exists' => 'La Tarea no Existe.',
				'cplan.required' => 'Eliga un Producto Minimo',
				'cplan.exists' => 'El Pructo Minimo No existe.',
				'ntarea.required' => 'El nombre del plan es requerido',
				'valor_tarea.required' => 'Ingrese un valor para la Tarea',
				'valor_tarea.numeric' => 'El valor de la tarea debe ser numerico',
				'ifhecha.required' => 'La Tarea esta Completada?',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors_form"=>$messages),400);
		}else{
			$plan = Planes::where("cplan",$dataBody["tarea"]["cplan"])->first();

			// Verificar que el tiplo del plan sea producto minimo
			if ( $plan->ctiplan == 4 ){
				$user = Auth::user();
				Tareas::where('ctarea',$ctarea)->update($dataBody["tarea"]);
				Log::info('Edicion Tarea ,',['tarea'=> $tarea->id,'user' => $user->id,'estado edicion'=> $tarea->ifhecha ]);
				$tarea = Tareas::where("ctarea",$ctarea)->first();

				return response()->json(array("obj" => $tarea->toArray()));

			}else{
				return response()->json(array("errors_form"=>array("cplan"=>"El plan no es un Producto Minimo")),400);
			}
		}
	}

	public function create(Request $request){

		if ($request->isMethod('get')) {
			return view( 'tareas.create', array(
				"ajax" => array(
					"url" => "/tareas/create" ,
					"method" => "POST" ,
				),
				"action" => "create",
				"crud_action" => "create",
				"tarea" => null,
				)
			);

		}

		$dataBody = $request->all();
		$validator = Validator::make($dataBody["tarea"],
			[
				'cplan' => 'required|exists:planes,cplan',
				'ntarea' => 'required|max:255',
				'valor_tarea' => 'required|numeric',
				'ifhecha' => 'required|boolean',
			],
			[
				'cplan.required' => 'Eliga un Producto Minimo',
				'cplan.exists' => 'El Pructo Minimo No existe.',
				'ntarea.required' => 'El nombre del plan es requerido',
				'valor_tarea.required' => 'Ingrese un valor para la Tarea',
				'valor_tarea.numeric' => 'El valor de la tarea debe ser numerico',
				'ifhecha.required' => 'La Tarea esta Completada?',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors_form"=>$messages),400);
		}else{
			$plan = Planes::where("cplan",$dataBody["tarea"]["cplan"])->first();

			// Verificar que el tiplo del plan sea producto minimo
			if ( $plan->ctiplan == 4 ){
				$user = Auth::user();
				$tarea = Tareas::create($dataBody["tarea"]);
				Log::info('Creacion Tarea ,',['tarea'=> $tarea->id,'user' => $user->id,'estado creacion'=> $tarea->ifhecha ]);
				return response()->json(array("obj" => $tarea->toArray()));

			}else{
				return response()->json(array("errors_form"=>array("cplan"=>"El plan no es un Producto Minimo")),400);
			}
		}
	}
}
