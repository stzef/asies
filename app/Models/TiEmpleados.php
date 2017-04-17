<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctiempleado
 * @property string $ntiempleado
 * @property Persona[] $personas
 */
class TiEmpleados extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tiempleados';

    /**
     * @var array
     */
    protected $fillable = ['ntiempleado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personas()
    {
        return $this->hasMany('App\Persona', 'ctiempleado', 'ctiempleado');
    }
}
