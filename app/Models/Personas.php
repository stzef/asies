<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cpersona
 * @property integer $ccargo
 * @property integer $ctiempleado
 * @property string $identificacion
 * @property string $nombres
 * @property string $apellidos
 * @property string $direccion
 * @property string $telefono
 * @property string $celular
 * @property string $email
 * @property string $created_at
 * @property string $updated_at
 * @property Cargo $cargo
 * @property Tiempleado $tiempleado
 * @property User[] $users
 */
class Personas extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['ccargo', 'ctiempleado', 'identificacion', 'nombres', 'apellidos', 'direccion', 'telefono', 'celular', 'email', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cargo()
    {
        return $this->belongsTo('App\Cargo', 'ccargo', 'ccargo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiempleado()
    {
        return $this->belongsTo('App\Tiempleado', 'ctiempleado', 'ctiempleado');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User', 'cpersona', 'cpersona');
    }
}
