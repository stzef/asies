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

# Route::auth();
Route::get('login', 'Auth\AuthController@showLoginForm');
//Route::post('login', 'Auth\AuthController@login');
Route::post('login', 'Auth\LoginController@authenticate');
//Route::get('logout', 'Auth\AuthController@logout');
Route::get('logout', 'Auth\LoginController@logout');

// Registration Routes...
Route::get('register', 'Auth\AuthController@showRegistrationForm')->middleware('auth');
Route::post('register', 'Auth\AuthController@register')->middleware('auth');

// Password Reset Routes...
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

Route::get('/', function () {
	return redirect('/dashboard');
	//return view('welcome');
});

# Visualizador de logs


Route::get('/alcaldias', 'HomeController@alcaldias')->name('GET_alcaldias');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth');
//Route::get('/home', 'HomeController@index');

Route::get('/dashboard', 'AppController@dashboard')->name('app_dashboard')->middleware('auth');

Route::group(['prefix' => 'api'], function(){
	Route::group(['prefix' => 'planes'], function(){
		Route::get('/', "APIController@planes");
		Route::get('/{cplan}', "APIController@plan");
		Route::get('/{cplan}/usuarios', "APIController@usuarios_plan");
	});
	Route::group(['prefix' => 'evidencias'], function(){
		Route::put('/{cevidencia}/set', "APIController@update_evidencia");
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
	Route::post('recalcular', "PlanesController@recalcularPuntos")->name('POST_recaulcular_puntos');
	Route::get('status/{cplan}', "PlanesController@status")->name('GET_status_plan');

	Route::get('/treeview', 'ArbolTareasController@treeview')->name('GET_treetask')->middleware("permission:tasktree.see")->middleware('auth');

});

Route::group(['prefix' => 'actividades'], function(){
	Route::post('create', "ActividadesController@create")->middleware("permission:activities.crud");
	Route::get('create', "ActividadesController@create")->name("GET_actividades_create")->middleware("permission:activities.crud");

	Route::get('do/{cactividad}', "ActividadesController@doActivity")->name('realizar_actividad');
	Route::get('summary/{cactividad}', "ActividadesController@summaryActivity")->name('GET_resumen_actividad');
	Route::post('evidence/{cactividad}', "ActividadesController@store");
});

Route::group(['prefix' =>'actas'], function(){
	Route::post('create','ActasController@create');
	Route::get('/','ActasController@list');
	Route::get('/pdf/{numeroacta}', "ActasController@pdf")->name("GET_pdf_acta");
	Route::get('/send/{numeroacta}', "ActasController@send")->name("GET_send_acta");
});

Route::group(['prefix' => 'asignacion'], function(){
		Route::post('/{cactividad}/{ctarea}/usuarios', "AsignacionController@users")->name("POST_users_task");
});

Route::group(['prefix' => 'tareas'], function(){
	Route::get('create', "TareasController@create")->name("GET_tareas_create")->middleware("permission:task.crud");
	Route::post('create', "TareasController@create")->middleware("permission:task.crud");

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
