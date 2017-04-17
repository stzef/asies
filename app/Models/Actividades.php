<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cactividad
 * @property integer $cestado
 * @property integer $ctiactividad
 * @property integer $cacta
 * @property string $nactividad
 * @property string $fini
 * @property string $ffin
 * @property boolean $ifacta
 * @property boolean $ifarchivos
 * @property boolean $ifdescripcion
 * @property Estado $estado
 * @property Tiactividade $tiactividade
 * @property Acta $acta
 * @property Actividadestarea[] $actividadestareas
 * @property Evidencia[] $evidencias
 */
class Actividades extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['cestado', 'ctiactividad', 'cacta', 'nactividad', 'fini', 'ffin', 'ifacta', 'ifarchivos', 'ifdescripcion'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo('App\Estado', 'cestado', 'cestados');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiactividade()
    {
        return $this->belongsTo('App\Tiactividade', 'ctiactividad', 'ctiactividad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function acta()
    {
        return $this->belongsTo('App\Acta', 'cacta', 'idacta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadestareas()
    {
        return $this->hasMany('App\Actividadestarea', 'cactividad', 'cactividad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evidencias()
    {
        return $this->hasMany('App\Evidencia', 'cactividad', 'cactividad');
    }
}
