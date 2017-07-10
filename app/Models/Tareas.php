<?php

namespace App;namespace asies\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctarea
 * @property integer $cplan
 * @property string $ntarea
 * @property integer $valor_tarea
 * @property string $created_at
 * @property string $updated_at
 * @property Plane $plane
 * @property Actividadestarea[] $actividadestareas
 * @property Asignaciontarea[] $asignaciontareas
 */
class Tareas extends Model
{
	protected $primaryKey = "ctarea";
	/**
	 * @var array
	 */
	protected $fillable = ['cplan', 'ntarea', 'valor_tarea', 'created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function plane(){
		return $this->belongsTo('App\Plane', 'cplan', 'cplan');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function actividadestareas(){
		return $this->hasMany('App\Actividadestarea', 'ctarea', 'ctarea');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function asignaciontareas(){
		return $this->hasMany('App\Asignaciontarea', 'ctarea', 'ctarea');
	}

	public function setState($new_state){
		Tareas::where('ctarea', $this->ctarea)->update(['ifhecha' => $new_state]);
		$asignaciones = AsignacionTareas::where("ctarea",$this->ctarea)->get();
		foreach ( $asignaciones as $asignacion ){
			$status_act = $asignacion->actividad->updateState();
			if ( $status_act["ifhecha"] == 1 ){

			}
		}
	}

	public function checkUser($iduser){
		$flag = false;
		if ( AsignacionTareas::where("user",$iduser)->where("ctarea",$this->ctarea)->exists() ){
			$flag = true;
		}
		return $flag;
	}

}
