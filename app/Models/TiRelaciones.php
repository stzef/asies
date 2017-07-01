<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctirelacion
 * @property string $ntirelacion
 * @property string $created_at
 * @property string $updated_at
 * @property Asignaciontarea[] $asignaciontareas
 */
class TiRelaciones extends Model
{
	protected $primaryKey = "ctirelacion";
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'tirelaciones';

	/**
	 * @var array
	 */
	protected $fillable = ['ntirelacion', 'created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function asignaciontareas(){
		return $this->hasMany('App\Asignaciontarea', 'ctirelacion', 'ctirelacion');
	}

}
