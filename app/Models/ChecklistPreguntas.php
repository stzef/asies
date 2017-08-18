<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $cchecklist
 * @property integer $cpregunta
 * @property integer $orden
 * @property Checklists $checklist
 * @property Preguntas $pregunta
 */
class ChecklistPreguntas extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'checklistpreguntas';

    /**
     * @var array
     */
    protected $fillable = ['cchecklist', 'cpregunta', 'orden'];

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
}
