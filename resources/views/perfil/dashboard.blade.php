@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('vendor/jstree/css/themes/default/style.min.css') }}" >
	<link rel="stylesheet" href="{{ URL::asset('vendor/jstree/css/themes/default/style.min.css') }}" >

@endsection


@section('content')

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Actividades
				</div>
				<div class="panel-body">
					<!--<ul class="nav nav-tabs">
						<li><a data-toggle="tab" href="#retrasadas">Retrasadas</a></li>
						<li><a data-toggle="tab" href="#pendientes">Pendientes</a></li>
					</ul>

					<div class="tab-content">
						<div id="retrasadas" class="tab-pane fade in active">
						</div>
						<div id="pendientes" class="tab-pane fade">
						</div>
					</div>-->







					@if ( count($actividades) == 0)
						<h2>No tiene actividades asignadas</h2>
					@endif
					@foreach ($actividades as $actividad)
						@php
							$local_state = $actividad->getStateTareas()
						@endphp

						<div class="
							@if($actividad->ifhecha)
								alert alert-success
							@elseif( $local_state['ok'] > $local_state['not_ok'] )
								alert alert-warning
							@else
								well
							@endif
							container-actividad
						"
						>
							<div class="row">

								<div class="col-md-7">
									<h4>
										Actividad {{ $actividad->cactividad }} : {{ $actividad->nactividad }}
									</h4>
									<h4>
										@if ( $actividad->ifhecha )
											<div class="label label-info">
												Actividad Completada
											</div>
										@endif
										@if( $local_state["ok"] != $local_state["total"] )
											<div class="label label-info">
												{{ $local_state["ok"] }} de {{ $local_state["total"] }} Tareas
											</div>
										@endif
										<div class="label label-info">
											{{ $actividad->fini }}
										</div>
									</h4>
								</div>
								<div class="col-md-5">
									@if ( ! $actividad->ifhecha )
										<a class="btn btn-success" href="{{ URL::route('realizar_actividad',['cactividad'=>$actividad->cactividad]) }}">Realizar</a>
									@endif
									<a class="btn btn-primary" href="{{ URL::route('GET_resumen_actividad',['cactividad'=>$actividad->cactividad]) }}">Resumen</a>
									@permission('activities.crud')
										<a class="btn btn-primary" href="{{ URL::route('GET_actividades_edit',['cactividad'=>$actividad->cactividad]) }}">Editar</a>
									@endpermission
									<button class="btn btn-primary show-hide-tareas">+</button>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									@if ( $actividad->cacta )
										<p class="alert alert-success col-md-6">
											Acta Generada
										</p>
									@endif
									@if ( $actividad->getEvidencias(true) > 0 )
										<p class="alert alert-success col-md-6">
											{{ $actividad->getEvidencias(true) }} Evidencia(s)
										</p>
									@endif
								</div>
							</div>

							<table class="table tareas-actividad">
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
	<script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/dataTables.bootstrap.min.js') }}"></script>
	<script>
		$(".tareas-actividad").DataTable({
			"paging":   true,
			"ordering": true,
			"info":     false,
			"searching":false,
			"language": DTspanish,
		})

		$(".dataTables_wrapper").addClass("hide")
		$(".show-hide-tareas").click(function(){
			var that = this
			var table = $(that).closest(".container-actividad").find(".dataTables_wrapper")//find(".tareas-actividad")
			if ( table.hasClass("hide") ){
				table.removeClass("hide")
				$(that).html("-").attr("title","Esconder las Tareas")
			}else{
				table.addClass("hide")
				$(that).html("+").attr("title","Mostrar las Tareas")
			}
		})
	</script>
@endsection
