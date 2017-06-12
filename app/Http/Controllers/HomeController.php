<?php

namespace asies\Http\Controllers;

use asies\Http\Requests;
use Illuminate\Http\Request;
use asies\Models\Planes;

use \View;

class HomeController extends Controller
{
	public function __construct(){
		View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
		View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
		$this->middleware('auth',['except' => 'alcaldias']);
	}

	public function index(){
		return view('home');
	}

	public function alcaldias(){
		$alcaldias = \Config::get("app.empresas");
		$server_name = $_SERVER['SERVER_NAME'];
		$context = array(
			'alcaldias' => $alcaldias,
			'server_name' => $server_name
		);
		return view('alcaldias',$context);
	}
}
