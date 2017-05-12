<?php

namespace asies\Http\Controllers;

use asies\Http\Requests;
use Illuminate\Http\Request;
use asies\Models\Planes;

use \View;

class HomeController extends Controller
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
        $this->middleware('auth',['except' => 'alcaldias']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$planes = Planes::recalcularPuntos();
        //dump($planes);exit();
        return view('home');
    }

    public function alcaldias()
    {
        $alcaldias = \Config::get("app.empresas");
        $server_name = $_SERVER['SERVER_NAME'];
        $context = array(
            'alcaldias' => $alcaldias,
            'server_name' => $server_name
        );
        return view('alcaldias',$context);
    }
}
