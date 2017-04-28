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
    public function add_user($data,$ctarea=null)
    {
        $tarea = $this;
        if ( $ctarea ){
            $tarea = Tareas::where('ctarea', $ctarea)->first();
        }
        $dataCreataion = array('ctarea' => $tarea->ctarea , 'ctirelacion'=>$data["ctirelacion"],'user'=>$data["user"]);
        //dump($dataCreataion);exit();
        if( TareasUsuarios::where(array('ctarea' => $tarea->ctarea , 'ctirelacion'=>$data["ctirelacion"],'user'=>$data["user"]))->exists() ){
            $obj = null;
            $data = array("message"=>"El usuario ya se encuentra registrado");
        }else{
            $obj = TareasUsuarios::create($dataCreataion);
            $data = array("message"=>"El usuario se agregro exitosamente");
        }
        return array("obj"=>$obj,"data"=>$data);
    }
}
