<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cpregunta
 * @property integer $ctipregunta
 * @property string $enunciado
 * @property TiPreguntas $tipregunta
 * @property ChecklistDeta[] $checklistdeta
 * @property ChecklistPreguntas[] $checklistpreguntas
 * @property OpcionesPregunta[] $opcionespregunta
 */
class Preguntas extends Model
{
    protected $primaryKey = "cpregunta";
    /**
     * @var array
     */
    protected $fillable = ['ctipregunta', 'enunciado'];

    public function isOpenQuestion()
    {
        if ( $this->ctipregunta == 1 ){
            return true;
        }
        return false;
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipregunta()
    {
        return $this->belongsTo('asies\Models\TiPreguntas', 'ctipregunta', 'ctipregunta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checklistdeta()
    {
        return $this->hasMany('asies\Models\ChecklistDeta', 'cpregunta', 'cpregunta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checklistpreguntas()
    {
        return $this->hasMany('asies\Models\ChecklistPreguntas', 'cpregunta', 'cpregunta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opcionespregunta()
    {
        return $this->hasMany('asies\Models\OpcionesPregunta', 'cpregunta', 'cpregunta');
    }
}
