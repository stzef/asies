<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ctiusuario
 * @property string $ntiusuario
 */
class Tiusuarios extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['ntiusuario'];

}
