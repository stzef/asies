<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use asies\Models\Actividades;
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
	public function doActivity(Request $request,$cactividad){
		if ($request->isMethod('get')){
			if ( $actividad = Actividades::where("cactividad", $cactividad)->first() ) {
				$tareas = $actividad->getTareas();
				return view( 'actividades.doActivity' , array(
					'tareas' => $tareas,
					'actividad' => $actividad,
					));
			}
		}

	}
	public function create(Request $request){
		$user = Auth::user();

		Log::info('Creacion de Plan,',['user' => $user->id ]);

		$dataBody = $request->all();
		$validator = Validator::make($dataBody["actividad"],
			[
				#'cestado' => 'required',
				'ctiactividad' => 'required',
				#'cacta' => 'required',
				'nactividad' => 'required',
				'fini' => 'required',
				'ffin' => 'required',
				'ifacta' => 'required',
				'ifarchivos' => 'required',
				#'ifdescripcion' => 'required',
			],
			[
				#'cestado.required' => 'required',
				'ctiactividad.required' => 'required',
				#'cacta.required' => 'required',
				'nactividad.required' => 'required',
				'fini.required' => 'required',
				'ffin.required' => 'required',
				'ifacta.required' => 'required',
				'ifarchivos.required' => 'required',
				#'ifdescripcion.required' => 'required',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors_form" => $messages),400);
		}
		$actividad = Actividades::create($dataBody["actividad"]);
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

	public function store(Request $request)
	{
		if ($request->hasFile('files')) {
			$file = $request->file('files');
			foreach($file as $files){
				$filename = $files->getClientOriginalName();
				$extension = $files->getClientOriginalExtension();
				$picture = sha1($filename . time()) . '.' . $extension;
				$folder = "hola";

				//specify your folder

				$destinationPath = public_path() . '/files_clients/' .$folder. '/';
				$files->move($destinationPath, $picture);
				//Storage::disk('s3')->move($destinationPath, $picture);
				$destinationPath1='http://'.$_SERVER['HTTP_HOST'].'/files_clients/' .$folder. '/';
						$filest = array();
						$filest['name'] = $picture;
						$filest['size'] = $this->get_file_size($destinationPath.$picture);
						$filest['url'] = $destinationPath1.$picture;
				$filest['thumbnailUrl'] = $destinationPath1.$picture;
				$filesa['files'][]=$filest;
			}
			return  $filesa;
		}
	}

}
