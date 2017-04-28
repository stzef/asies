<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use asies\Models\Actividades;
use asies\Models\Evidencias;
use asies\Models\Personas;
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

	public function summaryActivity(Request $request,$cactividad){
		if ($request->isMethod('get')){
			if ( $actividad = Actividades::where("cactividad", $cactividad)->first() ) {
				$tareas = $actividad->getTareas();
				$evidencias = $actividad->getEvidencias();
				return view( 'actividades.summaryActivity' , array(
					'tareas' => $tareas,
					'actividad' => $actividad,
					'evidencias' => $evidencias,
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
		return response()->json(array());
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
			//dump($file);
			//dump($data);exit();
			foreach($file as $files){
				$filename = $files->getClientOriginalName();
				$extension = $files->getClientOriginalExtension();
				$picture = sha1($filename . time()) . '.' . $extension;

				$path_files = '/evidencias/actividades/actividad_' .$cactividad. '/';
				$destinationPath = public_path().$path_files;

				$files->move($destinationPath, $picture);
				//Storage::disk('s3')->move($destinationPath, $picture);
				$destinationPath1='http://'.$_SERVER['HTTP_HOST'].'/evidencias/actividades/actividad_' .$cactividad. '/';
						$filest = array();
						$filest['name'] = $picture;
						$filest['size'] = $this->get_file_size($destinationPath.$picture);
						$filest['url'] = $destinationPath1.$picture;
				$filest['thumbnailUrl'] = $destinationPath1.$picture;
				$filesa['files'][]=$filest;

				Evidencias::create(array(
					'cactividad' => $cactividad,
					'path' => $path_files.$picture,
					'fregistro' => date("Y-m-d H:i:s"),
				));

			}
			return  $filesa;
		}
	}

}
