@extends('layouts.app')

@section('styles')
@endsection

@section('content')

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Lista de Actividades</h4>
                </div>
            </div>

            <table class="table table-bordered tabla-hover table-responsive" cellspacing="0">
                <thead>
                    <tr>
                        <th>It</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th width="100px">Editar</th>
                        <th width="100px">Realizar</th>
                        <th width="100px">Resumen</th>
                        <th width="100px">Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($actividades as $actividad)
                        <tr>
                            <td>
                                {{$actividad->cactividad}}
                            </td>
                            <td>
                                {{$actividad->nactividad}}
                                @if ( $actividad->ifhecha )
                                    <div class="label label-info">
                                        Actividad Completada
                                    </div>
                                @endif
                            </td>
                            <td>{{$actividad->fini}}</td>
                            <td>
                                @permission('activities.crud')
                                    <a class="btn btn-primary btn-block" href="{{ URL::route('GET_actividades_edit',['cactividad'=>$actividad->cactividad]) }}">Editar</a>
                                @endpermission
                            </td>
                            <td>
                                <a class="btn btn-success btn-block" href="{{ URL::route('realizar_actividad',['cactividad'=>$actividad->cactividad]) }}">Realizar</a>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-block" href="{{ URL::route('GET_resumen_actividad',['cactividad'=>$actividad->cactividad]) }}">Resumen</a>
                            </td>
                            <td>
                                <a class="btn btn-primary btn-block" target="_blank" href="{{ URL::route('GET_detalle_actividad',['cactividad'=>$actividad->cactividad]) }}">Detalle</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

@endsection

@section('scripts')
    <script>
        var table = $(".table").DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true,
            "searching":true,
            "language": DTspanish,
            "bLengthChange": false,
            "responsive": true,
        })
    </script>
@endsection
