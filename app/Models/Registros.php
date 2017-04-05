<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $cplan
 * @property integer $cestado
 * @property string $fhregistro
 * @property integer $valor
 * @property Plane $plane
 * @property Estado $estado
 * @property Registrosdetalle[] $registrosdetalles
 */
class Registros extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['cplan', 'cestado', 'fhregistro', 'valor'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plane()
    {
        return $this->belongsTo('App\Models\Plane', 'cplan', 'cplan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo('App\Models\Estado', 'cestado', 'cestados');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registrosdetalles()
    {
        return $this->hasMany('App\Models\Registrosdetalle', 'cplan', 'cplan');
    }
}
