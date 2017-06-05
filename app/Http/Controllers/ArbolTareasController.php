<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;

use asies\Models\Tareas;
use asies\User;
use asies\Models\Planes;
use asies\Models\Personas;
use asies\Models\TiActividades;
use asies\Models\TiRelaciones;
use asies\Models\TiPlanes;
use View;

class ArbolTareasController extends Controller
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
     * Show the application treeview.
     *
     * @return \Illuminate\Http\Response
     */
    public function treeview()
    {

        $tiplanes = TiPlanes::all();
        $context = array(
            "tiplanes" => $tiplanes,
        );
        return view('planes/tasktree',$context);
    }
}
