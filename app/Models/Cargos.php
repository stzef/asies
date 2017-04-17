<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ccargo
 * @property string $ncargo
 * @property Persona[] $personas
 */
class Cargos extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['ncargo'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personas()
    {
        return $this->hasMany('App\Persona', 'ccargo', 'ccargo');
    }
}
