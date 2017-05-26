<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use asies\Models\Actividades;
use asies\Models\Evidencias;
use asies\Models\Personas;
use asies\Models\Tareas;
use asies\Models\Actas;
use asies\Models\TiActividades;
use asies\Models\TiRelaciones;
use asies\User;
use Illuminate\Support\Facades\Log;
use \Auth;
use View;
use Storage;

use Illuminate\Support\Facades\Validator;

class ActividadesController extends Controller
{
	public function __construct()
	{
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function summaryActivity(Request $request,$cactividad){
		if ($request->isMethod('get')){
			if ( $actividad = Actividades::where("cactividad", $cactividad)->first() ) {
				$tareas = $actividad->getTareas();
				$evidencias = $actividad->getEvidencias();
				$asignaciones = [];
				if( $actividad->acta ){
					$asignaciones = $actividad->acta->getAsistentes();
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

	public function doActivity(Request $request,$cactividad){

		if ($request->isMethod('get')){
			if ( $actividad = Actividades::where("cactividad", $cactividad)->first() ) {
				$tareas = $actividad->getTareas();
				$usuarios = User::all();
				$numacta = Actas::genCode();
				$asignacion = $actividad->getAsignacion();
				//dump($asignacion);exit();
				return view( 'actividades.doActivity' , array(
					'tareas' => $tareas,
					'actividad' => $actividad,
					'usuarios' => $usuarios,
					'numacta' => $numacta,
					'asignacion' => $asignacion,
 					));
			}
		}
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
			//dump($actividad->id);exit();
			$user = Auth::user();
			$actividad = Actividades::where('cactividad',$cactividad)->first();
			Log::info('Creacion de actividad,',['actividad'=>$actividad->id,'ctiactividad'=> $dataBody['actividad']['ctiactividad'],'user' => $user->id ]);
		}

		return response()->json(array("obj" => $actividad->toArray()));
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
			//dump($actividad->id);exit();
			$user = Auth::user();
			Log::info('Creacion de actividad,',['actividad'=>$actividad->id,'ctiactividad'=> $dataBody['actividad']['ctiactividad'],'user' => $user->id ]);
		}

		return response()->json(array("obj" => $actividad->toArray()));
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

	public function store(Request $request,$cactividad)
	{

		if ($request->hasFile('files')) {
			$file = $request->file('files');
			$data = $request->all();
			//dump($data);exit();
			foreach($file as $files){
				$filename = $files->getClientOriginalName();
				$extension = $files->getClientOriginalExtension();
				$picture = sha1($filename . time()) . '.' . $extension;

				//var_dump($extension);exit();
				$destinationPath1='http://'.$_SERVER['HTTP_HOST'].'/evidencias/actividades/actividad_' .$cactividad. '/';

				$ext_img = array("ani","bmp","cal","fax","gif","img","jbg","jpe","jpe","jpg","mac","pbm","pcd","pcx","pct","pgm","png","ppm","psd","ras","tga","tif","wmf");
				if ( in_array($extension, $ext_img) ){
					$thumbnailUrl = $destinationPath1.$picture;
				}else{
					$thumbnailUrl = "/evidencias/generic-file.png";
				}

				$path_files = '/evidencias/actividades/actividad_' .$cactividad. '/';
				$destinationPath = public_path().$path_files;

				$files->move($destinationPath, $picture);
				//Storage::disk('s3')->move($destinationPath, $picture);
				$evidencia = Evidencias::create(array(
					'cactividad' => $cactividad,
					'path' => $path_files.$picture,
					'fregistro' => date("Y-m-d H:i:s"),
				));
						$filest = array();
						$filest['name'] = $picture;
						$filest['size'] = $this->get_file_size($destinationPath.$picture);
						$filest['url'] = $destinationPath1.$picture;
						$filest['evidencia'] = $evidencia->id;
				$filest['thumbnailUrl'] = $thumbnailUrl;
				$filesa['files'][]=$filest;


			}
			return  $filesa;
		}
	}

}
