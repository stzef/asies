<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;

use asies\Models\Tareas;
use asies\Models\Encuestas;
use asies\Models\HistorialEncuestas;
use asies\Models\Actividades;
use asies\Models\EncuestaDeta;
use View;
use Illuminate\Support\Facades\Validator;

use \Auth;

class PerfilController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function actividades(Request $request){
		$user = Auth::user();
		$actividades = $user->getActividades();

		foreach ($actividades as $actividad) {
			$actividad->calcularDias();
			$actividad->tareas = $actividad->getTareas($user->id);
		}

		return view('perfil/dashboard', array( "actividades" => $actividades ) );
	}

	public function encuestas(Request $request){
		$user = Auth::user();
		$hisencuestas = $user->getEncuestas();
		return view('users/encuestas/list', array( "hisencuestas" => $hisencuestas ) );
	}

	public function doEncuesta(Request $request, $chencuesta){
		$user = Auth::user();
		/*
		$encuesta = Encuestas::where("cencuesta",$cencuesta)->first();
		if ( !$encuesta ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La encuesta $cencuesta no existe" ));

		$hisencuesta = HistorialEncuestas::where("cencuesta",$encuesta->cencuesta)->first();
		if ( !$hisencuesta ){
			$hisencuesta = HistorialEncuestas::create([
				'cencuesta' => $encuesta->cencuesta,
				'user' => $user->id,
				'fecha' => date("Y-m-d"),
			]);
		}
		*/
		$hisencuesta = HistorialEncuestas::where("chencuesta",$chencuesta)->first();
		if ( !$hisencuesta ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La encuesta Historica $hisencuesta no existe" ));

		$encuesta = $hisencuesta->getEncuesta();
		return view('users/encuestas/do', array( "encuesta" => $encuesta, "hisencuesta" => $hisencuesta ) );
	}

	public function showEncuesta(Request $request, $chencuesta){
		$user = Auth::user();
		$hisencuesta = HistorialEncuestas::where("chencuesta",$chencuesta)->first();
		if ( !$hisencuesta ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La encuesta $chencuesta no existe" ));

		$encuesta = $hisencuesta->getEncuesta();
		return view('users/encuestas/show', array( "encuesta" => $encuesta, "hisencuesta" => $hisencuesta ) );
	}

	public function answer_encuesta( Request $request, $chencuesta ){

		$hisencuesta = HistorialEncuestas::where("chencuesta",$chencuesta)->first();
		if ( !$hisencuesta ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La encuesta $chencuesta no existe" ));

		$dataBody = $request->all();

		$response = [
			"message" => "Se contesto la pregunta.",
			"answers" => [],
		];

		$dataBody["chencuesta"] = $hisencuesta->chencuesta;

		$validator = Validator::make($dataBody,
			[
				'chencuesta' => 'required|numeric|exists:checklist,chencuesta',
				'answers.*.cpregunta' => 'numeric|exists:preguntas,cpregunta',
				'answers.*.cpregunta' => 'nullable|numeric|exists:opciones,copcion',
			]
		);

		foreach ($dataBody["answers"] as $answer) {

			$queryRespuesta = EncuestaDeta::where("chencuesta",$dataBody["chencuesta"])->where("cpregunta",$answer["cpregunta"]);

			$arr = [
				"cpregunta" => $answer["cpregunta"],
				// "anotaciones" => $answer["anotaciones"]
			];

			$status = $arr;

			if ( $answer["isOpenQuestion"] )
				{ $arr["respuesta"] = $answer["respuesta"]; }
			else
				{ $arr["copcion"] = $answer["copcion"]; }

			if ( $queryRespuesta->first() ){
				$queryRespuesta->update($arr);
				$status["message"] = "La respuesta se edito.";
			}else{
				$arr["chencuesta"] = $dataBody["chencuesta"];
				EncuestaDeta::create($arr);
				$status["message"] = "La respuesta se creo.";
			}

			array_push($response["answers"], $status);
		}

		$state = $hisencuesta->updateState();
		$response["message"] .= " {$state["message"]}";

		return response()->json($response);
	}
}
