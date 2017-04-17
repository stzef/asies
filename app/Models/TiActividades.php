<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctiactividad
 * @property string $ntiactividad
 * @property Actividade[] $actividades
 */
class TiActividades extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tiactividades';

    /**
     * @var array
     */
    protected $fillable = ['ntiactividad'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividades()
    {
        return $this->hasMany('App\Actividade', 'ctiactividad', 'ctiactividad');
    }
}
