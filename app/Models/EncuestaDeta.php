<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property HistorialEncuestas $historialencuestas
 * @property Opciones $opcion
 * @property Preguntas $pregunta
 * @property int $id
 * @property int $chencuesta
 * @property int $copcion
 * @property int $cpregunta
 * @property string $respuesta
 * @property string $created_at
 * @property string $updated_at
 */
class EncuestaDeta extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'encuestadeta';

    /**
     * @var array
     */
    protected $fillable = ['chencuesta', 'copcion', 'cpregunta', 'respuesta', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function historialencuestas()
    {
        return $this->belongsTo('asies\Models\Historialencuestas', 'chencuesta', 'chencuesta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opcion()
    {
        return $this->belongsTo('asies\Models\Opciones', 'copcion', 'copcion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pregunta()
    {
        return $this->belongsTo('asies\Models\Preguntas', 'cpregunta', 'cpregunta');
    }
}
