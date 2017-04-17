<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctiplan
 * @property string $ntiplan
 * @property integer $nivel
 * @property string $icono
 * @property Plane[] $planes
 */
class TiPlanes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tiplanes';

    /**
     * @var array
     */
    protected $fillable = ['ntiplan', 'nivel', 'icono'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planes()
    {
        return $this->hasMany('App\Plane', 'ctiplan', 'ctiplan');
    }
}
