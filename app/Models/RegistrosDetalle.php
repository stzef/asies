<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $cplan
 * @property integer $it
 * @property string $deta
 * @property string $recurso
 * @property Registro $registro
 */
class RegistrosDetalle extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'registrosdetalle';

    /**
     * @var array
     */
    protected $fillable = ['cplan', 'it', 'deta', 'recurso'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function registro()
    {
        return $this->belongsTo('App\Models\Registro', 'cplan', 'cplan');
    }
}
