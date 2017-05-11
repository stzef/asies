<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use Illuminate\Support\Facades\Validator;
use asies\Models\Tareas;
use asies\Models\Actividades;
use View;

class AsignacionController extends Controller
{
	public function __construct()
	{
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}
	public function users(Request $request,$cactividad,$ctarea){
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
			$actividad = Actividades::where('cactividad', $cactividad)->first();
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
