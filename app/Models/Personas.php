<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $usuario
 * @property string $identificacion
 * @property string $nombres
 * @property string $apellidos
 * @property string $direccion
 * @property string $telefono
 * @property string $celular
 * @property string $email
 * @property User $user
 */
class Personas extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['usuario', 'identificacion', 'nombres', 'apellidos', 'direccion', 'telefono', 'celular', 'email'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'usuario');
    }
}
