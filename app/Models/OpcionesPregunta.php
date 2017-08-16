<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $cpregunta
 * @property integer $copcion
 * @property Preguntas $pregunta
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
    protected $fillable = ['cpregunta', 'copcion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pregunta()
    {
        return $this->belongsTo('asies\Models\Preguntas', 'cpregunta', 'cpregunta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opcion()
    {
        return $this->belongsTo('asies\Models\Opciones', 'copcion', 'copcion');
    }
}
