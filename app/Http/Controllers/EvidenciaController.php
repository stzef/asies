<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use asies\Models\Evidencias;
use asies\Models\Actividades;
use asies\Models\Checklists;
use asies\Models\Actas;
use asies\Helpers\Helper;
use View;

use Illuminate\Support\Facades\File;

class EvidenciaController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}
	public function send(Request $request){
		$data = $request->all();

		$if_send_all = array_search("__ALL__",$data["mails"]);
		if ( $if_send_all != false ){
			unset($data["mails"][$if_send_all]);
		}
		$data["errors"] = [];
		$data["if_send_all"] = $if_send_all;

		$status = \Mail::send('emails.sendFiles', $data, function ($message) use (&$data){
			$mails = $data["mails"];
			$files = $data["files"];


			$slug = env("SLUG_APP","shared");
			foreach ($files as $file) {
				$path = "";
				$emailsActividad = [];
				if ( $file["type"] == "EVIDENCIA" ){
					$evidencia = Evidencias::where("cevidencia",$file["id"])->first();
					$actividad = $evidencia->actividad()->first();
					$emailsActividad = $actividad->getEmails();
					if ( $evidencia ) {
						$path = base_path()."/public".$evidencia->path;
					}
				}
				if ( $file["type"] == "ACTA" ){
					$acta = Actas::where("idacta",$file["id"])->first();
					if($acta){
						$actividad = $acta->actividad()->first();

						$emailsActividad = $actividad->getEmails();

						$namefile = "acta_{$acta->numeroacta}.pdf";
						$dir_path = base_path()."/public/evidencias/{$slug}/actividades/actividad_{$actividad->cactividad}";
						$path = "$dir_path/$namefile";
					}
				}
				if ( $file["type"] == "CHECKLIST" ){
					$checklist = Checklists::where("cchecklist",$file["id"])->first();
					$actividad = $checklist->actividad()->first();
					$emailsActividad = $actividad->getEmails();
					$namefile = "checklist_{$actividad->cactividad}_{$checklist->cchecklist}.xlsx";
					$dir_path = base_path()."/public/evidencias/{$slug}/actividades/actividad_{$actividad->cactividad}";
					$path = "$dir_path/$namefile";
				}

				if(\File::exists($path)){
					$message->attach($path);
				}else{
					$filename = basename($path);
					array_push($data["errors"], "No se envió el archivo $filename. Revise si ya fue generado.");
				}
				if ( $data["if_send_all"]){


					array_merge($data["mails"],$emailsActividad );
				}


			}

			$message->to($data["mails"])->subject($data["asunto"]);
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
		return view('evidencias/list',[
			"evidencias" => $evidencias,
			"actas" => $actas,
			"checklists" => $checklists,
			"actividad" => $actividad,
		]);
	}
	public function download(Request $request, $cactividad = null){
		$slug = env("SLUG_APP","shared");
		
		$folder = public_path() . "/evidencias/$slug/actividades/";
		$name = "Evidencias Actividades $slug.zip";
		if ( $cactividad ){
			$folder = public_path() . "/evidencias/$slug/actividades/actividad_$cactividad/";
			$name = "Evidencias Actividades $slug Actividad $cactividad.zip";
		}
		$forlders = [$folder];
		foreach ($forlders as $path) {
			if ( !File::exists($path) ){
				dump("El directorio '$path' no existe");exit();
			}else{
				dump(glob($path));
				if (count(glob($path)) == 0 ) { 
					dump("El directorio '$path' Esta vacio");exit();
				}
			}
		}
		$path_file = Helper::createZip($name,$forlders);
		return $path_file;
	}
}
