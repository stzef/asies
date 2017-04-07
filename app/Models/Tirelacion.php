<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctirelacion
 * @property string $ntirelacion
 * @property Planesusuario[] $planesusuarios
 */
class Tirelacion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tirelacion';

    /**
     * @var array
     */
    protected $fillable = ['ntirelacion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planesusuarios()
    {
        return $this->hasMany('asies\Models\Planesusuario', 'ctirelacion', 'ctirelacion');
    }
}
