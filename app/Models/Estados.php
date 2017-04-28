<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cestados
 * @property string $nestados
 * @property boolean $ifcerrado
 * @property string $created_at
 * @property string $updated_at
 * @property Actividade[] $actividades
 * @property Plane[] $planes
 */
class Estados extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['nestados', 'ifcerrado', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividades()
    {
        return $this->hasMany('App\Actividade', 'cestado', 'cestados');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planes()
    {
        return $this->hasMany('App\Plane', 'cestado', 'cestados');
    }
}
