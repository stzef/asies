<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cplan
 * @property integer $cestado
 * @property integer $cplanmayor
 * @property string $nplan
 * @property boolean $ifacta
 * @property boolean $ifarchivos
 * @property boolean $iftexto
 * @property boolean $iffechaini
 * @property boolean $iffechafin
 * @property Estado $estado
 * @property Plane $plane
 * @property Planesusuario[] $planesusuarios
 * @property Registro[] $registros
 */
class Planes extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['cestado', 'cplanmayor', 'nplan', 'ifacta', 'ifarchivos', 'iftexto', 'iffechaini', 'iffechafin'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo('asies\Models\Estados', 'cestado', 'cestados');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plane()
    {
        return $this->belongsTo('asies\Models\Plane', 'cplanmayor', 'cplan');
    }

    static function getSubPlanes($cplan,$json=false)
    {
        $plan = Planes::where('cplan', $cplan)->first();

        $plan->subplanes = Planes::where('cplanmayor', $plan->cplan)->get();
        if ( count($plan->subplanes) != 0 ){
            foreach ($plan->subplanes as $subplan) {
                $subplan->subplanes = Planes::getSubPlanes($subplan->cplan,$json);
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function planesusuarios()
    {
        return $this->hasMany('asies\Models\Planesusuario', 'cplan', 'cplan');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function registros()
    {
        return $this->hasMany('asies\Models\Registro', 'cplan', 'cplan');
    }
}
