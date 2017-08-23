@extends('layouts.app')
@section('styles')

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

                        @include('partials.activities_grouped',['actividades',$actividades])

                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <!-- <script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/jquery.dataTables.min.js') }}"></script> -->
    <!-- <script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/dataTables.bootstrap.min.js') }}"></script> -->
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
