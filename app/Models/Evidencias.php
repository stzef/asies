<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cevidencia
 * @property integer $cactividad
 * @property string $path
 * @property string $fregistro
 * @property Actividade $actividade
 */
class Evidencias extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['cactividad', 'path', 'fregistro'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividade()
    {
        return $this->belongsTo('App\Actividade', 'cactividad', 'cactividad');
    }
}
