<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;

use asies\Models\PlanesUsuarios;
use asies\Models\Planes;

use \Auth;
use \View;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Validator;

class PlanesController extends Controller
{
	public function __construct()
	{
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}
	public function create(Request $request){
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
	public function status(Request $request,$cplan){


		$plan = Planes::where("cplan",$cplan)->first();
		if ( !$plan ) return view('errors/generic',array('title' => 'Error Plan.', 'message' => "El plan $cplan no existe" ));
		$context = array(
			"plan" => $plan,
		);
		return view('planes/status',$context);
	}
}
