<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use View;
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
	public function create(Request $request){
		if ($request->isMethod('get')) return view( 'tareas.create');

		$dataBody = $request->all();
		$validator = Validator::make($dataBody["tarea"],
			[
				'cplan' => 'required',
				'ntarea' => 'required',
				'valor_tarea' => 'required',
				'ifhecha' => 'required',
			],
			[
				'cplan.required' => 'Eliga un Producto Minimo',
				'ntarea.required' => 'El nombre del plan es requerido',
				'valor_tarea.required' => 'Ingrese un valor para la Tarea',
				'ifhecha.required' => 'La Tarea esta Completada?',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors_form"=>$messages),400);
		}else{
			$tarea = Tareas::create($dataBody["tarea"]);
			return response()->json(array());
		}



	}
}
