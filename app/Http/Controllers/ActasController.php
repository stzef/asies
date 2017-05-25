<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;
use Weblee\Mandrill\Mail;
use asies\Http\Requests;
use asies\Models\Actividades;
use asies\Models\Evidencias;
use asies\Models\Personas;
use asies\Models\ActasAsistentes;
use asies\Models\Actas;
use asies\User;
use Illuminate\Support\Facades\Log;
use \Auth;
use View;
use PDF;
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

	public function create(Request $request){


		$dataBody = $request->all();

		$actividad = Actividades::where("cactividad",$dataBody["acta"]["cactividad"])->first();

		if ( $actividad->cacta ) return response()->json(array("warning" => "La Actividad ya acta {$actividad->cacta}"),400);

		$validator = Validator::make($dataBody["acta"],
			[
				'numeroacta' => 'required',
				'objetivos' => 'required',
				'fhini' => 'required|date',
				'fhfin' => 'required|date',
				'sefirma' => 'required|max:100',
				'user_elaboro' => 'required|exists:users,id',
				'user_reviso' => 'required|exists:users,id',
				'user_aprobo' => 'required|exists:users,id',
			],
			[
				'numeroacta.required' => 'required',
				'objetivos.required' => 'required',
				'fhini.required' => 'required',
				'fhfin.required' => 'required',
				'sefirma.required' => 'required',
				'user_elaboro.required' => 'required',
				'user_reviso.required' => 'required',
				'user_aprobo.required' => 'required',
			]
		);

		if ($validator->fails()){
			$messages = $validator->messages();
			return response()->json(array("errors_form" => $messages),400);
		}else{
			$user = Auth::user();
			Log::info('Creacion de Acta,',['user' => $user->id, 'numeroacta' => $dataBody['acta']['numeroacta'], 'elaboro' => $dataBody['acta']['user_elaboro'], 'reviso' => $dataBody['acta']['user_reviso'], 'aprobo' => $dataBody['acta']['user_aprobo']]);
		}

		$acta = Actas::create($dataBody["acta"]);

		foreach ($dataBody["acta"]["asistentes"] as $idusuario) {
			ActasAsistentes::create(array(
				"cacta" => $acta->id,
				"user" => $idusuario
			));
		}

		Actividades::where("cactividad",$dataBody["acta"]["cactividad"])->update(["cacta"=>$acta->id]);

		return response()->json(array());
	}

/**
	 * Send Welcome Email throught mandriall APP
	 * https://mandrillapp.com/api/docs/messages.php.html
	 * @param  int  $activationLink
	 * @param  int  $userEmail
	 * @param  int  $userName
	 * @return Response
	 */
	public function send(request $request,$numeroacta){
		$data = array(
			'acta' => Actas::where("numeroacta",$numeroacta)->first()
		);
			$prueba=\Mail::send('welcome', [], function ($message) use ($data){
				$actividad = $data['acta']->getActividad();
				$namefile = "acta_{$data['acta']->numeroacta}.pdf";
				$dir_path = base_path()."/public/evidencias/actividades/actividad_{$actividad->cactividad}";
				$file_path = "$dir_path/$namefile";
		    	$message->attach($file_path);
		    	$message->to('sistematizaref.programador5@gmail.com')->subject('Testing mail');
			});
			dump($prueba);exit();
	}


	public function pdf(Request $request,$numeroacta){
		//dump(phpinfo());exit();
		$acta = Actas::where("numeroacta",$numeroacta)->first();

		if ( !$acta ) return view('errors/generic',array('title' => 'Error PDF.', 'message' => "El acta $numeroacta no existe" ));

		$acta->asistentes = $acta->getAsistentes();

		$actividad = $acta->getActividad();

		$data = array("acta" => $acta,"actividad" => $actividad,);
		//return view('actas.pdf',$data);

		PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
		$pdf = PDF::loadView('actas.pdf', $data);

		//return $pdf->download('invoice.pdf');

		$namefile = "acta_{$acta->numeroacta}.pdf";
		$dir_path = base_path()."/public/evidencias/actividades/actividad_{$actividad->cactividad}";
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
