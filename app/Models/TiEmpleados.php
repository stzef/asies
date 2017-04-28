<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctiempleado
 * @property string $ntiempleado
 * @property string $created_at
 * @property string $updated_at
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
    protected $fillable = ['ntiempleado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function personas()
    {
        return $this->hasMany('App\Persona', 'ctiempleado', 'ctiempleado');
    }
}
