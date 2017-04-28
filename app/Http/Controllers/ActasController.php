<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use asies\Models\Actividades;
use asies\Models\Evidencias;
use asies\Models\Personas;
use asies\Models\ActasAsistentes;
use asies\Models\Actas;
use asies\User;
use Illuminate\Support\Facades\Log;
use \Auth;
use View;
use Storage;

use Illuminate\Support\Facades\Validator;

class ActasController extends Controller
{
	public function __construct()
	{
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function create(Request $request){
		$user = Auth::user();

		Log::info('Creacion de Acta,',['user' => $user->id ]);

		$dataBody = $request->all();
		$validator = Validator::make($dataBody["acta"],
			[
				#'cestado' => 'required',
				'numeroacta' => 'required',
				#'cacta' => 'required',
				'objetivos' => 'required|max:200',
				'ordendeldia' => 'required|max:400',
				'fhini' => 'required|date',
				'fhfin' => 'required|date',
				'sefirma' => 'required|max:100',
				'user_elaboro' => 'required|exists:users,id',
				'user_reviso' => 'required|exists:users,id',
				'user_aprobo' => 'required|exists:users,id',
				#'ifdescripcion' => 'required',
			],
			[
				#'cestado.required' => 'required',
				'numeroacta.required' => 'required',
				'objetivos.required' => 'required',
				'ordendeldia.required' => 'required',
				#'descripcion.required' => 'required',
				'fhini.required' => 'required',
				'fhfin.required' => 'required',
				'sefirma.required' => 'required',
				'user_elaboro.required' => 'required',
				'user_reviso.required' => 'required',
				'user_aprobo.required' => 'required',
				#'ifdescripcion.required' => 'required',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors_form" => $messages),400);
		}

		$acta = Actas::create($dataBody["acta"]);

		foreach ($dataBody["acta"]["asistentes"] as $idusuario) {
			ActasAsistentes::create(array(
				"cacta" => $acta->id,
				"user" => $idusuario
			));
		}

		Actividades::where("cactividad",$dataBody["acta"]["cactividad"])->update(["cacta"=>$acta->id]);

		return response()->json(array());
	}
}
