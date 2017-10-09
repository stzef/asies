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
		
		$fini = $request->get("fini", false);
		$ffin = $request->get("ffin", false);
		$user = $request->get("user", false);

		$type = $request->get("type","general");
		// dump($type);exit();

		// dump("hola");exit();
		if ( $type == "general" ){

		}else if ( $type == "date" ){
			if ( $fini == false || $ffin == false ){ dump("Ha Ocurrido un Error");exit(); }
		}else if ( $type == "user" ){
			if ( $user == false ) {dump("Ha Ocurrido un Error");exit();}
		}else{
			dump("Ha Ocurrido un Error");exit();
		}
		$data = [
			"type" => $type,
			"planes" => $planes,
			"info" => [
				"fini" => $fini,
				"ffin" => $ffin,
				"user" =>  $user,
			],
		];
		// dump($data);exit();
		PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
		$pdf = PDF::loadView('reportes/tareas/general', $data)->setPaper('a4', 'landscape');

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
