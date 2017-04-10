<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;

use asies\Models\PlanesUsuarios;
use asies\Models\Planes;
use View;

use \Auth;

class PerfilController extends Controller
{
	    public function __construct()
    {
    	View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
    	View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
        $this->middleware('auth');
    }
	public function misplanes(Request $request){
		$user = Auth::user();
		$cplanes = PlanesUsuarios::where('usuario', $user->id)->get();
		$planes = array();
		foreach ($cplanes as $data) {
			array_push( $planes, Planes::where("cplan",$data["cplan"])->first() );
		}
		//dump($planes);exit();

		return view( 'perfil.misplanes', array( "planes" => $planes ) );

	}
}
