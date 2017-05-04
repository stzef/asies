<?php

namespace asies\Http\Controllers;

use asies\Http\Requests;
use Illuminate\Http\Request;
use \View;
use \App;

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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML('<h1>Test</h1>');
        return $pdf->stream();
        return view('home');
    }
}
