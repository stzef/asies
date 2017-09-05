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
		return view('encuestas/encuesta', array( "encuesta" => $encuesta ) );
	}

	public function excel(Request $request, $cencuesta,$format){
		$encuesta = Encuestas::where("cencuesta",$cencuesta)->first();
		if ( !$encuesta ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "La encuesta $cactividad no existe" ));

		$formats = [ 'xlsx', 'xlsm', 'xltx', 'xltm', 'xls', 'xlt', 'ods', 'ots', 'slk', 'xml', 'gnumeric', 'htm', 'html', 'csv', 'txt', 'pdf'];
		if ( !in_array($format, $formats) ) return view('errors/generic',array('title' => 'Error Codigo.', 'message' => "Formato de Documento Invalido" ));

		$data = [
			"encuesta" => $encuesta,
		];

		return \Excel::create("Encuesta {$encuesta->cencuesta} - {$encuesta->nombre}", function($excel) use($data) {
			$excel->sheet('Encuesta', function($sheet) use($data) {
				$sheet->loadView('excel/encuestas/encuesta',[
					"encuesta" => $data["encuesta"]
				]);
			});


			$excel->sheet('Estadisticas', function($sheet) use($data) {
				$sheet->loadView('excel/encuestas/estadisticas',[
					"encuesta" => $data["encuesta"]
				]);
			});
		})->download($format);

	}
}
