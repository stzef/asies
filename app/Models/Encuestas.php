<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;
use \Auth;

/**
 * @property Encuestapreguntas[] $encuestapreguntas
 * @property Historialencuestas[] $historialencuestas
 * @property int $cencuesta
 * @property string $nombre
 * @property string $descripcion
 * @property string $fecha
 * @property string $created_at
 * @property string $updated_at
 */
class Encuestas extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'cencuesta';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'descripcion', 'fecha', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function encuestapreguntas()
    {
        return $this->hasMany('asies\Models\EncuestaPreguntas', 'cencuesta', 'cencuesta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historialencuestas()
    {
        return $this->hasMany('asies\Models\HistorialEncuestas', 'cencuesta', 'cencuesta');
    }
}
