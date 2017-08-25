@extends('layouts.app')

@section('styles')

@endsection


@section('content')

	<div class="row page-actividades">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>
						<span> Actividades </span>

						<div class="jplist-panel pull pull-right mb-1">
							<div
								class="dropdown"
								data-control-type="boot-sort-drop-down"
								data-control-name="bootstrap-sort-dropdown-demo"
								data-control-action="sort"
								data-datetime-format="{year}-{month}-{day} {hour}:{min}:{sec}"> <!-- {year}, {month}, {day}, {hour}, {min}, {sec} -->

								<button
									class="btn btn-primary dropdown-toggle m-0"
									type="button"
									id="dropdown-menu-1"
									data-toggle="dropdown"
									aria-expanded="true"
								>
									<span data-type="selected-text">Ordernar por</span>
									<span class="caret"></span>
								</button>

								<ul class="dropdown-menu" role="menu" aria-labelledby="dropdown-menu-1">

									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#" data-path=".jplist-name-cactividad" data-order="asc" data-type="number" data-default="true">Normal</a>
									</li>

									<li role="presentation" class="divider"></li>

									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#" data-path=".jplist-name-activity" data-order="asc" data-type="text" >Nombre A-Z</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#" data-path=".jplist-name-activity" data-order="desc" data-type="text" >Nombre Z-A</a>
									</li>

									<li role="presentation" class="divider"></li>

									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#" data-path=".jplist-fini-activity" data-order="asc" data-type="datetime">Fecha Asc</a>
									</li>
									<li role="presentation">
										<a role="menuitem" tabindex="-1" href="#" data-path=".jplist-fini-activity" data-order="desc" data-type="datetime">Fecha Desc</a>
									</li>

								</ul>
							</div>
						</div>

					</h4>

				</div>
			</div>
			<div class="container-actividades">



















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
								<span class="hidden jplist-name-activity"> {{ $actividad->nactividad }} </span>
								<span class="hidden jplist-name-activity"> {{ $actividad->fini }} </span>
								<span class="hidden jplist-name-cactividad"> {{ $actividad->cactividad }} </span>
								<h4 class="jplist-name-activity">
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

									<div class="label label-info jplist-fini-activity">
										{{ $actividad->fini }}
									</div>

									@if ( $actividad->checklist() )
										@if ( $actividad->checklist()->ifhecha )
											<p class="label label-success"> Checklist </p>
										@else
											<p class="label label-danger"> Checklist </p>
										@endif
									@endif

									@if ( $actividad->ifacta )
										@if ( $actividad->cacta )
											<p class="label label-success"> Acta Generada </p>
										@else
											<p class="label label-danger"> Sin Acta </p>
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
		$('.page-actividades').jplist({
			itemsBox: '.container-actividades',
			itemPath: '.container-actividad',
			panelPath: '.jplist-panel'
		});
		$(".tareas-actividad").DataTable({
			"paging":   true,
			"ordering": true,
			"info":     false,
			"searching":false,
			"bLengthChange": false,
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
