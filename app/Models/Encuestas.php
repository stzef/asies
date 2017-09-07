<?php

namespace asies\Models;

use Illuminate\Database\Eloquent\Model;
use \Auth;

/**
 * @property Encuestapreguntas[] $encuestapreguntas
 * @property Historialencuestas[] $historialencuestas
 * @property int $cencuesta
 * @property string $nombre
 * @property string $descripcion
 * @property string $fecha
 * @property string $created_at
 * @property string $updated_at
 */
class Encuestas extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'cencuesta';

    /**
     * @var array
     */
    protected $fillable = ['nombre', 'descripcion', 'fecha', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function encuestapreguntas()
    {
        return $this->hasMany('asies\Models\EncuestaPreguntas', 'cencuesta', 'cencuesta');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historialencuestas()
    {
        return $this->hasMany('asies\Models\HistorialEncuestas', 'cencuesta', 'cencuesta');
    }

    public function getHistory($fecha)
    {
        $history = new \stdClass;
        $history->items = HistorialEncuestas::where("cencuesta",$this->cencuesta)->where("fecha",$fecha)->get();

        # Estadisticas
        $tipreguntas = TiPreguntas::all();
        $estadisticas = [];
        foreach ($tipreguntas as $tipregunta) {
            foreach ($history->items as $item_history) {
                $cpreguntas = EncuestaPreguntas::select('cpregunta')->where("cencuesta",$this->cencuesta)->orderBy("orden")->get();
                $total_preguntas = Preguntas::whereIn('cpregunta', $cpreguntas)->where("ctipregunta",$tipregunta->ctipregunta)->count();

                $opcionespregunta = OpcionesPregunta::where("ctipregunta",$tipregunta->ctipregunta)->get();

                $data = [];

                $data["total"] = $total_preguntas;
                $data["tipregunta"] = $tipregunta;

                $opciones = [];
                foreach ($opcionespregunta as $opcion) {
                    $data2 = [
                        "opcion" => $opcion->opcion,
                        "cantidad" => EncuestaDeta::where("chencuesta",$item_history->chencuesta)->where("copcion",$opcion->copcion)->count(),
                    ];
                    array_push($opciones, $data2);
                }

                $data["opciones"] = $opciones;
                array_push($estadisticas, $data);
            }
        }
        $history->estadisticas = $estadisticas;

        return $history;
    }
}
