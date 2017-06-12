<?php

namespace asies\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ccargo
 * @property string $ncargo
 * @property string $created_at
 * @property string $updated_at
 * @property Personas[] $personas
 */
class Cargos extends Model
{
	/**
	 * @var array
	 */
	protected $fillable = ['ncargo', 'created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function persona(){
		return $this->hasMany('asies\Models\Personas', 'ccargo', 'ccargo');
	}
}
