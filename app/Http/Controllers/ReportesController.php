<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use PDF;
use Illuminate\Support\Facades\Log;
use asies\Models\Planes;

class ReportesController extends Controller
{
	public function tareas_general(Request $request){
		$slug = env("SLUG_APP","shared");
		$planes = Planes::getArbolPlanes();
		// dump($planes);exit();
		$data = array(
			"planes" => $planes,
		);
		PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
		$pdf = PDF::loadView('reportes/tareas/general', $data);

		$namefile = "rpeorte_tareas_general_.pdf";
		$dir_path = base_path()."/public/evidencias/$slug/reportes";
		$file_path = "$dir_path/$namefile";

		if ( ! is_dir( $dir_path ) ) {
			Log::warning('La carpeta no existe en la direccion: ',['path' => $dir_path ]);
			if ( mkdir( $dir_path, 0777 ) ){
				return $pdf->save( $file_path )->stream();
			}else{
				return view('errors/generic',array('title' => 'Error Interno.', 'message' => "Hay Ocurrido un error Interno, Por favor Intente de Nuevo" ));
			}
		}else{
			return $pdf->save( $file_path )->stream();
		}
	}
}
