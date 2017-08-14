<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $detalle
 * @property OpcionesPregunta[] $opcionespreguntas
 * @property Respuestas[] $respuestas
 */
class Opciones extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['detalle'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opcionespregunta()
    {
        return $this->hasMany('asies\Models\OpcionesPregunta', 'copcion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function respuestas()
    {
        return $this->hasMany('asies\Models\Respuestas', 'copcion');
    }
}
