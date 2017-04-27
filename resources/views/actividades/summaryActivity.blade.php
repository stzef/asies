@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Resumen Actividad : {{ $actividad->nactividad }}
                </div>

                <div class="panel-body">
                    <div class="col-md-6">
                        <table class="table table-hover">
                            @foreach ($evidencias as $evidencia)
                                <tr>
                                    <td>
                                        <a href="{{ $evidencia->path }}">
                                            <img class="img img-responsive" src="{{ $evidencia->path }}" alt="">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <td>
                                    <a href="#">Acta</a>

                                </td>
                            </tr>
                        </table>

                    </div>
                    <div class="col-md-6">
                        @foreach ($tareas as $tarea)
                            <div class="form-group row">
                                <!--<label class="col-sm-2"></label>-->
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" onclick="cambiarEstadoTarea(event,this)" type="checkbox" data-ctarea="{{ $tarea->ctarea }}" name="ctarea_{{ $tarea->ctarea }}" @if ($tarea->ifhecha) checked @endif> {{ $tarea->ntarea }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function cambiarEstadoTarea(event,element){
            var ctarea = $(element).data("ctarea")
            var ifhecha = element.checked ? 1 : 0
            var base_url_cambio_estado_tarea = "{{ URL::route('POST_cambiar_estado_tarea',['ctarea' => '__ctarea__']) }}"
            $.ajax({
                url : base_url_cambio_estado_tarea.set("__ctarea__",ctarea),
                type : "POST",
                data : { ctarea : ctarea, ifhecha : ifhecha },
                success : function(reponse){},
                error : function(reponse){},
            })
        }
        var cols = {
            ctarea : 0,
            ntarea : 1,
            crespo : 2,
            nrespo : 3,
            ctirela: 4,
            ntirela: 5,
            }
            var table= $("#tareas").DataTable({
            "paging":   false,
            "ordering": false,
            "info":     false,
            "language": idioma_espanol,
            "columnDefs": [
                {
                    "targets": [ cols.ctarea,cols.crespo,cols.ctirela ],
                    "visible": false,
                },
            ]

            //editar("#usuarios tbody");
        })
    </script>
@endsection
