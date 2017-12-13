<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;

use asies\Models\Encuestas;
use asies\Models\HistorialEncuestas;
use View;
use Illuminate\Support\Facades\Validator;

use \Auth;

class EncuestasController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function encuestas(Request $request){
		$encuestas = Encuestas::all();
		return view('encuestas/list', array( "encuestas" => $encuestas ) );
	}

	public function encuesta(Request $request, $cencuesta){
		$encuesta = Encuestas::where("cencuesta",$cencuesta)->first();
		$encuesta->history = HistorialEncuestas::where("cencuesta",$encuesta->cencuesta)->get();
		$encuesta->fechas = HistorialEncuestas::where("cencuesta",$encuesta->cencuesta)->groupBy("fecha")->get()->pluck("fecha")->toArray();
		//dump($encuesta->fechas);exit();

		return view('encuestas/encuesta', array( "encuesta" => $encuesta ) );
	}

	public function excel(Request $request, $cencuesta,$format){
		$fecha = $request->get("fecha");

		$encuesta = Encuestas::where("cencuesta",$cencuesta)->first();
		if ( !$encuesta ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La encuesta $cactividad no existe" ));

		if ( !$fecha ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "No se especifico la fecha de la encuesta" ));

		$formats = [ 'xlsx', 'xlsm', 'xltx', 'xltm', 'xls', 'xlt', 'ods', 'ots', 'slk', 'xml', 'gnumeric', 'htm', 'html', 'csv', 'txt', 'pdf'];
		if ( !in_array($format, $formats) ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "Formato de Documento Invalido" ));

		$encuesta->history = $encuesta->getHistory($fecha);

		$data = [
			"encuesta" => $encuesta,
		];

		// dump($encuesta->history);exit();

		$excel =  \Excel::create("Encuesta {$encuesta->cencuesta} - {$encuesta->nombre}", function($excel) use($data) {
			/*$excel->sheet('Encuesta', function($sheet) use($data) {
				$sheet->loadView('excel/encuestas/encuesta',[
					"encuesta" => $data["encuesta"]
				]);
			});*/

			$excel->sheet('Estadisticas', function($sheet) use($data) {
				$sheet->loadView('excel/encuestas/estadisticas',[
					"encuesta" => $data["encuesta"]
				]);
			});
		});
		
		// $slug = env("SLUG_APP","shared");
		// $dir_path = base_path()."/public/evidencias/{$slug}/actividades/actividad_{$actividad->cactividad}";
		// $path = "$dir_path/";
		// $data = $excel->store('xlsx', $path, true);

		return $excel->download($format);

	}
}
