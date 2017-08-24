@extends('layouts.app')

@section('styles')

@endsection


@section('content')

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Actividades</h4>
				</div>
			</div>
			<div>
				@if ( count($actividades) == 0)
					<h2>No tiene actividades asignadas</h2>
				@endif
				@foreach ($actividades as $actividad)
					@php
						$local_state = $actividad->getStateTareas()
					@endphp

					<div class="
						@if($actividad->ifhecha)
							bg-success
						@endif
						well container-actividad
					"
					>
						<div class="row">

							<div class="col-md-7">
								<h4>
									Actividad {{ $actividad->cactividad }} : {{ $actividad->nactividad }}
								</h4>
								<h4 class="text-center">
									@if ( $actividad->ifhecha )
										<div class="label label-primary">
											Actividad Completada
										</div>
									@endif

									<div class="label label-info">
										{{ $local_state["ok"] }} de {{ $local_state["total"] }} Tareas
									</div>

									<div class="label label-info">
										{{ $actividad->fini }}
									</div>

									@if ( $actividad->checklist() )
										@if ( $actividad->checklist()->ifhecha )
											<p class="label label-success"> Checklist </p>
										@else
											<p class="label label-danger"> Checklist </p>
										@endif
									@endif

									@if ( $actividad->ifcacta )
										@if ( $actividad->cacta )
											<p class="label label-success"> Acta Generada </p>
										@else
											<p class="label label-danger"> Acta Generada </p>
										@endif
									@endif

									@if ( $actividad->getEvidencias(true) > 0 )
										<p class="label label-success"> {{ $actividad->getEvidencias(true) }} Evidencia(s) </p>
									@else
										<p class="label label-danger"> Sin Evidencias </p>
									@endif
								</h4>
							</div>
							<div class="col-md-5 text-center">
								<div class="btn-group">
									@if ( ! $actividad->ifhecha )
										<a class="btn btn-success" href="{{ URL::route('realizar_actividad',['cactividad'=>$actividad->cactividad]) }}">Realizar</a>
									@endif
									<a class="btn btn-info" href="{{ URL::route('GET_resumen_actividad',['cactividad'=>$actividad->cactividad]) }}">Resumen</a>
									@permission('activities.crud')
										<a class="btn btn-primary" href="{{ URL::route('GET_actividades_edit',['cactividad'=>$actividad->cactividad]) }}">Editar</a>
									@endpermission
									<button class="btn btn-info show-hide-tareas">+</button>
								</div>
							</div>
						</div>
						<div id="container_tareas" class="hide" >
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
					</div>
				@endforeach
			</div>
		</div>
	</div>

@endsection

@section('scripts')
	<script>
		$(".tareas-actividad").DataTable({
			"paging":   true,
			"ordering": true,
			"info":     false,
			"searching":false,
			"language": DTspanish,
		})
		$(".show-hide-tareas").click(function(){
			var that = this
			var table = $(that).closest(".container-actividad").find("#container_tareas")//find(".tareas-actividad")
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
