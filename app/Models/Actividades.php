<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cactividad
 * @property integer $cacta
 * @property integer $cestado
 * @property integer $ctiactividad
 * @property string $nactividad
 * @property string $descripcion
 * @property string $fini
 * @property string $ffin
 * @property boolean $ifacta
 * @property boolean $ifarchivos
 * @property string $created_at
 * @property string $updated_at
 * @property Acta $acta
 * @property Estado $estado
 * @property Tiactividade $tiactividade
 * @property Actividadestarea[] $actividadestareas
 * @property Asignaciontarea[] $asignaciontareas
 * @property Evidencia[] $evidencias
 */
class Actividades extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['cacta', 'cestado', 'ctiactividad', 'nactividad', 'descripcion', 'fini', 'ffin', 'ifacta', 'ifarchivos', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function acta()
    {
        return $this->belongsTo('App\Acta', 'cacta', 'idacta');
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadestareas()
    {
        return $this->hasMany('App\Actividadestarea', 'cactividad', 'cactividad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asignaciontareas()
    {
        return $this->hasMany('App\Asignaciontarea', 'cactividad', 'cactividad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function evidencias()
    {
        return $this->hasMany('App\Evidencia', 'cactividad', 'cactividad');
    }
    public function getTareas()
    {
        $ctareas = ActividadesTareas::where('cactividad', $this->cactividad)->get();
        $tareas = array();
        foreach ($ctareas as $data) {
            array_push( $tareas, Tareas::where("ctarea",$data["ctarea"])->first() );
        }
        return $tareas;
    }
    public function getEvidencias()
    {
        $evidencias = Evidencias::where('cactividad', $this->cactividad)->get();
        return $evidencias;
    }
}
