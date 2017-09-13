<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;
use asies\Http\Requests;

use View;
use \Auth;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

use asies\User;
use asies\Models\Actividades;
use asies\Models\Tareas;
use asies\Models\Planes;
use asies\Models\TiRelaciones;
use asies\Models\AsignacionTareas;

class TareasController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function create(Request $request){

		if ($request->isMethod('get')) {

			$usuarios = User::all();
			$relaciones = TiRelaciones::all();

			return view( 'tareas.create', array(
				"ajax" => array(
					"url" => "/tareas/create" ,
					"method" => "POST" ,
				),
				"action" => "create",
				"crud_action" => "create",
				"tarea" => null,
				"usuarios" => $usuarios,
				"relaciones" => $relaciones,
				)
			);

		}

		$dataBody = $request->all();

		$validator = Validator::make($dataBody["tarea"],
			[
				'cplan' => 'required|exists:planes,cplan',
				'ntarea' => 'required|max:255',
			],
			[
				'cplan.required' => 'Eliga un Producto Minimo',
				'cplan.exists' => 'El Pructo Minimo No existe.',
				'ntarea.required' => 'El nombre del plan es requerido',
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
				Log::info('Creacion Tarea ,',['tarea'=> $tarea->ctarea,'user' => $user->id, ]);
				return response()->json(array("obj" => $tarea->toArray()));

			}else{
				return response()->json(array("errors_form"=>array("cplan"=>"El plan no es un Producto Minimo")),400);
			}
		}
	}

	public function edit(Request $request, $ctarea){
		$tarea = Tareas::where("ctarea",$ctarea)->first();

		if ( !$tarea ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La Tarea $ctarea no existe" ));

		$usuarios = User::all();
		$relaciones = TiRelaciones::all();

		if ($request->isMethod('get')){
			return view( 'tareas.create', array(
				"ajax" => array(
					"url" => "/tareas/edit/$ctarea" ,
					"method" => "POST" ,
				),
				"action" => "edit",
				"crud_action" => "edit",
				"tarea" => $tarea,
				"usuarios" => $usuarios,
				"relaciones" => $relaciones,
				)
			);

		}

		$dataBody = $request->all();
		$validator = Validator::make($dataBody["tarea"],
			[
				'ctarea' => 'required|exists:tareas,ctarea',
				'cplan' => 'required|exists:planes,cplan',
				'ntarea' => 'required|max:255',
			],
			[
				'ctarea.required' => 'Eliga una Tarea',
				'ctarea.exists' => 'La Tarea no Existe.',
				'cplan.required' => 'Eliga un Producto Minimo',
				'cplan.exists' => 'El Pructo Minimo No existe.',
				'ntarea.required' => 'El nombre del plan es requerido',
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
				Log::info('Edicion Tarea ,',['tarea'=> $tarea->ctarea,'user' => $user->id, ]);
				$tarea = Tareas::where("ctarea",$ctarea)->first();

				return response()->json(array("obj" => $tarea->toArray()));

			}else{
				return response()->json(array("errors_form"=>array("cplan"=>"El plan no es un Producto Minimo")),400);
			}
		}
	}

	public function activities(Request $request, $ctarea){
		$tarea = Tareas::where("ctarea",$ctarea)->first();

		if ( !$tarea ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La Tarea $ctarea no existe" ));


		$asignaciones = AsignacionTareas::where("ctarea",$ctarea)->groupBy('cactividad')->get();


		$context = [
			"tarea" => $tarea,
			"asignaciones" => $asignaciones,
		];

		return view('tareas/activities',$context);
	}

}
