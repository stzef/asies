<?php

namespace asies\Models;
use asies\User;

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
    public function add_task_user($data,$cactividad=null)
    {
        $actividad = $this;
        if ( $cactividad ){
            $actividad = Tareas::where('cactividad', $cactividad)->first();
        }
        $dataCreataion = array('cactividad' => $actividad->cactividad , 'ctirelacion'=>$data["ctirelacion"],'ctarea'=>$data["ctarea"],'user'=>$data["user"]);
        //dump($dataCreataion);exit();
        if( AsignacionTareas::where(array('cactividad' => $actividad->cactividad , 'ctirelacion'=>$data["ctirelacion"],'ctarea'=>$data["ctarea"],'user'=>$data["user"]))->exists() ){
            $obj = null;
            $data = array("message"=>"El usuario ya se encuentra registrado");
        }else{
            $obj = AsignacionTareas::create($dataCreataion);
            $data = array("message"=>"El usuario se agregro exitosamente");
        }
        return array("obj"=>$obj,"data"=>$data);
    }
    public function evidencias()
    {
        return $this->hasMany('App\Evidencia', 'cactividad', 'cactividad');
    }
    public function getTareas($iduser=null)
    {
        if ( $iduser ){
            $tareas = \DB::table('asignaciontareas')
                ->join('users', 'asignaciontareas.user', '=', 'users.id')
                ->join('tareas', 'asignaciontareas.ctarea', '=', 'tareas.ctarea')
                ->select('tareas.*')
                ->where('asignaciontareas.cactividad', $this->cactividad)
                ->where('users.id', $iduser)
                ->get();
        }else{
            $tareas = \DB::table('asignaciontareas')
                ->join('tareas', 'asignaciontareas.ctarea', '=', 'tareas.ctarea')
                ->select('tareas.*')
                ->where('asignaciontareas.cactividad', $this->cactividad)
                ->get();
        }
        return $tareas;
    }
    public function getAsignacion()
    {
            $asignaciones = \DB::table('asignaciontareas')
                ->join('users', 'asignaciontareas.user', '=', 'users.id')
                ->join('tareas', 'asignaciontareas.ctarea', '=', 'tareas.ctarea')
                ->select('asignaciontareas.*')
                ->where('asignaciontareas.cactividad', $this->cactividad)
                //->where('users.id', $iduser)
                ->get();
                foreach ($asignaciones as $asignacion) {
                    $asignacion->tarea = Tareas::where('ctarea',$asignacion->ctarea)->first();
                    $asignacion->actividad =Actividades::where('cactividad',$asignacion->cactividad)->first();
                    $asignacion->relaacion = TiRelaciones::where('ctirelacion',$asignacion->ctirelacion)->first();
                    $asignacion->usuario = User::where('id',$asignacion->user)->first();
                    # code...
                }
        return $asignaciones;
    }
    public function getEvidencias()
    {
        $evidencias = Evidencias::where('cactividad', $this->cactividad)->get();
        return $evidencias;
    }
}
