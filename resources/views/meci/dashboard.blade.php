@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('jstree/css/themes/default/style.min.css') }}" >
@endsection


@section('content')

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Planes <small>Vista General</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Planes
                </li>
            </ol>
        </div>
    </div>

    <div class="modal fade" id="modalCrearActividad" tabindex="-1" role="dialog" aria-labelledby="modalCrearActividadLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h2 class="modal-title" id="modalCrearActividadLabel">Crear Actividad</h2>
                </div>
                <div class="modal-body">
                  <form>
                    <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail3" placeholder="Nombre">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2"></label>
                      <div class="col-sm-10">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"> Archivos
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2"></label>
                      <div class="col-sm-10">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"> Acta
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2"></label>
                      <div class="col-sm-10">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"> Descripcion
                          </label>
                        </div>
                        <textarea type="text" class="form-control" id="" placeholder="Descripcion" disabled></textarea>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2"></label>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"> Fecha Inicial
                          </label>
                        </div>
                      </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Fecha Inicial" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2"></label>
                      <div class="col-sm-5">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"> Fecha Final
                          </label>
                        </div>
                      </div>
                        <div class="col-sm-5">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Fecha Final" disabled>
                        </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="glyphicon glyphicon-remove"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-success">
                        <i class="glyphicon glyphicon-plus"></i> Crear
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Planes</div>

                <div class="panel-body">
                    <div id="data" class="demo"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('jstree/js/jstree.min.js') }}"></script>

    <script>


        function crearActividad(){
            $("#modalCrearActividad").modal("show")
        }

        var data = [
            {
                text : "Modelo Estandar de Control Interno (MECI)",
                li_attr : {"data-nivel" : 1, "data-type": "module"},
                state : {opened : true,},
                children : [
                    {
                        text : "Módulo de Control de Planeación y Gestión",
                        icon : "/jstree/img/module.png",
                        li_attr : {"data-nivel" : 1, "data-type": "module"},
                        state : {opened : true,},
                        children : [
                            {
                                text : "Talento Humano" ,
                                state : {opened : true,},
                                icon : "/jstree/img/component.png",
                                children : [
                                    {
                                        text: "Acuerdos, Compromisos o Protocólos Éticos",
                                        state : {opened : true,},
                                        icon : "/jstree/img/element.png",
                                        children : [
                                            {
                                                state : {selected: true},
                                                text :"Documento con los principios y valores de la entidad",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text :"Acto administrativo que adopta el documento con los principios y valores de la entidad",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text :"Estrategias de socialización permanente de los principios y valores de la entidad",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },

                                        ]
                                    },
                                    {
                                        text: "Desarrollo del Talento Humano",
                                        icon : "/jstree/img/element.png",
                                        children : [
                                            {
                                                text : "Manual de Funciones y Competencias laborales",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Plan Institucional de Formación y Capacitación (Anual)",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Programa de Inducción y reinducción",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Programa de Bienestar (Anual)",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Plan de Incentivos (Anual)",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Sistema de evaluación del desempeño",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },

                                        ],
                                    },
                                ]
                            },
                            {
                                text : "Direccionamiento Estratégico" ,
                                icon : "/jstree/img/component.png",
                                children : [
                                    {
                                        text: "Planes, Programas y Proyectos",
                                        icon : "/jstree/img/element.png",
                                        children : [
                                            {
                                                text : "Planeación",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "La misión y visión institucionales adoptados y divulgados",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Objetivos institucionales",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Planes, programas y proyectos",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                        ],

                                    },
                                    {
                                        text: "Modelo de Operación por Procesos",
                                        icon : "/jstree/img/element.png",
                                        children : [
                                            {
                                                text : "Mapa de Procesos",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Divulgación de los procedimientos",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Proceso de seguimiento y evaluación que incluya la evaluación de la satisfacción del cliente y partes interesadas",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                        ],

                                    },
                                    {
                                        text: "Estructura Organizacional",
                                        icon : "/jstree/img/element.png",
                                        children : [
                                            {
                                                text : "Estructura organizacional de la entidad que facilite la gestión por procesos",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                        ],

                                    },
                                    {
                                        text: "Indicadores de Gestión",
                                        icon : "/jstree/img/element.png",
                                        children : [
                                            {
                                                text : "Definición de indicadores de eficiencia y efectividad, que permiten medir y evaluar el avance en la ejecución de los planes, programas y proyectos",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Seguimiento de los indicadores",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Revisión de la pertinencia y utilidad de los indicadores",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                        ],

                                    },
                                    {
                                        text: "Políticas de Operación",
                                        icon : "/jstree/img/element.png",
                                        children : [
                                            {
                                                text : "Establecimiento y divulgación de las políticas de operación",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Manual de operaciones o su equivalente adoptado y divulgado",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                        ],

                                    },
                                ]
                            },
                            {
                                text : "Administración de Riesgos" ,
                                icon : "/jstree/img/component.png",
                                children : [
                                    {
                                        text: "Políticas de Administración de Riesgos",
                                        icon : "/jstree/img/element.png",
                                        children : [
                                            {
                                                text : "Definición por parte de la alta Dirección de políticas para el manejo de los riesgos",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Divulgación del mapa de riesgos institucional y sus políticas",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                        ],

                                    },
                                    {
                                        text: "Identificación de Riesgos",
                                        icon : "/jstree/img/element.png",
                                        children : [
                                            {
                                                text : "Identificación de los factores internos y externos de riesgo",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Riesgos identificados por procesos que puedan afectar el cumplimiento de objetivos de la entidad",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                        ],

                                    },
                                    {
                                        text: "Análisis de Riesgos y Valoración de Riesgos",
                                        icon : "/jstree/img/element.png",
                                        children : [
                                            {
                                                text : "Análisis del riesgo",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Evaluación de controles existentes",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Valoración del riesgo",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Controles",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Mapa de riesgos de proceso",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                            {
                                                text : "Mapa de riesgos institucional",
                                                icon : "/jstree/img/product.png",
                                                li_attr : {"ondblclick" : "crearActividad()"},
                                                children : [],
                                            },
                                        ],

                                    },
                                ]
                            },
                        ]
                    }
                ]
            },
            {
                text : "Sistema de Desarrollo Administrativo",
                li_attr : {"data-nivel" : 1, "data-type": "module"},
                children : []
            },
            {
                text : "Sistema de Gestion de Calidad",
                li_attr : {"data-nivel" : 1, "data-type": "module"},
                children : []
            }
        ]
        Models.Planes.treeview(function(response){
            console.log(response)
            $('#data').jstree({
                'core' : {
                    'data' : response
                }
            });
        })

    </script>
@endsection
