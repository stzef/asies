<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $cchecklist
 * @property integer $cactividad
 * @property string $fecha
 * @property string $nombre
 * @property boolean $ifhecha
 * @property Actividades $actividad
 * @property ChecklistDeta[] $checklistdeta
 * @property ChecklistPregunta[] $checklistpregunta
 */
class Checklists extends Model
{
    protected $primaryKey = "cchecklist";

    /**
     * @var array
     */
    protected $fillable = ['cactividad', 'fecha', 'nombre', 'ifhecha'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actividades()
    {
        return $this->belongsTo('asies\Models\Actividades', 'cactividad', 'cactividad');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checklistdeta()
    {
        return $this->hasMany('asies\Models\ChecklistDeta', 'cchecklist', 'cchecklist');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checklistpregunta()
    {
        return $this->hasMany('asies\Models\ChecklistPreguntas', 'cchecklist', 'cchecklist');
    }
    public function updateState(){
        $response = array( "message" => "", "ifhecha" => null );

        $total_preguntas = ChecklistPreguntas::where("cchecklist",$this->cchecklist)->count();
        $preguntas_respondidas = ChecklistDeta::where("cchecklist",$this->cchecklist)->count();

        if ( $total_preguntas == $preguntas_respondidas ){
            $ifhecha = 1;
            $response["message"] = "El checklist se Completo";
        }else{
            $ifhecha = 0;
            $response["message"] = "Aun falta pregntas de checklist";
        }

        Checklists::where('cchecklist', $this->cchecklist)->update(['ifhecha' => $ifhecha]);
        $response["ifhecha"] = $ifhecha;


        return $response;
    }
}
