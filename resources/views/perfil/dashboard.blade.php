@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('vendor/jstree/css/themes/default/style.min.css') }}" >
@endsection


@section('content')

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				{{ Auth::user()->persona->nombreCompleto() }} <small></small>
			</h1>
			<ol class="breadcrumb">
				<li class="active">
					<i class="fa fa-dashboard"></i> Perfil
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
							<div class="col-md-7">
								<h4>
									Actividad : {{ $actividad->nactividad }}
								</h4>
							</div>
							<div class="col-md-5">
								<a class="btn btn-success" href="{{ URL::route('realizar_actividad',['cactividad'=>$actividad->cactividad]) }}">Realizar</a>
								<a class="btn btn-primary" href="{{ URL::route('GET_resumen_actividad',['cactividad'=>$actividad->cactividad]) }}">Resumen</a>
								@permission('activities.crud')
									<a class="btn btn-primary" href="{{ URL::route('GET_actividades_edit',['cactividad'=>$actividad->cactividad]) }}">Editar</a>
								@endpermission
								@if ( $actividad->cacta )
									<span class="alert alert-success">
										Acta
									</span>
								@if ( $actividad->n_eviencias > 0 )
									<span class="alert alert-success">
										{{ $actividad->n_eviencias }} E...
										</span>
								@endif
								@endif
							</div>
							<table class="table">
								<thead>
									<tr>
										<th>Tareas</th>
										<th>Realizar</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($actividad->tareas as $tarea)
										<tr>
											<td>({{ $tarea->cplan }}) {{ $tarea->ntarea }}</td>
											<td>@if ($tarea->ifhecha) Si @else No @endif</td>
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
