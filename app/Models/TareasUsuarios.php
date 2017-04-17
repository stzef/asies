<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $ctarea
 * @property integer $user
 * @property integer $ctirelacion
 * @property Tarea $tarea
 * @property User $user
 * @property Tirelacion $tirelacion
 */
class TareasUsuarios extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tareasusuarios';

    /**
     * @var array
     */
    protected $fillable = ['ctarea', 'user', 'ctirelacion'];

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
    public function user()
    {
        return $this->belongsTo('App\User', 'user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tirelacion()
    {
        return $this->belongsTo('App\Tirelacion', 'ctirelacion', 'ctirelacion');
    }
}
