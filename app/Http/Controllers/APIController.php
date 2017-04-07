<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;

use asies\Models\Planes;
use asies\User;
use asies\Models\Personas;
use asies\Models\Tirelacion;


class APIController extends Controller
{
	public function planes()
	{
		$planes = Planes::getArbolPlanes(true);
		return response()->json($planes);
	}
	public function tirelaciones()
	{
		$tirelaciones = Tirelacion::all();
		return response()->json($tirelaciones);
	}
	public function usuarios()
	{
		$usuarios = User::all();
		foreach ($usuarios as $usuario) {
			$persona = Personas::where('usuario', $usuario->id)->first();
			$usuario->persona = $persona;
		}
		return response()->json($usuarios);
	}
}
