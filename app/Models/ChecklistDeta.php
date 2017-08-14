<?php

namespace asies\App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $cchecklist
 * @property integer $cpregunta
 * @property integer $crespuesta
 * @property Checklists $checklist
 * @property Preguntas $pregunta
 * @property Respuestas $respuesta
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
    protected $fillable = ['cchecklist', 'cpregunta', 'crespuesta'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function checklist()
    {
        return $this->belongsTo('asies\Models\Checklists', 'cchecklist');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pregunta()
    {
        return $this->belongsTo('asies\Models\Preguntas', 'cpregunta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function respuesta()
    {
        return $this->belongsTo('asies\Models\Respuestas', 'crespuesta');
    }
}
