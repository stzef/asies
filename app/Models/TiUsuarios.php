<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctiusuario
 * @property string $ntiusuario
 * @property User[] $users
 */
class TiUsuarios extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tiusuarios';

    /**
     * @var array
     */
    protected $fillable = ['ntiusuario'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'ctiusuario', 'ctiusuario');
    }
}
