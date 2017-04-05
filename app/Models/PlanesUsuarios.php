<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $cplan
 * @property integer $ctirelacion
 * @property integer $usuario
 * @property Plane $plane
 * @property Tirelacion $tirelacion
 * @property User $user
 */
class PlanesUsuarios extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'planesusuarios';

    /**
     * @var array
     */
    protected $fillable = ['cplan', 'ctirelacion', 'usuario'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plane()
    {
        return $this->belongsTo('App\Models\Plane', 'cplan', 'cplan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tirelacion()
    {
        return $this->belongsTo('App\Models\Tirelacion', 'ctirelacion', 'ctirelacion');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'usuario');
    }
}
