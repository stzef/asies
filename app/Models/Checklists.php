<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cchecklist
 * @property integer $cactividad
 * @property string $fecha
 * @property string $nombre
 * @property Actividades $actividade
 * @property ChecklistDeta[] $checklistdeta
 * @property ChecklistPregunta[] $checklistpregunta
 */
class Checklists extends Model
{
    protected $primaryKey = "cchecklist";

    /**
     * @var array
     */
    protected $fillable = ['cactividad', 'fecha', 'nombre'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividades()
    {
        return $this->belongsTo('asies\Models\Actividades', 'cactividad', 'cactividad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checklistdeta()
    {
        return $this->hasMany('asies\Models\ChecklistDeta', 'cchecklist', 'cchecklist');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checklistpregunta()
    {
        return $this->hasMany('asies\Models\ChecklistPregunta', 'cchecklist', 'cchecklist');
    }
}
