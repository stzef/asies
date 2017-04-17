<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctirelacion
 * @property string $ntirelacion
 * @property Tareasusuario[] $tareasusuarios
 */
class TiRelaciones extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tirelaciones';

    /**
     * @var array
     */
    protected $fillable = ['ntirelacion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tareasusuarios()
    {
        return $this->hasMany('App\Tareasusuario', 'ctirelacion', 'ctirelacion');
    }
}
