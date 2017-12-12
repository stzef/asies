<?php

namespace asies\Helpers;

class Helper
{

    /*
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
    */

    /*
    public static $menu = [
        ["name" => "Dashboard", "icon" => "fa fa-fw fa-dashboard", "route" => URL::action('AppController@dashboard'), "permissions" => [] ],
        ["name" => "Mis Actividades", "icon" => "fa fa-fw fa-file-text-o", "route" => URL::action('mis_actividades',['user'=>Auth::user()->name]),"permissions" => [] ],
        [
            "name" => "Actividades", "icon" => "fa fa-fw fa-cubes", "route" =>null,"permissions" => [],
            "childrens" => [
                ["name" => "Crear", "icon" => "fa fa-fw fa-plus", "route" => URL::action('GET_actividades_create'), "permissions" => ["activities.crud"] ],
                ["name" => "Listar", "icon" => "fa fa-fw fa-list", "route" => URL::action('GET_actividades_list'), "permissions" => ["activities.all"] ],
                ["name" => "Ver Todas", "icon" => "fa fa-fw fa-calendar", "route" => URL::action('GET_verificar_fechas_actividades'), "permissions" => ["activities.check_dates"] ],
                
            ] 
        ], 
        [
            "name" => "Actas", "icon" => "fa-file-pdf-o", "route" =>null,"permissions" => [],
            "childrens" => [
                ["name" => "Listar", "icon" => "fa fa-fw fa-list", "route" => URL::action('GET_list_actas',['user'=>Auth::user()->name]), "permissions" => ["actas.crud.list"] ],
            ] 
        ],
        [
            "name" => "Reportes", "icon" => "fa fa-fw fa-file-pdf-o", "route" =>null,"permissions" => [],
            "childrens" => [
                ["name" => "Tareas", "icon" => "fa fa-fw fa-file-pdf-o", "route" => URL::action('reportes_view_tareas_general'), "permissions" => [] ],
                ["name" => "Tareas por Usuario", "icon" => "fa fa-fw fa-file-pdf-o", "route" => URL::action('reportes_view_tareas_by_user'), "permissions" => [] ],
                ["name" => "Tareas Rango de Fecha", "icon" => "fa fa-fw fa-file-pdf-o", "route" => URL::action('reportes_view_tareas_between'), "permissions" => [] ],
                
            ] 
        ],
        ["name" => "Tareas", "icon" => "fa fa-fw fa-tasks", "route" => URL::action('GET_tareas_create'), "permissions" => [] ],
        ["name" => "Evidencias", "icon" => "fa fa-fw fa-tasks", "route" => URL::action('GET_lista_evidencias'), "permissions" => [] ],
    ];
    */

    public static function output($type, $show, $planes, $info)
    {
        $show_task = $show["task"];
        $show_percentages = $show["percentages"] == "1";
        $show_responsable = $show["responsable"] == "1";

        $string = "<ul>";
        foreach ($planes as $i => $plan) {
            $tiplan = $plan->tiplan;
            if ( $tiplan ){
                $string .= "<li>";
                $string .= "<img src='/{$tiplan->icono}' alt='' style='margin 0 5px;' width='15px' heigth='15px' />";
                $string .= "<span>$plan->nplan</span>";
                
                $poocentaje = round(( $plan->valor_plan * 100 ) / $plan->valor_total);
                
                if ( $show_percentages ){
                    $string .= "<span style='float:right'>";
                    $string .= $poocentaje ."% ( $plan->valor_plan / $plan->valor_total )";
                    $string .= "<span style='background-color:{$plan->puntuacion->color}; height: 15px;width:10px;display: inline-block;' ></span>";
                    $string .= "</span>";
                }
                if (count($plan->subplanes)) {
                    $string .= self::output($type,$show, $plan->subplanes, $info);
                }
                $tareas = $plan->tareas;
                if ( $tareas ){
                    $string .= "<ul>";
                    foreach( $tareas as $tarea ){

                        $show_tarea = true;
                        
                        $asignaciones = [];

                        $ifhecha = null;
                        if ( $show_task == "1") $ifhecha = "1";
                        if ( $show_task == "0") $ifhecha = "0";

                        if ( $type == "general" ){
                            $asignaciones = $tarea->asignaciones($ifhecha);
                        }else if ( $type == "date" ){
                            $asignaciones = $tarea->asignacionBetween($info["fini"],$info["ffin"],$ifhecha);
                        }else if ( $type == "user" ){
                            $asignaciones = $tarea->asignacionByUser($info["user"],$ifhecha);
                        }

                        if ( count($asignaciones) == 0 ){
                            $show_tarea = false;
                        }

                        if ( $show_tarea ){

                            $string.= "<li data-ctiplan='5'>";
                            $string.= "<img src='/vendor/jstree/img/task.png' alt='' width='15px' heigth='15px' />";
                            $string.= "<span>$tarea->ctarea - $tarea->ntarea</span>";

                            $string .= "<table>";

                            foreach( $asignaciones as $asignacion ){
        
                                $ok = false;
                                $class = "tarea no_ok";
                                $text = $asignacion->updated_at;
                                if ( $asignacion->ifhecha == "1" ) {
                                    $ok = true;
                                    $class = "tarea ok";
                                }

                                $responsable = $asignacion->usuario->persona->nombreCompleto();
        
                                $string .= "<tr data-ctiplan='asignacion'>";
                                $string .= "<td width='60%' class='$class' >{$asignacion->actividad->cactividad} - {$asignacion->actividad->nactividad}</td>";
                                if ( $show_responsable ){
                                    $string .= "<td class='$class'>$responsable</td>";
                                }

                                $string .= "<td class='$class' >$text</td>";
                                $string .= "</tr>";
                            }
                            $string .= "</table>";
                            $string.= "</li>";
                        }
                    }
                    $string .= "</ul>";
                }
                
                $string .= "</li>";
            }

        }
        $string .= "</ul>";
        return $string;

    }
}
