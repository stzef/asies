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
        /*
        $user = new User();
        $user->password = \Hash::make('ejecutor1');
        $user->email = 'ejecutor1@gmail.com';
        $user->name = "ejecutor1";
        $user->cpersona = 1;
        $user->save();

        $user = new User();
        $user->password = \Hash::make('responsable1');
        $user->email = 'responsable1@gmail.com';
        $user->name = "responsable1";
        $user->cpersona = 1;
        $user->save();

        $user = new User();
        $user->password = \Hash::make('alcalde1');
        $user->email = 'alcalde1@gmail.com';
        $user->name = "alcalde1";
        $user->cpersona = 1;
        $user->save();
        */

        $tiplanes = TiPlanes::all();
        $context = array(
            "tiplanes" => $tiplanes,
        );
        return view('planes/tasktree',$context);
    }
}
