@extends('layouts.app')
@section('styles')

@endsection

@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>
                        Verificar Fechas
                    </h4>
                </div>
            </div>

            <div>
                <div class="col-md-12">
                    @include('partials.activities_grouped',['actividades',$actividades])
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript">
        // $.fn.DataTable.isDataTable( '.table' )

        $("table.table").DataTable({
            multiple:true,
            "paging":   true,
            "ordering": true,
            "searching": true,
            "info":     true,
            "language": DTspanish,
            "bLengthChange": false,
            "responsive": true,
        })
        /*$(".actividades_pendientes").DataTable({
            "paging":   true,
            "ordering": true,
            "searching": true,
            "info":     true,
            "language": DTspanish,
            "bLengthChange": false,
            "responsive": true,
        })*/
    </script>
@endsection
