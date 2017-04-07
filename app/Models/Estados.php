<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cestados
 * @property string $nestados
 * @property boolean $ifcerrado
 * @property Plane[] $planes
 * @property Registro[] $registros
 */
class Estados extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['nestados', 'ifcerrado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planes()
    {
        return $this->hasMany('asies\Models\Plane', 'cestado', 'cestados');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registros()
    {
        return $this->hasMany('asies\Models\Registro', 'cestado', 'cestados');
    }
}
