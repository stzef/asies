<?php

namespace asies\Helpers;

class Helper
{

    public static function output($type, $planes, $info)
    {

        $string = "<ul>";
        foreach ($planes as $i => $plan) {
            $string .= "<li>";
            $tiplan = $plan->tiplan;
            if ( $tiplan ){
                $string .= "<img src='{$tiplan->icono}' alt='' style='margin 0 5px;' width='15px' heigth='15px' />";
            }
            $string .= "<span>$plan->nplan</span>";
            if (count($plan->subplanes)) {
                $string .= self::output($type, $plan->subplanes, $info);
            }
            $tareas = $plan->tareas;
            if ( $tareas ){
                $string .= "<ul>";
                foreach( $tareas as $tarea ){

                    $show_tarea = true;
                    
                    $asignaciones = [];
                    if ( $type == "general" ){
                        $asignaciones = $tarea->asignaciones();
                    }else if ( $type == "date" ){
                        $asignaciones = $tarea->asignacionBetween($info["fini"],$info["ffin"]);
                    }else if ( $type == "user" ){
                        $asignaciones = $tarea->asignacionByUser($info["user"]);
                    }

                    if ( count($asignaciones) == 0 ){
                        $show_tarea = false;
                    }

                    if ( $show_tarea ){

                        $string.= "<li data-ctiplan='5'>";
                        $string.= "<img src='vendor/jstree/img/task.png' alt='' width='15px' heigth='15px' />";
                        $string.= "<span>$tarea->ntarea</span>";
    
                        $string .= "<ul>";
    
                        foreach( $asignaciones as $asignacion ){
    
                            $ok = false;
                            $class = "tarea no_ok";
                            $text = $asignacion->updated_at;
                            // $text = "&#10008;";
                            if ( $asignacion->ifhecha == "1" ) {
                                $ok = true;
                                $class = "tarea ok";
                                // $text = "&#10003;";
                            }
    
                            $string .= "<li data-ctiplan='asignacion'>";
                            $string .= "<span class='$class' >( $text )</span>";
                            $string .= "<span class='$class' >{$asignacion->actividad->nactividad}</span>";
                            $string .= "</li>";
                        }
                        $string .= "</ul>";
                        $string.= "</li>";
                    }
                }
                $string .= "</ul>";
            }
            
            $string .= "</li>";

        }
        $string .= "</ul>";
        return $string;

    }
}
