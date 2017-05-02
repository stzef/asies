<?php

namespace App;namespace asies\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctarea
 * @property integer $cplan
 * @property string $ntarea
 * @property integer $valor_tarea
 * @property boolean $ifhecha
 * @property string $created_at
 * @property string $updated_at
 * @property Plane $plane
 * @property Actividadestarea[] $actividadestareas
 * @property Asignaciontarea[] $asignaciontareas
 */
class Tareas extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['cplan', 'ntarea', 'valor_tarea', 'ifhecha', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plane()
    {
        return $this->belongsTo('App\Plane', 'cplan', 'cplan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadestareas()
    {
        return $this->hasMany('App\Actividadestarea', 'ctarea', 'ctarea');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asignaciontareas()
    {
        return $this->hasMany('App\Asignaciontarea', 'ctarea', 'ctarea');
    }

    public function checkUser($iduser)
    {
        $flag = false;
        if ( AsignacionTareas::where("user",$iduser)->where("ctarea",$this->ctarea)->exists() ){
            $flag = true;
        }
        return $flag;
    }
}
