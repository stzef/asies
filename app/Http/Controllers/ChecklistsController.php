<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;

use asies\Models\Actividades;
use asies\Models\ChecklistEvidencias;
use asies\Models\ChecklistDeta;
use Illuminate\Support\Facades\Validator;


use View;
use Storage;

use Carbon\Carbon;

class ChecklistsController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function excel(Request $request, $cactividad,$format){

		$actividad = Actividades::where("cactividad",$cactividad)->first();
		if ( !$actividad ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La actividad $cactividad no existe" ));

		$actividad->checklist = $actividad->getChecklist();
		if ( !$actividad->checklist ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La actividad $cactividad tiene un checklist Asociado" ));

		$formats = [ 'xlsx', 'xlsm', 'xltx', 'xltm', 'xls', 'xlt', 'ods', 'ots', 'slk', 'xml', 'gnumeric', 'htm', 'html', 'csv', 'txt', 'pdf'];
		if ( !in_array($format, $formats) ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "Formato de Documento Invalido" ));

		$data = [
			"actividad" => $actividad,
		];

		return \Excel::create("Checklist Actividad {$actividad->cactividad} - {$actividad->nactividad}", function($excel) use($data) {
			$excel->sheet('Checklist', function($sheet) use($data) {
				$sheet->loadView('excel/checklist',[
					"actividad" => $data["actividad"]
				]);
			});


			$excel->sheet('Estadisticas', function($sheet) use($data) {
				$sheet->loadView('excel/estadisticas',[
					"actividad" => $data["actividad"]
				]);
			});
		})->download($format);

	}

	public function store(Request $request,$cactividad,$cpregunta){

		if ($request->hasFile('files')) {
			$slug = env("SLUG_APP","shared");

			$actividad = Actividades::where("cactividad",$cactividad)->first();
			if ( !$actividad ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La actividad $cactividad no existe" ));

			$actividad->checklist = $actividad->getChecklist();
			if ( !$actividad->checklist ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La actividad $cactividad tiene un checklist Asociado" ));

			$cchecklist = $actividad->checklist->cchecklist;

			$queryRespuesta = ChecklistDeta::where("cchecklist",$cchecklist)->where("cpregunta",$cpregunta);

			$arr = [
				"cpregunta" => $cpregunta,
				"anotaciones" => ""
			];

			$status = $arr;

			if ( $checklist_deta = $queryRespuesta->first() ){
				$queryRespuesta->update($arr);
				$status["message"] = "La respuesta se edito.";
			}else{
				$arr["cchecklist"] = $cchecklist;
				$checklist_deta = ChecklistDeta::create($arr);
				$status["message"] = "La respuesta se creo.";
			}


			$file = $request->file('files');
			$data = $request->all();
			foreach($file as $files){
				$filename = $files->getClientOriginalName();
				$filename_clean = UtilitiesController::slugify($filename);
				$extension = $files->getClientOriginalExtension();
				$picture = $filename_clean.sha1($filename_clean . time()) . '.' . $extension;

				$destinationPath1="http://".$_SERVER['HTTP_HOST']."/evidencias/$slug/checklists/actividad_" .$cactividad. "/";

				$ext_img = array("ani","bmp","cal","fax","gif","img","jbg","jpe","jpe","jpg","mac","pbm","pcd","pcx","pct","pgm","png","ppm","psd","ras","tga","tif","wmf");
				if ( in_array($extension, $ext_img) ){
					$thumbnailUrl = $destinationPath1.$picture;
				}else{
					$thumbnailUrl = "/evidencias/generic-file.png";
				}

				$path_files = "/evidencias/$slug/checklists/actividad_$cactividad/";
				$destinationPath = public_path().$path_files;
				// dump($destinationPath, $picture);exit();
				$files->move($destinationPath, $picture);
				//Storage::disk('s3')->move($destinationPath, $picture);
				$evidencia = ChecklistEvidencias::create(array(
					'cchecklistdeta' => $checklist_deta->id,
					'descripcion' => "-",
					'nombre' => $filename_clean,
					'path' => $path_files.$picture,
					'fregistro' => date("Y-m-d H:i:s"),
				));

				$actividad = Actividades::where("cactividad",$cactividad)->first();
				$actividad->updateState();

						$filest = array();
						$filest['name'] = $picture;
						//$filest['size'] = $this->get_file_size($destinationPath.$picture);
						$filest['url'] = $destinationPath1.$picture;
						// $filest['evidencia'] = $evidencia->cevidencia;
						// $filest['nombre'] = $evidencia->nombre;

				$filest['thumbnailUrl'] = $thumbnailUrl;
				$filesa['files'][]=$filest;


			}
			return  $filesa;
		}
	}

	public function answer_checklist( Request $request, $cactividad ){

		$actividad = Actividades::where("cactividad",$cactividad)->first();
		if ( !$actividad ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La actividad $cactividad no existe" ));

		$actividad->checklist = $actividad->getChecklist();
		if ( !$actividad->checklist ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La actividad $cactividad tiene un checklist Asociado" ));


		$dataBody = $request->all();

		$response = [
			"message" => "Se contesto la pregunta.",
			"answers" => [],
		];

		$dataBody["cchecklist"] = $actividad->checklist->cchecklist;

		$validator = Validator::make($dataBody,
			[
				'cchecklist' => 'required|numeric|exists:checklist,cchecklist',
				'answers.*.cpregunta' => 'numeric|exists:preguntas,cpregunta',
				'answers.*.cpregunta' => 'nullable|numeric|exists:opciones,copcion',
			]
		);

		foreach ($dataBody["answers"] as $answer) {

			$queryRespuesta = ChecklistDeta::where("cchecklist",$dataBody["cchecklist"])->where("cpregunta",$answer["cpregunta"]);

			$arr = [
				"cpregunta" => $answer["cpregunta"],
				"anotaciones" => $answer["anotaciones"]
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
				$arr["cchecklist"] = $dataBody["cchecklist"];
				ChecklistDeta::create($arr);
				$status["message"] = "La respuesta se creo.";
			}

			array_push($response["answers"], $status);
		}

		$state = $actividad->checklist->updateState();

		$response["message"] .= " {$state["message"]}";

		return response()->json($response);
	}

}
