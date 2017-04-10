<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;

use asies\Models\PlanesUsuarios;
use asies\Models\Planes;

use \Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;

class PlanesController extends Controller
{
	public function add_user_to_plan(Request $request,$cplan){
		$dataBody = $request->all();
		$dataBody["cplan"] = $cplan;
		$validator = Validator::make($dataBody,
			[
				'cplan' => 'required',
				'usuario' => 'required|max:255',
				'ctirelacion' => 'required',
			],
			[
				'cplan.required' => 'El nombre del plan es requerido',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json($messages,400);
		}else{
			$plan = Planes::where('cplan', $cplan)->first();
			$response = $plan->add_user(
				array(
					"cplan" => $dataBody["cplan"],
					"usuario" => $dataBody["usuario"],
					"ctirelacion" => $dataBody["ctirelacion"]
				)
			);
			if ( $response["obj"] ) $response["obj"] = $response["obj"]->toArray();
			return response()->json($response);
		}
	}

	public function create(Request $request)
	{
		$user = Auth::user();

		Log::info('Creacion de Plan,',['user' => $user->id ]);

		$dataBody = $request->all()["plan"];
		/*$validator = Validator::make($dataBody,
			[
				'cplan' => 'required|unique:planes',
				'nplan' => 'required|max:255',
				'cestado' => 'required',
				#'nivel' => '',
				'cplanmayor' => 'required',
				#'icono' => 'required|max:100',
				'ifacta' => 'boolean',
				'ifarchivos' => 'boolean',
				'iftexto' => 'boolean',
				'iffechaini' => 'boolean',
			],
			[
				'nplan.required' => 'El nombre del plan es requerido',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json($messages,400);
		}*/
		//$plan = Planes::create($dataBody["plan"]);
		$plan->add_user($data);
		return response()->json(array("text"=>"ok"));
	}
}