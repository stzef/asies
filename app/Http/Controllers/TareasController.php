<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use View;
use asies\Models\Actividades;
use asies\Models\Tareas;
use Illuminate\Support\Facades\Validator;

class TareasController extends Controller
{
	public function __construct()
	{
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function users_task(Request $request,$ctarea){
		$dataBody = $request->all();
		$dataBody["tareasusuarios"]["ctarea"] = $ctarea;
		$validator = Validator::make($dataBody["tareasusuarios"],
			[
				'ctarea' => 'required',
				'user' => 'required|max:255',
				'ctirelacion' => 'required',
			],
			[
				'ctarea.required' => 'El nombre del plan es requerido',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors_form" => $messages),400);
		}else{
			$tareas = Tareas::where('ctarea', $ctarea)->first();
			$response = $tareas->add_user(
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

	public function create(Request $request){
		if ($request->isMethod('get')) return view( 'tareas.create');
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
			$tarea = Tareas::create($dataBody["tarea"]);
			dump($tarea);
			return response()->json(array());
		}



	}
}
