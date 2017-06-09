@extends('layouts.app')
@section('styles')
    <!-- Bootstrap styles -->
    <!--<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
    <!-- Generic page styles -->
    <link rel="stylesheet" href="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/css/style.css') }}">
    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload-ui.css') }}">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload-noscript.css') }}"></noscript>
    <noscript><link rel="stylesheet" href="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload-ui-noscript.css') }}"></noscript>
@endsection

@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Verificar Fechas de Actividades
                </div>

                <div class="panel-body">
                    <div class="col-md-12">


                    <div class="row">
                        <ul class="nav nav-tabs">
                          <li><a data-toggle="tab" href="#retrasadas">Retrasadas</a></li>
                          <li><a data-toggle="tab" href="#pendientes">Pendientes</a></li>
                          <li><a data-toggle="tab" href="#realizadas">Realizadas</a></li>
                        </ul>

                        <div class="tab-content">
                          <div id="retrasadas" class="tab-pane fade in active">
                            @permission('activities.send_reminders')
                                <div class="panel">
                                    <button class="btn btn-success" onclick="Models.Actividades.sendReminders()">Enviar Recordatorios</button>
                                </div>
                            @endpermission
                            <h3>Retrasadas</h3>
                            <table class="actividades_retrasadas table">
                                <thead>
                                    <tr>
                                        <th>Actividad</th>
                                        <th>F Inicio</th>
                                        <th>F Final</th>
                                        <th>Dias Retraso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($actividades["retrasadas"] as $actividad)
                                        <tr>
                                            <td>{{ $actividad->nactividad }}</td>
                                            <td>{{ $actividad->fini }}</td>
                                            <td>{{ $actividad->ffin }}</td>
                                            <td>{{ $actividad->dias_retraso }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          </div>
                          <div id="pendientes" class="tab-pane fade">
                            <h3>Pendientes</h3>
                            <table class="actividades_pendientes table">
                                <thead>
                                    <tr>
                                        <th>Actividad</th>
                                        <th>F Inicio</th>
                                        <th>F Final</th>
                                        <th>Dias Faltantes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($actividades["pendientes"] as $actividad)
                                        <tr>
                                            <td>{{ $actividad->nactividad }}</td>
                                            <td>{{ $actividad->fini }}</td>
                                            <td>{{ $actividad->ffin }}</td>
                                            <td>{{ $actividad->dias_faltantas }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          </div>
                          <div id="realizadas" class="tab-pane fade">
                            <h3>Realizadas</h3>
                            <table class="actividades_realizadas table">
                                <thead>
                                    <tr>
                                        <th>Actividad</th>
                                        <th>F Inicio</th>
                                        <th>F Final</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($actividades["realizadas"] as $actividad)
                                        <tr>
                                            <td>{{ $actividad->nactividad }}</td>
                                            <td>{{ $actividad->fini }}</td>
                                            <td>{{ $actividad->ffin }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                          </div>
                        </div>
                    </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(".actividades_retrasadas").DataTable({
            "paging":   true,
            "ordering": true,
            "searching": true,
            "info":     true,
            "language": DTspanish,
        })
        $(".actividades_pendientes").DataTable({
            "paging":   true,
            "ordering": true,
            "searching": true,
            "info":     true,
            "language": DTspanish,
        })
    </script>
@endsection
