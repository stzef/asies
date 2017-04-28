<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $ctarea
 * @property integer $ctirelacion
 * @property integer $user
 * @property integer $cactividad
 * @property string $created_at
 * @property string $updated_at
 * @property Tarea $tarea
 * @property Tirelacione $tirelacione
 * @property User $user
 * @property Actividade $actividade
 */
class AsignacionTareas extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'asignaciontareas';

    /**
     * @var array
     */
    protected $fillable = ['ctarea', 'ctirelacion', 'user', 'cactividad', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tarea()
    {
        return $this->belongsTo('App\Tarea', 'ctarea', 'ctarea');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tirelacione()
    {
        return $this->belongsTo('App\Tirelacione', 'ctirelacion', 'ctirelacion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividade()
    {
        return $this->belongsTo('App\Actividade', 'cactividad', 'cactividad');
    }
}
