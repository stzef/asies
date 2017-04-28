@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('jstree/css/themes/default/style.min.css') }}" >
@endsection


@section('content')

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Mis Tareas <small></small>
			</h1>
			<ol class="breadcrumb">
				<li class="active">
					<i class="fa fa-dashboard"></i> Tareas
				</li>

			</ol>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Actividades
				</div>
				<div class="panel-body">
					@foreach ($actividades as $actividad)
						<div class="well">
							<div class="col-md-8">
								{{ $actividad->nactividad }}
							</div>
							<div class="col-md-4">
								<a class="btn btn-success" href="{{ URL::route('realizar_actividad',['cactividad'=>$actividad->cactividad]) }}">Realizar</a>
								<a class="btn btn-primary" href="{{ URL::route('GET_resumen_actividad',['cactividad'=>$actividad->cactividad]) }}">Resumen</a>
							</div>
							<table class="table">
								<thead>
									<tr>
										<th>Tareas</th>
										<th>Completada</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($actividad->tareas as $tarea)
										<tr>
											<td>{{ $tarea->ntarea }}</td>
											<td></td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
@endsection
