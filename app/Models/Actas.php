<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

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
 * @property User $user
 * @property User $user
 * @property User $user
 * @property Actasasistente[] $actasasistentes
 * @property Actividade[] $actividades
 */
class Actas extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_elaboro', 'user_reviso', 'user_aprobo', 'numeroacta', 'objetivos', 'fhini', 'fhfin', 'ordendeldia', 'compromisos', 'pendientes', 'sefirma', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_elaboro');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_reviso');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_aprobo');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actasasistentes()
    {
        return $this->hasMany('App\Actasasistente', 'cacta', 'idacta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function actividades()
    {
        return $this->hasMany('App\Actividade', 'cacta', 'idacta');
    }
    public function genCode()
    {
        $empresa = "EMP";
        $date = date('d m y');
        $last = $this->last();
        if($last->numeroacta)
        {
            $number = substr($last->numeroacta, -8);
            $number += 1; 
        }else
        {
            $number = "00000001";
        }
        $numacta = $empresa."-".$date."-".$number;
        return $numacta;

    }
}
