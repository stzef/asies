<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctiplan
 * @property string $ntiplan
 * @property string $slug
 * @property integer $nivel
 * @property string $icono
 * @property string $created_at
 * @property string $updated_at
 * @property Plane[] $planes
 */
class TiPlanes extends Model
{
	protected $primaryKey = "ctiplan";
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'tiplanes';

	/**
	 * @var array
	 */
	protected $fillable = ['ntiplan','slug', 'nivel', 'icono', 'created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function planes(){
		return $this->hasMany('App\Plane', 'ctiplan', 'ctiplan');
	}
}
