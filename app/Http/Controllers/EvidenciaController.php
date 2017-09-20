<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use asies\Models\Evidencias;
use asies\Models\Actividades;
use asies\Models\Checklists;
use asies\Models\Actas;
use View;

class EvidenciaController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}
	public function send(Request $request){
		$data = $request->all();
		$mails = $data["mails"];
		$files = $data["files"];

		$status = \Mail::send('emails.sendFiles', $data, function ($message) use ($data){
			$message->to($data["mails"])->subject('Correo de Evidencias');
		});

		return response()->json($data,200);
	}
	public function index($cactividad=null){
		if ( $cactividad ){
			$actividad = Actividades::where("cactividad",$cactividad)->first();
			$evidencias = $actividad->getEvidencias();
			$actas = $actividad->cacta ? [$actividad->acta] : [];
			$checklists = Checklists::where("cactividad",$actividad->cactividad)->get();
		}else{
			$evidencias = Evidencias::all();
			$actas = Actas::all();
			$checklists = Checklists::all();
			$actividad = null;
		}
		// dump($actas[0]->actividad);exit();
		return view('evidencias/list',[
			"evidencias" => $evidencias,
			"actas" => $actas,
			"checklists" => $checklists,
			"actividad" => $actividad,
		]);
	}
}
