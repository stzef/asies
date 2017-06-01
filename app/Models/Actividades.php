<?php

namespace asies\Models;
use asies\User;
use \Auth;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
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
        return $this->belongsTo('asies\Models\Actas', 'cacta', 'idacta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo('asies\Models\Estado', 'cestado', 'cestados');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tiactividade()
    {
        return $this->belongsTo('asies\Models\Tiactividade', 'ctiactividad', 'ctiactividad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividadestareas()
    {
        return $this->hasMany('asies\Models\Actividadestarea', 'cactividad', 'cactividad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asignaciontareas()
    {
        return $this->hasMany('asies\Models\Asignaciontarea', 'cactividad', 'cactividad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function add_task_user($data,$cactividad=null)
    {
        $user = Auth::user();
        $actividad = $this;
        if ( $cactividad ){
            $actividad = Tareas::where('cactividad', $cactividad)->first();
        }
        $dataCreataion = array('cactividad' => $actividad->cactividad , 'ctirelacion'=>$data["ctirelacion"],'ctarea'=>$data["ctarea"],'user'=>$data["user"]);
        if( AsignacionTareas::where(array('cactividad' => $actividad->cactividad ,'ctarea'=>$data["ctarea"],'user'=>$data["user"]))->exists() ){
            AsignacionTareas::where(array('cactividad' => $actividad->cactividad ,'ctarea'=>$data["ctarea"],'user'=>$data["user"]))->update(['ctirelacion'=>$data["ctirelacion"]]);
            $obj = AsignacionTareas::where(array('cactividad' => $actividad->cactividad ,'ctarea'=>$data["ctarea"],'user'=>$data["user"]))->first();
            Log::info('responsable editado en tarea,',['user (edito)' => $user->id, '' => $actividad->cactividad ,'tarea' => $data['ctarea'] , 'user (responsable)' =>$data["user"]]);
            $data = array("message"=>"Se edito la <b>Responsabilidad</b> del Usuario.");
        }else{
            $obj = AsignacionTareas::create($dataCreataion);
            Log::info('responsable creado en tarea,',['user (edito)' => $user->id, 'actividad' => $obj->cactividad ,'tarea' => $obj->ctarea , 'user (respo)' =>$obj->user]);
            $data = array("message"=>"El usuario se agregro exitosamente");
        }
        return array("obj"=>$obj,"data"=>$data);
    }
    public function evidencias()
    {
        return $this->hasMany('asies\Models\Evidencia', 'cactividad', 'cactividad');
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
                $asignacion->relacion = TiRelaciones::where('ctirelacion',$asignacion->ctirelacion)->first();
                $asignacion->usuario = User::where('id',$asignacion->user)->first();
            }
        return $asignaciones;
    }
    public function calcularDias(){
        $now = Carbon::now();
        $this->dias_faltantas = 0;
        $this->dias_retraso = 0;
        $factividad = Carbon::parse($this->fini);
        if( $factividad >= $now ) {
            $this->dias_faltantas = $factividad->diffInDays($now);
        }else{
            $this->dias_retraso = $factividad->diffInDays($now);
        }
    }
    public function getEmails()
    {
        $emails = array();
        $asignaciones = $this->getAsignacion();
        foreach ($asignaciones as $asignacion) {
            array_push($emails, $asignacion->usuario->email);
        }
        $emails = array_unique($emails);
        return $emails;
    }
    public function getEvidencias()
    {
        $evidencias = Evidencias::where('cactividad', $this->cactividad)->get();

        $ext_img = array("ani","bmp","cal","fax","gif","img","jbg","jpe","jpe","jpg","mac","pbm","pcd","pcx","pct","pgm","png","ppm","psd","ras","tga","tif","wmf");
        foreach ($evidencias as $evidencia) {
            $ext = pathinfo($evidencia->path, PATHINFO_EXTENSION);
            if ( in_array($ext, $ext_img) ){
                $evidencia->previewimg = $evidencia->path;
            }else{
                $evidencia->previewimg = "/evidencias/generic-file.png";
            }
        }
        return $evidencias;
    }
}
