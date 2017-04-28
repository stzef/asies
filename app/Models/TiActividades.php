<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctiactividad
 * @property string $ntiactividad
 * @property string $created_at
 * @property string $updated_at
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
    protected $fillable = ['ntiactividad', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividades()
    {
        return $this->hasMany('App\Actividade', 'ctiactividad', 'ctiactividad');
    }
}
