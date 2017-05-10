<?php

namespace asies\Models;

use \DB;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cplan
 * @property integer $cestado
 * @property integer $cplanmayor
 * @property integer $ctiplan
 * @property string $nplan
 * @property integer $valor_plan
 * @property integer $valor_total
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
    protected $fillable = ['cestado', 'cplanmayor', 'ctiplan', 'nplan', 'valor_plan', 'valor_total', 'created_at', 'updated_at'];

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
    static function getArbolPlanes($json=false){
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
    static function recalcularPuntosPlanes($cplan,$puntos,$puntos_acumulativos)
    {
        $plan = Planes::where('cplan', $cplan)->first();
        $npuntos = $plan->valor_plan + $puntos;
        $npuntos_acumulativos = $npuntos + $puntos_acumulativos;
        Planes::where('cplan', $cplan)->update(["valor_plan" => $npuntos,'valor_total' => $npuntos_acumulativos ]);


        if ( $plan->cplanmayor != null){
            Planes::recalcularPuntosPlanes($plan->cplanmayor,$puntos,$puntos_acumulativos);
        }
        return null;
    }
    static function recalcularPuntos()
    {
        DB::table('planes')->update(array('valor_plan' => 0));


        $tareas = Tareas::all();

        foreach ($tareas as $tarea) {
            $puntos = 0;
            if( $tarea->ifhecha ){
                $puntos = $tarea->valor_tarea;
            }
            dump($tarea->ifhecha);
            Planes::recalcularPuntosPlanes($tarea->cplan,$puntos,$tarea->valor_tarea);
        }

        exit();

        return $planes;
    }
}
