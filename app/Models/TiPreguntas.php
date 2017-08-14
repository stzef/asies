<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $detalle
 * @property Preguntas[] $preguntas
 */
class TiPreguntas extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipreguntas';

    /**
     * @var array
     */
    protected $fillable = ['detalle'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function preguntas()
    {
        return $this->hasMany('asies\Models\Preguntas', 'ctipregunta');
    }
}
