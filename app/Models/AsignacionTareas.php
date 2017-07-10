<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $ctarea
 * @property integer $ctirelacion
 * @property integer $user
 * @property integer $cactividad
 * @property boolean $ifhecha
 * @property integer $valor_tarea
 * @property string $created_at
 * @property string $updated_at
 * @property Tareas $tarea
 * @property Tirelaciones $tirelacione
 * @property User $user
 * @property Actividades $actividad
 */
class AsignacionTareas extends Model
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'asignaciontareas';

	/**
	 * @var array
	 */
	protected $fillable = ['ctarea', 'ctirelacion', 'user', 'cactividad', 'ifhecha', 'valor_tarea', 'created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function tarea(){
		return $this->belongsTo('asies\Models\Tarea', 'ctarea', 'ctarea');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function tirelacion(){
		return $this->belongsTo('asies\Models\Tirelacione', 'ctirelacion', 'ctirelacion');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user(){
		return $this->belongsTo('App\User', 'user');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function actividad()
	{
		return $this->belongsTo('asies\Models\Actividades', 'cactividad', 'cactividad');
	}
}
