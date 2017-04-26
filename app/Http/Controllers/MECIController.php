<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use asies\Models\Tareas;
use asies\Models\Planes;
use asies\Models\Personas;
use asies\Models\TiActividades;
use asies\Models\TiRelaciones;
use View;

class MECIController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    	View::share('SHORT_NAME_APP', env("SHORT_NAME_APP"," - "));
    	View::share('LONG_NAME_APP', env("LONG_NAME_APP"," - "));
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $tareas = Tareas::all();
        $responsables = Personas::all();
        $tiactividades = TiActividades::all();
        $relaciones = TiRelaciones::all();
        $context = array("tareas"=>$tareas,"tiactividades"=>$tiactividades,"responsables"=>$responsables,"relaciones"=>$relaciones);
        return view('meci/dashboard',$context);
    }
}
