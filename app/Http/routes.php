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
});

Route::group(['prefix' => 'actividades'], function(){
	Route::post('create', "ActividadesController@create");
	Route::get('create', "ActividadesController@create")->name("GET_actividades_create");

	Route::get('do/{cactividad}', "ActividadesController@doActivity")->name('realizar_actividad');
	Route::get('summary/{cactividad}', "ActividadesController@summaryActivity")->name('GET_resumen_actividad');
	Route::post('evidence/{cactividad}', "ActividadesController@store");
});

Route::group(['prefix' =>'actas'], function(){
	Route::post('create','ActasController@create');
});

Route::group(['prefix' => 'asignacion'], function(){
		Route::post('/{cactividad}/{ctarea}/usuarios', "AsignacionController@users")->name("POST_users_task");
});

Route::group(['prefix' => 'tareas'], function(){
	Route::get('create', "TareasController@create")->name("GET_tareas_create");
	Route::post('create', "TareasController@create");

	Route::post('/{ctarea}/change_state', "TareasController@change_state")->name("POST_cambiar_estado_tarea");
});

Route::group(['prefix' => 'utilities'], function(){
	Route::get('tasktree', "UtilitiesController@tasktree");
});

Route::group(['prefix' => 'users'], function(){
	Route::group(['prefix' => '{user}'], function(){
		Route::get('actividades', "PerfilController@actividades")->name('mis_actividades');
		//Route::post('/{cplan}/add/usuario', "PlanesController@add_user_to_plan");
	});
});
