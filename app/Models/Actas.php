<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;
use asies\User;

/**
 * @property integer $idacta
 * @property integer $user_elaboro
 * @property integer $user_reviso
 * @property integer $user_aprobo
 * @property string $numeroacta
 * @property string $objetivos
 * @property string $fhini
 * @property string $fhfin
 * @property string $ordendeldia
 * @property string $compromisos
 * @property string $pendientes
 * @property string $sefirma
 * @property string $created_at
 * @property string $updated_at
 * @property User $elaboro
 * @property User $reviso
 * @property User $aprobo
 * @property Actasasistentes[] $actasasistentes
 * @property Actividades[] $actividades
 */
class Actas extends Model
{
	protected $primaryKey = "idacta";

	/**
	 * @var array
	 */
	protected $fillable = ['user_elaboro', 'user_reviso', 'user_aprobo', 'numeroacta', 'objetivos', 'fhini', 'fhfin', 'ordendeldia', 'compromisos', 'pendientes', 'sefirma', 'created_at', 'updated_at'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function elaboro(){
		return $this->belongsTo('asies\User', 'user_elaboro', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function reviso(){
		return $this->belongsTo('asies\User', 'user_reviso', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function aprobo(){
		return $this->belongsTo('asies\User', 'user_aprobo', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function actasasistentes(){
		return $this->hasMany('asies\Models\ActasAsistentes', 'cacta', 'idacta');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function actividades(){
		return $this->hasMany('asies\Models\Actividades', 'cacta', 'idacta');
	}

	static function genCode(){

		$empresa = env("PREFJIFO_APP","");
		$date = date('Ymd');
		$last = Actas::all()->last();
		if($last)
		{
			$number = (int)substr($last->numeroacta, -8);
			$number += 1;
			$number = sprintf("%08d", $number);
		}else
		{
			$number = "00000001";
		}
		$numacta = $empresa."-".$date."-".$number;
		return $numacta;
	}

	public function getAsistentes($cacta=null){
		$acta = $this;
		if ( $cacta ){
			$acta = Actas::where("cacta",$cacta)->first();
		}
		$asistentes = \DB::table('asignaciontareas')
			->join('actasasistentes', 'asignaciontareas.user', '=', 'actasasistentes.user')
			->select('asignaciontareas.*')
			->where('actasasistentes.cacta', $acta->idacta)
			->groupBy("asignaciontareas.user")
			->get();
		foreach ($asistentes as $asistente) {
			$asistente->tarea = Tareas::where('ctarea',$asistente->ctarea)->first();
			$asistente->actividad =Actividades::where('cactividad',$asistente->cactividad)->first();
			$asistente->relacion = TiRelaciones::where('ctirelacion',$asistente->ctirelacion)->first();
			$asistente->usuario = User::where('id',$asistente->user)->first();
		}
		return $asistentes;
	}

	public function getActividad(){
		$acta = $this;
		$actividad = Actividades::where("cacta",$acta->idacta)->first();
		return $actividad;
	}
}
