<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Encuestas $encuesta
 * @property Preguntas $pregunta
 * @property int $id
 * @property int $cencuesta
 * @property int $cpregunta
 * @property int $orden
 * @property string $created_at
 * @property string $updated_at
 */
class EncuestaPreguntas extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'encuestapreguntas';

    /**
     * @var array
     */
    protected $fillable = ['cencuesta', 'cpregunta', 'orden', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('asies\Models\Encuestas', 'cencuesta', 'cencuesta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pregunta()
    {
        return $this->belongsTo('asies\Models\Preguntas', 'cpregunta', 'cpregunta');
    }
}
