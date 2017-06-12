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
 * @property string $ncplan
 * @property integer $valor_plan
 * @property integer $valor_total
 * @property integer $cpuntuacion
 * @property string $created_at
 * @property string $updated_at
 * @property Estado $estado
 * @property Plane $plane
 * @property TiPlanes $tiplan
 * @property Puntuaciones $puntuacion
 * @property Tarea[] $tareas
 */
class Planes extends Model
{
	/**
	 * @var array
	 */
	protected $fillable = ['cestado', 'cplanmayor', 'ctiplan', 'nplan','ncplan', 'valor_plan', 'valor_total', 'cpuntuacion' , 'created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function estado(){
		return $this->belongsTo('App\Estado', 'cestado', 'cestados');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function plane(){
		return $this->belongsTo('App\Plane', 'cplanmayor', 'cplan');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function tiplan(){
		return $this->belongsTo('asies\Models\TiPlanes', 'ctiplan', 'ctiplan');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function puntuacion(){
		return $this->belongsTo('asies\Models\Puntuaciones', 'cpuntuacion', 'cpuntuacion');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function tareas(){
		return $this->hasMany('App\Tarea', 'cplan', 'cplan');
	}

	public function getActividades(){
		$actividades = \DB::table('asignaciontareas')
			->join('tareas', 'asignaciontareas.ctarea', '=', 'tareas.ctarea')
			->join('planes', 'tareas.cplan', '=', 'tareas.cplan')
			->select('asignaciontareas.cactividad')
			//->where('tareas.ifhecha', 0)
			->groupBy('cactividad')
			->get();
		$actividades = collect($actividades);
		$actividades = $actividades->map(function ($actividad) {
		 return Actividades::where("cactividad", $actividad->cactividad)->first();
		});
		//return $actividades;
		dump($actividades);exit();
	}

	public function getProdsMinimosRecursive($plan,&$prods_min){
		$subplanes = Planes::where("cplanmayor",$plan->cplan)->get();
		foreach ($subplanes as $subplan) {
			if ( $subplan->ctiplan == 4 ){
				array_push($prods_min, $subplan);
			}else{
				$this->getProdsMinimosRecursive($subplan,$prods_min);
			}
		}
	}

	public function getProdsMinimos(){
		$plan = $this;
		if ( $plan->ctiplan == 4 ){
			return [$plan];
		}else{
			$subplanes = Planes::where("cplanmayor",$plan->cplan)->get();
			//dump($subplanes);exit();

			$prods_min = array();
			foreach ($subplanes as $subplan) {
				if ( $subplan->ctiplan == 4 ){
					array_push($prods_min, $subplan);
				}else{
					$this->getProdsMinimosRecursive($subplan,$prods_min);
				}
			}
			return $prods_min;
		}
	}

	public function getActividadesGrouped(){
		$actividades = array(
			"realizadas"=>collect(),
			"retrasadas"=>collect(),
			"pendientes"=>collect(),
		);
		$actividades_hechas = \DB::table('asignaciontareas')
			->join('tareas', 'asignaciontareas.ctarea', '=', 'tareas.ctarea')
			->join('actividades', 'asignaciontareas.cactividad', '=', 'actividades.cactividad')
			->join('planes', 'planes.cplan', '=', 'tareas.cplan')
			->select('asignaciontareas.*')
			->where('actividades.ifhecha', 1)
			->where('tareas.cplan', $this->cplan)
			->groupBy('asignaciontareas.cactividad')
			->get();

		$actividades_hechas = collect($actividades_hechas);
		$actividades["realizadas"] = $actividades_hechas->map(function ($actividad) { return Actividades::where("cactividad", $actividad->cactividad)->first(); });

		$resto_actividades = \DB::table('asignaciontareas')
			->join('tareas', 'asignaciontareas.ctarea', '=', 'tareas.ctarea')
			->join('actividades', 'asignaciontareas.cactividad', '=', 'actividades.cactividad')
			->join('planes', 'planes.cplan', '=', 'tareas.cplan')
			->select('asignaciontareas.*')
			->where('actividades.ifhecha', 0)
			->where('tareas.cplan', $this->cplan)
			->groupBy('asignaciontareas.cactividad')
			->get();
			foreach ($resto_actividades as $actividad) {
				//dump($actividad);exit();
				$oa = Actividades::where("cactividad",$actividad->cactividad)->first();
				$oa->calcularDias();

				if ( $oa->dias_faltantas ){
					$actividades["pendientes"]->push($oa);
				}elseif( $oa->dias_retraso ){
					$actividades["retrasadas"]->push($oa);
				}
			}

		return collect($actividades);
	}

	static function getSubPlanes($cplan,$json=false){
		$plan = Planes::where('cplan', $cplan)->first();
		$plan->subplanes = Planes::with('tiplan')->with('puntuacion')->where('cplanmayor', $plan->cplan)->get();

		if (Tareas::where('cplan',$cplan)->first()){
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
		$planes = Planes::with('tiplan')->with('puntuacion')->where('cplanmayor', NULL)->get();
		foreach ($planes as $plan) {
			$plan->subplanes = Planes::getSubPlanes($plan->cplan,$json);
		}
		if ( $json ){
			return $planes->toArray();
		}else{
			return $planes;
		}
	}

	static function recalcularPuntosPlanes($cplan,$puntos,$puntos_acumulativos){
		$plan = Planes::where('cplan', $cplan)->first();
		$npuntos = $plan->valor_plan + $puntos;
		$npuntos_acumulativos =  $plan->valor_total + $puntos_acumulativos;//$puntos_acumulativos += $puntos_acumulativos;

		$porcentaje = (int) ( ( 100 * $npuntos) / $npuntos_acumulativos );

		//dump($porcentaje);
		$puntuacion = DB::table('puntuaciones')->where('vini', '<=', $porcentaje)->where('vfin', '>=', $porcentaje)->first();
		//dump($puntuacion);exit();


		Planes::where('cplan', $cplan)->update([
			"valor_plan" => $npuntos,
			'valor_total' => $npuntos_acumulativos,
			'cpuntuacion' => $puntuacion->cpuntuacion,
		]);

		if ( $plan->cplanmayor != null){
			Planes::recalcularPuntosPlanes($plan->cplanmayor,$puntos,$puntos_acumulativos);
		}
		return null;
	}

	static function recalcularPuntos($cmodulo=null){
		DB::table('planes')->update(array('valor_plan' => 0,'valor_total' => 0));
		$prods_min = Planes::where("ctiplan",4)->get(); # Equivalente a Model::all()
		$stpuntos = 0;
		foreach ($prods_min as $prod_min) {
			$tareas = Tareas::where("cplan",$prod_min->cplan)->orderBy("cplan")->get(); # Equivalente a Model::all()
			$spuntos = 0;
			foreach ($tareas as $tarea) {
				$puntos = 0;
				if( $tarea->ifhecha ){
					$puntos = $tarea->valor_tarea;
				}
				$spuntos += $tarea->valor_tarea;
				Planes::recalcularPuntosPlanes($tarea->cplan,$puntos,$tarea->valor_tarea);
			}
			$stpuntos += $spuntos;
		}
	}

}
