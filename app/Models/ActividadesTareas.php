<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $cactividad
 * @property integer $ctarea
 * @property Actividade $actividade
 * @property Tarea $tarea
 */
class ActividadesTareas extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'actividadestareas';

    /**
     * @var array
     */
    protected $fillable = ['cactividad', 'ctarea'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividade()
    {
        return $this->belongsTo('App\Actividade', 'cactividad', 'cactividad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tarea()
    {
        return $this->belongsTo('App\Tarea', 'ctarea', 'ctarea');
    }
}
