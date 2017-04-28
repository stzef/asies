<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctiusuario
 * @property string $ntiusuario
 * @property string $created_at
 * @property string $updated_at
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
    protected $fillable = ['ntiusuario', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'ctiusuario', 'ctiusuario');
    }
}
