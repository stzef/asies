<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
	return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/dashboard', 'AppController@dashboard')->name('app_dashboard')->middleware('auth');

Route::group(['prefix' => 'meci'], function(){
	Route::get('/dashboard', 'MECIController@dashboard')->name('meci_dashboard')->middleware('auth');
});

Route::group(['prefix' => 'api'], function(){
	Route::group(['prefix' => 'planes'], function(){
		Route::get('/', "APIController@planes");
		Route::get('/{cplan}/usuarios', "APIController@usuarios_plan");
	});
	Route::group(['prefix' => 'usuarios'], function(){
		Route::get('/', "APIController@usuarios");
	});
	Route::group(['prefix' => 'tirelaciones'], function(){
		Route::get('/', "APIController@tirelaciones");
	});
});

Route::group(['prefix' => 'planes'], function(){
	Route::post('create', "PlanesController@create");
	Route::post('/{cplan}/add/usuario', "PlanesController@add_user_to_plan");
});

Route::group(['prefix' => 'utilities'], function(){
	Route::get('tasktree', "UtilitiesController@tasktree");
});

Route::group(['prefix' => 'users'], function(){
	Route::group(['prefix' => '{user}'], function(){
		Route::get('planes', "PerfilController@misplanes");
		//Route::post('/{cplan}/add/usuario', "PlanesController@add_user_to_plan");
	});
});
