<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $copcion
 * @property string $respuesta
 * @property Opciones $opcion
 * @property ChecklistDeta[] $checklistdeta
 */
class Respuestas extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['copcion', 'respuesta'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function opcion()
    {
        return $this->belongsTo('asies\Models\Opciones', 'copcion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checklistdeta()
    {
        return $this->hasMany('asies\Models\ChecklistDeta', 'crespuesta');
    }
}
