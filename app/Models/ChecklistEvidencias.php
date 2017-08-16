<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cevidencia
 * @property integer $cchecklistdeta
 * @property string $descripcion
 * @property string $nombre
 * @property string $path
 * @property string $fregistro
 * @property ChecklistDeta $checklistdeta
 */
class ChecklistEvidencias extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'checklistevidencias';

    /**
     * @var array
     */
    protected $fillable = ['cchecklistdeta', 'descripcion', 'nombre', 'path', 'fregistro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function checklistdeta()
    {
        return $this->belongsTo('asies\Models\ChecklistDeta', 'cchecklistdeta');
    }
}
