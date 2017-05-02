<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use View;
use \Auth;

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
