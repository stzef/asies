<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctipregunta
 * @property string $detalle
 * @property Preguntas[] $preguntas
 */
class TiPreguntas extends Model
{
    protected $primaryKey = "ctipregunta";
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
        return $this->hasMany('asies\Models\Preguntas', 'ctipregunta', 'ctipregunta');
    }
}
