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

		$plan->add_user($data);
		return response()->json(array("text"=>"ok"));
	}
	public function recalcularPuntos(Request $request){
		$user = Auth::user();

		try {
			Planes::recalcularPuntos();
			Log::info('Recaulculo de Puntos',['user' => $user->id ]);
			return response()->json(array("text"=>"ok"));
		} catch (Exception $e) {
			return response()->json(array("text"=>"Ha ocurrido un error"),400);

		}

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
