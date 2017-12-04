<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use PDF;
use Illuminate\Support\Facades\Log;
use asies\Models\Planes;
use asies\User;
use \View;

class ReportesController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function view_tareas_by_user(Request $request){
		$context = [
			"planes" => Planes::where("cplanmayor", "=", null)->get(),
			"users" => User::all(),
		];
		return view('reportes/tareas/views/by_user', $context);
	}

	public function view_tareas_between(Request $request){
		$context = [
			"planes" => Planes::where("cplanmayor", "=", null)->get(),			
		];
		return view('reportes/tareas/views/between', $context);
	}

	public function view_tareas_general(Request $request){
		$context = [
			"planes" => Planes::where("cplanmayor", "=", null)->get(),			
		];
		return view('reportes/tareas/views/general', $context);
	}

	public function tareas_general(Request $request){
		$slug = env("SLUG_APP","shared");
		$planes = Planes::getArbolPlanes();
		
		$type = $request->get("type","general");
		$format = $request->get("format","html");

		$cplan = $request->get("cplan", false);

		$fini = $request->get("fini", false);
		$ffin = $request->get("ffin", false);
		$user = $request->get("user", false);
		
		$task = $request->get("task", "all");
		$percentages = $request->get("percentages", "1");
		
		
		// if ( $cplan == false ){ dump("Ha Ocurrido un Error");exit(); }
		
		if ( $cplan ){
			$plan = Planes::where("cplan", $cplan)->first();
			$plan->subplanes = Planes::getSubPlanes($cplan);
			$plan = [$plan];
		}else{
			$plan = Planes::where("cplanmayor", null)->get();
			foreach ($plan as $p) {
				$p->subplanes = Planes::getSubPlanes($p->cplan);
			}
			// dump($plan);exit();
		}

		$title = "Reporte de Tareas";
		if ( $type == "general" ){
		}else if ( $type == "date" ){
			if ( $fini == false || $ffin == false ){ dump("Ha Ocurrido un Error Date");exit(); }
			$title .= " Desde $fini Hasta $ffin";
		}else if ( $type == "user" ){
			
			if ( $user == false ) {dump("Ha Ocurrido un Error User");exit();}
			$objuser = User::where("id",$user)->first();
			$title .= " Del Usuario " . $objuser->persona->nombreCompleto();
		}else{
			dump("Ha Ocurrido un Error No");exit();
		}
		$data = [
			// "show" => $show,
			"type" => $type,
			"plan" => $plan,
			"title" => $title,
			"show" => [
				"task" => $task,
				"percentages" => $percentages,
			],
			"info" => [
				"fini" => $fini,
				"ffin" => $ffin,
				"user" =>  $user,
			],
		];

		if ( $format == "pdf" ){
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
		}else{
			
			return view('reportes/tareas/general', $data);
		}
	}
}
