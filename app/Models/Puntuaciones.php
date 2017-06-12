<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cpuntuacion
 * @property string $npuntuacion
 * @property string $sigla
 * @property integer $vini
 * @property integer $vfin
 * @property integer $orden
 * @property string $color
 * @property Planes[] $planes
 */
class Puntuaciones extends Model
{
	/**
	 * @var array
	 */
	protected $fillable = ['npuntuacion', 'sigla', 'vini', 'vfin', 'orden', 'color'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function planes(){
		return $this->hasMany('asies\Models\Planes', 'cpuntuacion', 'cpuntuacion');
	}
}
