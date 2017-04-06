<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Planes;

use \Auth;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;

class PlanesController extends Controller
{
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
		//Planes::create($dataBody["plan"]);

		return response()->json(array("text"=>"ok"));
	}
}
