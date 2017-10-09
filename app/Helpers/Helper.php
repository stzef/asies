<?php

namespace asies\Helpers;

class Helper
{

    public static function output($type, $planes, $info)
    {
        $string = "<ul>";
        foreach ($planes as $i => $plan) {
            $string .= "<li>";
            if ( $plan->tiplan ){
                $string .= "<img src='{$plan->tiplan->icono}' alt='' width='15px' heigth='15px' />";
            }
            $string .= "<span>$plan->nplan</span>";
            if (count($plan->subplanes)) {
                $string .= self::output($type, $plan->subplanes, $info);
            }

            if ( $plan->tareas ){
                $string .= "<ul>";
                foreach( $plan->tareas as $tarea ){

                    $string.= "<li data-ctiplan='5'>";
                    $string.= "<img src='vendor/jstree/img/task.png' alt='' width='15px' heigth='15px' />";
                    $string.= "<span>$tarea->ntarea</span>";

                    $string .= "<ul>";

                    $asignaciones = [];
                    if ( $type == "general" ){
                        $asignaciones = $tarea->asignacion;
                    }else if ( $type == "date" ){
                        $asignaciones = $tarea->asignacionBetween($info["fini"],$info["ffin"]);
                    }else if ( $type == "user" ){
                        $asignaciones = $tarea->asignacionByUser($info["user"]);
                    }

                    foreach( $asignaciones as $asignacion ){

                        $ok = false;
                        $class = "tarea no_ok";
                        $text = "&#10008;";
                        if ( $asignacion->ifhecha == "1" ) {
                            $ok = true;
                            $class = "tarea ok";
                            $text = "&#10003;";
                        }

                        $string .= "<li data-ctiplan='asignacion'>";
                        $string .= "<span class='$class' >( $text )</span>";
                        $string .= "<span>{$asignacion->actividad->nactividad}</span>";
                        $string .= "</li>";
                    }
                    $string .= "</ul>";
                    $string.= "</li>";
                }
                $string .= "</ul>";
            }
            
            $string .= "</li>";

        }
        $string .= "</ul>";
        // dump($string);exit();
        return $string;

    }
}
