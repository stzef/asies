<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Planes;
use App\User;
use App\Models\Personas;
use App\Models\Tirelacion;


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
