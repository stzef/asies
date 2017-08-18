<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $ctipregunta
 * @property integer $copcion
 * @property TiPreguntas $tipregunta
 * @property Opciones $opcione
 */
class OpcionesPregunta extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'opcionespregunta';

    /**
     * @var array
     */
    protected $fillable = ['ctipregunta', 'copcion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipregunta()
    {
        return $this->belongsTo('asies\Models\TiPreguntas', 'ctipregunta', 'ctipregunta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opcion()
    {
        return $this->belongsTo('asies\Models\Opciones', 'copcion', 'copcion');
    }
}
