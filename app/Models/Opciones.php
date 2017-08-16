<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $copcion
 * @property string $detalle
 * @property ChecklistDeta[] $checklistdeta
 * @property OpcionesPregunta[] $opcionespregunta
 */
class Opciones extends Model
{
    protected $primaryKey = "copcion";
    /**
     * @var array
     */
    protected $fillable = ['detalle'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checklistdeta()
    {
        return $this->hasMany('asies\Models\ChecklistDeta', 'copcione', 'copcion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opcionespregunta()
    {
        return $this->hasMany('asies\Models\OpcionesPregunta', 'copcion', 'copcion');
    }
}
