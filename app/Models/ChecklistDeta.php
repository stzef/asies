<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $cchecklist
 * @property integer $cpregunta
 * @property integer $copcion
 * @property string $respuesta
 * @property string $anotaciones
 * @property Checklists $checklist
 * @property Preguntas $pregunta
 * @property Opciones $opcion
 */
class ChecklistDeta extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'checklistdeta';

    /**
     * @var array
     */
    protected $fillable = ['cchecklist', 'cpregunta', 'copcion', 'respuesta', 'anotaciones'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function checklist()
    {
        return $this->belongsTo('asies\Models\Checklists', 'cchecklist', 'cchecklist');
    }

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
