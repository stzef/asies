<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $ctipregunta
 * @property string $enunciado
 * @property Tipreguntas $tipregunta
 * @property ChecklistDeta[] $checklistdetas
 * @property OpcionesPregunta[] $opcionespregunta
 */
class Preguntas extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['ctipregunta', 'enunciado'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipregunta()
    {
        return $this->belongsTo('asies\Models\Tipreguntas', 'ctipregunta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checklistdeta()
    {
        return $this->hasMany('asies\Models\ChecklistDeta', 'cpregunta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opcionespregunta()
    {
        return $this->hasMany('asies\Models\OpcionesPregunta', 'cpregunta');
    }
}
