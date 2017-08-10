@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('vendor/jstree/css/themes/default/style.min.css') }}" >
@endsection
@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Actividades <small>Lista de Actividades</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active">
					<i class="fa fa-dashboard"></i> Actividades
				</li>

			</ol>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
            <table class="table table-bordered tabla-hover table-responsive" cellspacing="0">
                <thead>
                    <tr>
                        <th>It</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Editar</th>
                        <th>Realizar</th>
                        <th>Resumen</th>
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
                                    <a class="btn btn-primary" href="{{ URL::route('GET_actividades_edit',['cactividad'=>$actividad->cactividad]) }}">Editar</a>
                                @endpermission
                            </td>
                            <td>
                                <a class="btn btn-success" href="{{ URL::route('realizar_actividad',['cactividad'=>$actividad->cactividad]) }}">Realizar</a>
                            </td>
                            <td>
                                <a class="btn btn-primary" href="{{ URL::route('GET_resumen_actividad',['cactividad'=>$actividad->cactividad]) }}">Resumen</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
		</div>
	</div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/dataTables.bootstrap.min.js') }}"></script>
    <script>
        var table = $(".table").DataTable({
            "paging":   true,
            "ordering": true,
            "info":     true,
            "searching":true,
            "language": DTspanish,
        })
    </script>
@endsection
