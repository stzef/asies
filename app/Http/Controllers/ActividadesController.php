<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use asies\Models\Actividades;
use asies\Models\Evidencias;
use asies\Models\Personas;
use asies\Models\Planes;
use asies\Models\Tareas;
use asies\Models\Actas;
use asies\Models\TiActividades;
use asies\Models\Parametros;
use asies\Models\TiRelaciones;
use asies\User;
use Illuminate\Support\Facades\Log;
use \Auth;
use View;
use Storage;

use Carbon\Carbon;


use Illuminate\Support\Facades\Validator;

class ActividadesController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function create(Request $request){

		if ($request->isMethod('get')){
			$tareas = Tareas::all();

			$usuarios = User::all();

			$tiactividades = TiActividades::all();
			$relaciones = TiRelaciones::all();
			$context = array(
				"tareas" => $tareas,
				"tiactividades" => $tiactividades,
				"usuarios" => $usuarios,
				"relaciones" => $relaciones,
				"ajax" => array(
					"url" => "/actividades/create" ,
					"method" => "POST" ,
				),
				"action" => "create",
				"crud_action" => "create",
				"actividad" => null,
			);
			return view('actividades/create',$context);
		}
		$dataBody = $request->all();
		$validator = Validator::make($dataBody["actividad"],
			[
				#'cestado' => 'required',
				'ctiactividad' => 'required|exists:tiactividades,ctiactividad',
				#'cacta' => 'required',
				'nactividad' => 'required|max:255',
				'descripcion' => 'required|max:500',
				'fini' => 'required|date',
				'ffin' => 'required|date',
				'ifacta' => 'required|boolean',
				'ifarchivos' => 'required|boolean',
			],
			[
				#'cestado.required' => 'required',
				'ctiactividad.required' => 'required',
				#'cacta.required' => 'required',
				'nactividad.required' => 'required',
				'descripcion.required' => 'required',
				'fini.required' => 'required',
				'ffin.required' => 'required',
				'ifacta.required' => 'required',
				'ifarchivos.required' => 'required',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors_form" => $messages),400);
		}else{
			$actividad = Actividades::create($dataBody["actividad"]);
			$user = Auth::user();
			Log::info('Creacion de actividad,',['actividad'=>$actividad->cactividad,'ctiactividad'=> $dataBody['actividad']['ctiactividad'],'user' => $user->id ]);
		}

		return response()->json(array("obj" => $actividad->toArray()));
	}

	public function edit(Request $request,$cactividad){
		$actividad = Actividades::where('cactividad',$cactividad)->first();

		if ( !$actividad ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La actividad $cactividad no existe" ));

		if ($request->isMethod('get')){
			$tareas = Tareas::all();

			$usuarios = User::all();

			$tiactividades = TiActividades::all();
			$relaciones = TiRelaciones::all();
			$context = array(
				"tareas" => $tareas,
				"tiactividades" => $tiactividades,
				"usuarios" => $usuarios,
				"relaciones" => $relaciones,
				"ajax" => array(
					"url" => "/actividades/edit/$cactividad" ,
					"method" => "POST" ,
				),
				"action" => "edit",
				"crud_action" => "edit",
				"actividad" => $actividad,
			);
			return view('actividades/create',$context);
		}
		$dataBody = $request->all();
		$validator = Validator::make($dataBody["actividad"],
			[
				#'cestado' => 'required',
				'ctiactividad' => 'required|exists:tiactividades,ctiactividad',
				#'cacta' => 'required',
				'nactividad' => 'required|max:255',
				'descripcion' => 'required|max:500',
				'fini' => 'required|date',
				'ffin' => 'required|date',
				'ifacta' => 'required|boolean',
				'ifarchivos' => 'required|boolean',
			],
			[
				#'cestado.required' => 'required',
				'ctiactividad.required' => 'required',
				#'cacta.required' => 'required',
				'nactividad.required' => 'required',
				'descripcion.required' => 'required',
				'fini.required' => 'required',
				'ffin.required' => 'required',
				'ifacta.required' => 'required',
				'ifarchivos.required' => 'required',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors_form" => $messages),400);
		}else{
			Actividades::where("cactividad",$cactividad)->update($dataBody["actividad"]);
			$user = Auth::user();
			$actividad = Actividades::where('cactividad',$cactividad)->first();
			Log::info('Edicion de actividad,',['actividad'=>$actividad->cactividad,'ctiactividad'=> $dataBody['actividad']['ctiactividad'],'user' => $user->id ]);
		}

		return response()->json(array("obj" => $actividad->toArray()));
	}

	public function list_activities(Request $request){
		if ($request->isMethod('get')){
			$actividades = Actividades::all();
			return view( 'actividades.list' , array("actividades" => $actividades));
		}
	}

	public function doActivity(Request $request, $cactividad){

		if ($request->isMethod('get')){
			if ( $actividad = Actividades::where("cactividad", $cactividad)->first() ) {
				$tareas = $actividad->getTareas();
				$usuarios = User::all();
				$numacta = Actas::genCode();
				$usuarios = User::all();
				$tiactividades = TiActividades::all();
				$relaciones = TiRelaciones::all();
				$asignacion = $actividad->getAsignacion();
				return view( 'actividades.doActivity' , array(
					'tareas' => $tareas,
					'actividad' => $actividad,
					'usuarios' => $usuarios,
					'numacta' => $numacta,
					'asignacion' => $asignacion,
					"tiactividades" => $tiactividades,
					"usuarios" => $usuarios,
					"relaciones" => $relaciones
 					));
			}
		}
	}

	public function detailActivity(Request $request,$cactividad){
		if ($request->isMethod('get')){
			if ( $actividad = Actividades::where("cactividad", $cactividad)->first() ) {
				$actividad->asignaciones = $actividad->getAsignacion();
				return view( 'actividades.detailActivity' , array(
					"actividad" => $actividad,
					)
				);
			}
		}
	}

	public function summaryActivity(Request $request,$cactividad){
		if ($request->isMethod('get')){
			if ( $actividad = Actividades::where("cactividad", $cactividad)->first() ) {
				$tareas = $actividad->getTareas();
				$evidencias = $actividad->getEvidencias();
				$asignaciones = [];
				if( $actividad->acta ){
					// $asignaciones = $actividad->acta->getAsistentes();
					$asignaciones = $actividad->getAsignacion();
				}
				return view( 'actividades.summaryActivity' , array(
					'tareas' => $tareas,
					'actividad' => $actividad,
					'evidencias' => $evidencias,
					'asignaciones' => $asignaciones,
					));
			}
		}
	}

	public function checkDates(Request $request,$cplan=null){

		if ( $cplan ){
			$plan = Planes::where("cplan",$cplan)->first();
			$actividades = $plan->getActividadesGrouped();
		}else{
			$actividades = Actividades::getGrouped();
		}

		if ($request->isMethod('get')){
			return view( 'actividades.checkDates' , array(
				'actividades' => $actividades,
				)
			);
		}elseif($request->isMethod('post')){
			$response = array("message"=>"","status"=>array(),"emails"=>array(),"failures"=>array());

			// $actividades["retrasadas"] = [$actividades["retrasadas"][0]];

			// $actividades["retrasadas"] = [$actividades["retrasadas"][0]];

			foreach ($actividades["retrasadas"] as $actividad) {
				$status = Actividades::sendEmailsReminder($actividad);
				array_push($response["status"], $status);
				foreach ($status["emails"] as $email) { array_push($response["emails"], $email); }
				foreach ($status["failures"] as $email) { array_push($response["failures"], $email); }
			}
			$response["emails"] = array_unique($response["emails"]);
			$response["failures"] = array_unique($response["failures"]);

			Log::info('Envio de Recordatorios de Actividades',$response);


			$request->session()->flash('message', 'Se han Enviado los recodatorios!');

			if($request->ajax()){
				$response["message"] = "Se han Enviado los recodatorios!";
				return response()->json($response);
			}
			return redirect( 'dashboard');

		}
	}

	public function store(Request $request,$cactividad){

		if ($request->hasFile('files')) {
			$slug = env("SLUG_APP","shared");

			$file = $request->file('files');
			$data = $request->all();
			foreach($file as $files){
				$filename = $files->getClientOriginalName();
				$filename_clean = UtilitiesController::slugify($filename);
				$extension = $files->getClientOriginalExtension();
				$picture = $filename_clean.sha1($filename_clean . time()) . '.' . $extension;

				$destinationPath1="http://".$_SERVER['HTTP_HOST']."/evidencias/$slug/actividades/actividad_" .$cactividad. "/";

				$ext_img = array("ani","bmp","cal","fax","gif","img","jbg","jpe","jpe","jpg","mac","pbm","pcd","pcx","pct","pgm","png","ppm","psd","ras","tga","tif","wmf");
				if ( in_array($extension, $ext_img) ){
					$thumbnailUrl = $destinationPath1.$picture;
				}else{
					$thumbnailUrl = "/evidencias/generic-file.png";
				}

				$path_files = "/evidencias/$slug/actividades/actividad_$cactividad/";
				$destinationPath = public_path().$path_files;

				$files->move($destinationPath, $picture);
				//Storage::disk('s3')->move($destinationPath, $picture);
				$evidencia = Evidencias::create(array(
					'cactividad' => $cactividad,
					'path' => $path_files.$picture,
					'fregistro' => date("Y-m-d H:i:s"),
					'nombre' => $filename_clean,
				));

				$actividad = Actividades::where("cactividad",$cactividad)->first();
				$actividad->updateState();

						$filest = array();
						$filest['name'] = $picture;
						$filest['size'] = $this->get_file_size($destinationPath.$picture);
						$filest['url'] = $destinationPath1.$picture;
						$filest['evidencia'] = $evidencia->cevidencia;
						$filest['nombre'] = $evidencia->nombre;

				$filest['thumbnailUrl'] = $thumbnailUrl;
				$filesa['files'][]=$filest;


			}
			return  $filesa;
		}
	}

	protected function get_file_size($file_path, $clear_stat_cache = false) {
		if ($clear_stat_cache) {
			if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
				clearstatcache(true, $file_path);
			} else {
				clearstatcache();
			}
		}
		return $this->fix_integer_overflow(filesize($file_path));
	}

	protected function fix_integer_overflow($size) {
		if ($size < 0) {
			$size += 2.0 * (PHP_INT_MAX + 1);
		}
		return $size;
	}



}
