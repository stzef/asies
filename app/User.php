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

    public function getTareas()
    {
        $ctareas = TareasUsuarios::where('user', $this->id)->get();
        $tareas = array();
        foreach ($ctareas as $data) {
            array_push( $tareas, Tareas::where("ctarea",$data["ctarea"])->first() );
        }
        return $tareas;
    }

    public function getActividades(){
        $actividades = Actividades::all();
        return $actividades;
    }

}
