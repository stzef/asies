<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cplan
 * @property integer $cestado
 * @property integer $cplanmayor
 * @property integer $ctiplan
 * @property string $nplan
 * @property integer $valor_plan
 * @property string $created_at
 * @property string $updated_at
 * @property Estado $estado
 * @property Plane $plane
 * @property TiPlanes $tiplan
 * @property Tarea[] $tareas
 */
class Planes extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['cestado', 'cplanmayor', 'ctiplan', 'nplan', 'valor_plan', 'created_at', 'updated_at'];

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
    public function plane()
    {
        return $this->belongsTo('App\Plane', 'cplanmayor', 'cplan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiplan()
    {
        return $this->belongsTo('asies\Models\TiPlanes', 'ctiplan', 'ctiplan');
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
        $plan->subplanes = Planes::with('tiplan')->where('cplanmayor', $plan->cplan)->get();

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
        $planes = Planes::with('tiplan')->where('cplanmayor', NULL)->get();
        foreach ($planes as $plan) {
            $plan->subplanes = Planes::getSubPlanes($plan->cplan,$json);
        }
            //dump($planes->toArray()[0]["tiplan"]);exit();
        if ( $json ){
            return $planes->toArray();
        }else{
            return $planes;
        }
    }
}
