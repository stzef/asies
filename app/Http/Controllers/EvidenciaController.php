<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use asies\Models\Evidencias;
use View;

class EvidenciaController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}
	public function index($cactividad=null){
		if ( $cactividad ){
			$evidencias = Evidencias::where("cactividad",$cac);
		}else{
			$evidencias = Evidencias::all();
		}
		return view('evidencias/list');
	}
}
