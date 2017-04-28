<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cevidencia
 * @property integer $cactividad
 * @property string $descripcion
 * @property string $nombre
 * @property string $path
 * @property string $fregistro
 * @property string $created_at
 * @property string $updated_at
 * @property Actividade $actividade
 */
class Evidencias extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['cactividad', 'descripcion', 'nombre', 'path', 'fregistro', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividade()
    {
        return $this->belongsTo('App\Actividade', 'cactividad', 'cactividad');
    }
}
