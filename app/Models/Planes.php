<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

use asies\Models\Tareas;

/**
 * @property integer $cplan
 * @property integer $cplanmayor
 * @property integer $cestado
 * @property integer $ctiplan
 * @property string $nplan
 * @property integer $valor_plan
 * @property Plane $plane
 * @property Estado $estado
 * @property Tiplane $tiplane
 * @property Tarea[] $tareas
 */
class Planes extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['cplanmayor', 'cestado', 'ctiplan', 'nplan', 'valor_plan'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plane()
    {
        return $this->belongsTo('App\Plane', 'cplanmayor', 'cplan');
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
    public function tiplane()
    {
        return $this->belongsTo('App\Tiplane', 'ctiplan', 'ctiplan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tareas()
    {
        return $this->hasMany('App\Tarea', 'cplan', 'cplan');
    }

    static function getSubPlanes($cplan,$json=false)
    {
        $plan = Planes::where('cplan', $cplan)->first();
        $plan->subplanes = Planes::where('cplanmayor', $plan->cplan)->get();

        if (Tareas::where('cplan',$cplan)->first()){
            //dump("Hola");exit();
            $plan->subplanes = Tareas::where('cplan', $cplan)->get();
        }else{
            if ( count($plan->subplanes) != 0 ){
                foreach ($plan->subplanes as $subplan) {
                    $subplan->subplanes = Planes::getSubPlanes($subplan->cplan,$json);
                }
            }
        }
        if ( $json ){
            return $plan->subplanes->toArray();
        }else{
            return $plan->subplanes;
        }
    }
    static function getArbolPlanes($json=false)
    {
        $planes = Planes::where('cplanmayor', NULL)->get();
        foreach ($planes as $plan) {
            $plan->subplanes = Planes::getSubPlanes($plan->cplan,$json);
        }
        if ( $json ){
            return $planes->toArray();
        }else{
            return $planes;
        }
    }
}
