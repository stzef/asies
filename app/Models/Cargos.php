<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ccargo
 * @property string $ncargo
 * @property string $created_at
 * @property string $updated_at
 * @property Persona[] $personas
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
    public function personas()
    {
        return $this->hasMany('App\Persona', 'ccargo', 'ccargo');
    }
}
