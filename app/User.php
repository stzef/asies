<?php

namespace asies;

use Illuminate\Foundation\Auth\User as Authenticatable;
use asies\Models\TareasUsuarios;
use asies\Models\AsignacionTareas;
use asies\Models\Tareas;
use asies\Models\Actividades;
use asies\Models\HistorialEncuestas;

use Bican\Roles\Traits\HasRoleAndPermission;
use Bican\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;

class User extends Authenticatable implements HasRoleAndPermissionContract
{
	use HasRoleAndPermission;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		#'name', 'email', 'password','cpersona',
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function persona(){
		return $this->belongsTo('asies\Models\Personas','cpersona','cpersona');
		#return $this->belongsTo('asies\Models\Personas','cpersona','cpersona');

	}

	public function getTareas(){
		$tareas = \DB::table('asignaciontareas')
			->join('users', 'asignaciontareas.user', '=', 'users.id')
			->join('tareas', 'asignaciontareas.ctarea', '=', 'tareas.ctarea')
			->select('tareas.*')
			->where('users.id', $this->id)
			//->groupBy('actividadestareas.cactividad')
			->get();
		return $tareas;
	}

	public function getEncuestas(){
		return HistorialEncuestas::where("user",$this->id)->get();
	}

	public function getAsignacion(){
		$response = [
			"asignaciones" => [],
			"totales" => 0,
			"ok" => 0,
			"no_ok" => 0,
			"estado" => [
				"completadas" => 0,
				"pendientes" => 0,
				"por_hacer" => 0,
			]
		];

		$asignacion = AsignacionTareas
			::where('user', $this->id);
			// ->groupBy('cactividad');
		
		$qOk = clone $asignacion;
		$qNoOk = clone $asignacion;

		$response["asignaciones"] = $asignacion->get();
		$response["totales"] = count($asignacion->get());
		$response["ok"] = $qOk->where("ifhecha",1)->count();
		$response["no_ok"] = $qNoOk->where("ifhecha",0)->count();

		
		$response["estado"]["completadas"] = 0;
		$response["estado"]["pendientes"] = 0;
		$response["estado"]["por_hacer"] = 0;

		return $response;
	}

	public function callback($n) {return $n->cactividad;}

	public function getActividades(){
		$TIRELACION_RESPONSABLE = \Config::get("app.CTE")["TIRELACION_RESPONSABLE"];

		$actividades = \DB::table('asignaciontareas')
			->join('users', 'asignaciontareas.user', '=', 'users.id')
			->join('actividades', 'asignaciontareas.cactividad', '=', 'actividades.cactividad')
			->select('actividades.cactividad')
			->where('users.id', $this->id)
			->groupBy('actividades.cactividad')
			->get();

		$cactividades = array_map(array($this, 'callback'), $actividades);
		$actividades = Actividades::select()->whereIn('cactividad', $cactividades)->get();
		//dump($actividades);exit();



		return $actividades;
	}

}
