<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $cactividad
 * @property string $fecha
 * @property string $nombre
 * @property Actividade $actividade
 * @property ChecklistDeta[] $checklistdetas
 */
class Checklists extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['cactividad', 'fecha', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividad()
    {
        return $this->belongsTo('asies\Models\Actividades', 'cactividad', 'cactividad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checklistdeta()
    {
        return $this->hasMany('asies\Models\ChecklistDeta', 'cchecklist');
    }
}
