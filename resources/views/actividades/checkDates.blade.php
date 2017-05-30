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
                    <table class="actividades_atrasadas table">
                        <thead>
                            <tr>
                                <th>Actividad</th>
                                <th>F Inicio</th>
                                <th>F Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($actividades as $actividad)
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

@endsection

@section('scripts')
    <script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(".actividades_atrasadas").DataTable({
            "paging":   true,
            "ordering": true,
            "searching": true,
            "info":     true,
            "language": DTspanish,
        })
    </script>
@endsection
