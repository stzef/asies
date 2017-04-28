<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $cacta
 * @property integer $user
 * @property string $created_at
 * @property string $updated_at
 * @property Acta $acta
 * @property User $user
 */
class ActasAsistentes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'actasasistentes';

    /**
     * @var array
     */
    protected $fillable = ['cacta', 'user', 'created_at', 'updated_at'];

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
    public function user()
    {
        return $this->belongsTo('App\User', 'user');
    }
}
