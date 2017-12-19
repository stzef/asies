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

Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\LoginController@authenticate');
Route::get('logout', 'Auth\LoginController@logout');
Route::get('register', 'Auth\AuthController@showRegistrationForm')->middleware('auth');
Route::post('register', 'Auth\AuthController@register')->middleware('auth');
Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset', 'Auth\PasswordController@reset');

Route::get('/', function () {
	return redirect('/dashboard');
});

Route::get('/alcaldias', 'HomeController@alcaldias')->name('GET_alcaldias');

# Visualizador de logs
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth');

Route::get('/dashboard', 'AppController@dashboard')->name('app_dashboard')->middleware('auth');

Route::group(['prefix' => 'api'], function(){

	Route::group(['prefix' => '{model}'], function(){
		Route::group(['prefix' => '{id}'], function(){
			Route::post('/property', "APIController@property");
		});
	});

	Route::group(['prefix' => 'tiplanes'], function(){
		Route::get('/', "APIController@tiplanes");
	});

	Route::group(['prefix' => 'tareas'], function(){
		Route::get('/', "APIController@tareas");
		Route::get('/{ctarea}', "APIController@tarea");
	});

	Route::group(['prefix' => 'checklist'], function(){});

	Route::group(['prefix' => 'planes'], function(){
		Route::get('/', "APIController@planes");
		Route::get('/{cplan}', "APIController@plan");
		Route::get('/{cplan}/usuarios', "APIController@usuarios_plan");
	});

	Route::group(['prefix' => 'actividades'], function(){
		Route::get('/', "APIController@actividades");

		Route::group(['prefix' => '{cactividad}'], function(){
			# Ex actividades/{cactividad}/assign
			Route::post('/assign', "APIController@asignar_tarea");
			Route::delete('/assign', "APIController@remove_tarea_asignada");

			Route::group(['prefix' => 'tareas'], function(){

				Route::group(['prefix' => '{ctarea}'], function(){

					# Ex actividades/{cactividad}/tareas/{ctarea}/do
					Route::post('/do', "APIController@realizar_tarea");
				});

			});
		});
	});

	Route::group(['prefix' => 'evidencias'], function(){
		Route::put('/{cevidencia}/set', "APIController@update_evidencia");
		Route::delete('/{cevidencia}/delete', "APIController@destroy_evidencia");
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
	Route::post('recalcular', "PlanesController@recalcularPuntos")->name('POST_recaulcular_puntos')->middleware("permission:planes.calculate_points");
	Route::get('status/{cplan}', "PlanesController@status")->name('GET_status_plan');

	Route::get('/treeview', 'ArbolTareasController@treeview')->name('GET_treetask')->middleware("permission:tasktree.see")->middleware('auth');
});

Route::group(['prefix' => 'actividades'], function(){
	Route::post('create', "ActividadesController@create")->middleware("permission:activities.crud");
	Route::get('create', "ActividadesController@create")->name("GET_actividades_create")->middleware("permission:activities.crud");

	Route::post('actualizarEstado', "ActividadesController@actualizarEstado")->name("POST_actividades_actualizar_estado")->middleware("permission:activities.crud");

	Route::post('edit/{cactividad}', "ActividadesController@edit")->middleware("permission:activities.crud");
	Route::get('edit/{cactividad}', "ActividadesController@edit")->name("GET_actividades_edit")->middleware("permission:activities.crud");

	Route::get('list', "ActividadesController@list_activities")->name("GET_actividades_list")->middleware("permission:activities.crud");

	Route::get('do/{cactividad}', "ActividadesController@doActivity")->name('realizar_actividad')->middleware("permission:activities.do");;
	Route::get('detail/{cactividad}', "ActividadesController@detailActivity")->name('GET_detalle_actividad');

	Route::get('checkDates/{cplan?}',"ActividadesController@checkDates")->name('GET_verificar_fechas_actividades')->middleware("permission:activities.check_dates");
	Route::post('checkDates/{cplan?}',"ActividadesController@checkDates")->name('POST_verificar_fechas_actividades')->middleware("permission:activities.send_reminders");

	Route::get('summary/{cactividad}', "ActividadesController@summaryActivity")->name('GET_resumen_actividad');
	Route::post('evidence/{cactividad}', "ActividadesController@store");
	
	Route::get('archivos/download/{cactividad?}', "EvidenciaController@download")->name("GET_downlaod_evidencias")/*->middleware("permission:activities.crud")*/;
	Route::get('archivos/{cactividad?}', "EvidenciaController@index")->name("GET_lista_evidencias")/*->middleware("permission:activities.crud")*/;
	Route::post('archivos/send', "EvidenciaController@send")->name("POST_send_files")/*->middleware("permission:activities.crud")*/;

	Route::group(['prefix' => '{cactividad}'], function(){

		Route::group(['prefix' => 'checklist'], function(){

			Route::get('export/{format}', "ChecklistsController@excel")->name("GET_export_checklist_excel");
			Route::post('answer', "ChecklistsController@answer_checklist")->name("answer_checklist");

			Route::post('evidencias/{cpregunta}', "ChecklistsController@store")->name("POST_store_evidence_answer");

		});
	});
});

Route::group(['prefix' => 'archivos'], function(){});

Route::group(['prefix' =>'actas'], function(){
	Route::post('create','ActasController@create')->middleware("permission:actas.crud");;
	Route::get('/','ActasController@list_actas')->name("GET_list_actas")->middleware("permission:actas.crud");;
	Route::get('/pdf/{numeroacta}', "ActasController@pdf")->name("GET_pdf_acta")->middleware("permission:actas.crud");;
	Route::get('/send/{numeroacta}', "ActasController@send")->name("GET_send_acta")->middleware("permission:actas.crud");;
});

Route::group(['prefix' => 'tareas'], function(){
	Route::get('create', "TareasController@create")->name("GET_tareas_create")->middleware("permission:task.crud");
	Route::post('create', "TareasController@create")->middleware("permission:task.crud");

	Route::get('edit/{ctarea}', "TareasController@edit")->middleware("permission:task.crud");
	Route::post('edit/{ctarea}', "TareasController@edit")->middleware("permission:task.crud");

	Route::get('activities/{ctarea}', "TareasController@activities")->middleware("permission:task.crud");

	Route::post('/{ctarea}/change_state', "TareasController@change_state")->name("POST_cambiar_estado_tarea");
});


Route::group(['prefix' => 'encuestas'], function(){
	Route::get('/', "EncuestasController@encuestas")->name('GET_list_encuestas');
	Route::get('/{cencuesta}', "EncuestasController@encuesta")->name('GET_encuesta');
	Route::get('/{cencuesta}/export/{format}', "EncuestasController@excel")->name('GET_export_encuesta_excel');
});


Route::group(['prefix' => 'reportes'], function(){
	Route::group(['prefix' => 'tareas'], function(){
		Route::get('general', "ReportesController@tareas_general")->name('reportes_tareas_general');
		
		Route::get('view/by_user', "ReportesController@view_tareas_by_user")->name('reportes_view_tareas_by_user');
		Route::get('view/between', "ReportesController@view_tareas_between")->name('reportes_view_tareas_between');
		Route::get('view/general', "ReportesController@view_tareas_general")->name('reportes_view_tareas_general');
	});
});

Route::group(['prefix' => 'users'], function(){
	Route::group(['prefix' => '{user}'], function(){
		Route::get('actividades', "PerfilController@actividades")->name('mis_actividades');
	});
	Route::group(['prefix' => 'manage'], function(){
		Route::get('/create', "UsersController@viewCreate")->name('show_create');
		Route::get('/edit/{id}', "UsersController@viewEdit")->name('show_edit');
		Route::post('/edit/{id}', "UsersController@edit")->name('edit_user');
		Route::get('/list', "UsersController@viewList")->name('list_user');
		Route::post('/create', "UsersController@create")->name('create_user');
	});
	Route::group(['prefix' => 'encuestas'], function(){
		Route::get('/', "PerfilController@encuestas")->name('GET_list_encuestas_user');

		Route::group(['prefix' => '{chencuesta}'], function(){

			Route::get('do', "PerfilController@doEncuesta")->name('GET_realizar_encuesta');
			Route::post('do', "PerfilController@answer_encuesta")->name('POST_answer_encuesta');
			Route::get('show', "PerfilController@showEncuesta")->name('GET_mostrar_encuesta');

		});
	});
	

});
