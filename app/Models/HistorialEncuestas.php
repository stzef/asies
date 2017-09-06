<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;
use \Auth;

/**
 * @property Encuestas $encuesta
 * @property User $usercontesto
 * @property EncuestaDeta[] $encuestadetas
 * @property int $chencuesta
 * @property int $cencuesta
 * @property int $user
 * @property string $fecha
 * @property boolean $ifhecha
 * @property string $created_at
 * @property string $updated_at
 */
class HistorialEncuestas extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'historialencuestas';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'chencuesta';

    /**
     * @var array
     */
    protected $fillable = ['cencuesta', 'user', 'fecha','ifhecha', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function encuesta()
    {
        return $this->belongsTo('asies\Models\Encuestas', 'cencuesta', 'cencuesta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usercontesto()
    {
        return $this->belongsTo('asies\User', 'user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function encuestadetas()
    {
        return $this->hasMany('asies\Models\EncuestaDeta', 'chencuesta', 'chencuesta');
    }

    public function updateState(){
        $response = array( "message" => "", "ifhecha" => null );

        $total_preguntas = EncuestaPreguntas::where("cencuesta",$this->cencuesta)->count();
        $preguntas_respondidas = EncuestaDeta::where("chencuesta",$this->chencuesta)->count();

        if ( $total_preguntas == $preguntas_respondidas ){
            $ifhecha = 1;
            $response["message"] = "La encuesta se Completo";
        }else{
            $ifhecha = 0;
            $response["message"] = "Aun falta preguntas de la encuesta";
        }

        HistorialEncuestas::where('chencuesta', $this->chencuesta)->update(['ifhecha' => $ifhecha]);
        $response["ifhecha"] = $ifhecha;


        return $response;
    }

    public function getEncuesta(){

        $encuesta = null;
        $cencuesta = $this->cencuesta;
        $user = Auth::user();
        $encuesta = Encuestas::where("cencuesta",$cencuesta)->first();
        $encuestaUser = HistorialEncuestas::where("cencuesta",$cencuesta)->where("user",$user->id)->first();
        if ( $encuestaUser ){
            $encuesta->his = $encuestaUser;
            $encuesta->ifhecha = $encuestaUser->ifhecha;

            $cpreguntas = EncuestaPreguntas::select('cpregunta')->where("cencuesta",$encuesta->cencuesta)->orderBy("orden")->get();
            $encuesta->preguntas = Preguntas::whereIn('cpregunta', $cpreguntas)->orderBy("ctipregunta")->get();
            $encuesta->cantidad_preguntas = count($encuesta->preguntas);

            foreach ($encuesta->preguntas as $pregunta) {
                $copciones = OpcionesPregunta::select("copcion")->where("ctipregunta",$pregunta->ctipregunta)->get();
                $pregunta->opciones = Opciones::whereIn("copcion",$copciones)->get();
                $pregunta->respuesta = EncuestaDeta::where("chencuesta",$encuestaUser->chencuesta)->where("cpregunta",$pregunta->cpregunta)->first();
            }
            $encuesta = $encuesta;

            /*
            # Estadisticas
            $tipreguntas = TiPreguntas::all();
            $estadisticas = [];
            foreach ($tipreguntas as $tipregunta) {
                $cpreguntas = encuestaPreguntas::select('cpregunta')->where("cencuesta",$encuesta->cencuesta)->orderBy("orden")->get();
                $total_preguntas = Preguntas::whereIn('cpregunta', $cpreguntas)->where("ctipregunta",$tipregunta->ctipregunta)->count();

                $opcionespregunta = OpcionesPregunta::where("ctipregunta",$tipregunta->ctipregunta)->get();

                $data = [];

                $data["total"] = $total_preguntas;
                $data["tipregunta"] = $tipregunta;

                $opciones = [];
                foreach ($opcionespregunta as $opcion) {
                    $data2 = [
                        "opcion" => $opcion->opcion,
                        "cantidad" => encuestaDeta::where("cencuesta",$encuesta->cencuesta)->where("copcion",$opcion->copcion)->count(),
                    ];
                    array_push($opciones, $data2);
                }

                $data["opciones"] = $opciones;
                array_push($estadisticas, $data);
            }
            $encuesta->estadisticas = $estadisticas;
            */
        }
        return $encuesta;
    }
}
