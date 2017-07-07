<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use asies\Models\Actividades;
use asies\Http\Requests;

use View;

class AppController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth');
	}

	public function dashboard(){
		$now = Carbon::now();
		$now->hour   = 0;
		$now->minute = 0;
		$now->second = 0;

		$actividades_proximas = Actividades::whereDate('fini', '=', $now )->get();
		if ( count($actividades_proximas) == 0 ) {
			$tommorrow = $now->addDay();
			$actividades_proximas = Actividades::whereDate('fini', '=', $tommorrow )->get();
		}
		return view('dashboard',['actividades_proximas' => $actividades_proximas]);
	}
}
