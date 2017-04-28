<?php

namespace asies;

use Illuminate\Foundation\Auth\User as Authenticatable;
use asies\Models\TareasUsuarios;
use asies\Models\Tareas;
use asies\Models\Actividades;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        #'name', 'email', 'password','cpersona',
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function persona()
    {
        return $this->hasOne('asies\Models\Personas','cpersona','cpersona');
        #return $this->belongsTo('asies\Models\Personas','cpersona','cpersona');

    }

    public function getTareas()
    {
        $tareas = \DB::table('asignaciontareas')
            ->join('users', 'asignaciontareas.user', '=', 'users.id')
            ->join('tareas', 'asignaciontareas.ctarea', '=', 'tareas.ctarea')
            ->select('tareas.*')
            ->where('users.id', $this->id)
            //->groupBy('actividadestareas.cactividad')
            ->get();
        return $tareas;
    }

    public function getActividades(){
        $TIRELACION_RESPONSABLE = \Config::get("app.CTE")["TIRELACION_RESPONSABLE"];

        $actividades = \DB::table('asignaciontareas')
            ->join('users', 'asignaciontareas.user', '=', 'users.id')
            ->join('actividades', 'asignaciontareas.cactividad', '=', 'actividades.cactividad')
            ->select('actividades.*')
            ->where('users.id', $this->id)
            //->groupBy('actividadestareas.cactividad')
            ->get();

        return $actividades;
    }

}
