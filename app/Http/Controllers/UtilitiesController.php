<?php

namespace asies\Http\Controllers;

use Illuminate\Http\Request;

use asies\Http\Requests;
use asies\Models\TiPlanes;

use View;

class UtilitiesController extends Controller
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
    public function tasktree()
    {
        $tiplanes = TiPlanes::all();
        $context = array(
            "tiplanes" => $tiplanes,
        );
        return view('utilities.tasktree', $context);
    }
}
