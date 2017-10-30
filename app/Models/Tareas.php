<?php

// namespace App;
namespace asies\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctarea
 * @property integer $cplan
 * @property string $ntarea
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
	protected $fillable = ['cplan', 'ntarea', 'created_at', 'updated_at'];

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
	public function asignacion(){
		return $this->hasMany('asies\Models\AsignacionTareas', 'ctarea', 'ctarea')
			->groupBy("cactividad");
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function asignaciones($ifhecha=true){
		return AsignacionTareas::where('ctarea', $this->ctarea)
			// ->where("ifhecha","=",$ifhecha)
			->groupBy("cactividad")
			->get();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function asignacionBetween($fini, $ffin,$ifhecha=true){
		return AsignacionTareas::where('ctarea', $this->ctarea)
			->whereDate("updated_at",">=",$fini)
			->whereDate("updated_at","<=",$ffin)
			// ->where("ifhecha","=",$ifhecha)
			->groupBy("cactividad")
			->get();
		}
		
	/**
	* @return \Illuminate\Database\Eloquent\Relations\HasMany
	*/
	public function asignacionByUser($user_id,$ifhecha=true){
		return AsignacionTareas::where('ctarea', $this->ctarea)
		->where("user_id","=",$user_id)
		// ->where("ifhecha","=",$ifhecha)
		->groupBy("cactividad")
		->get();
	}

}
