<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reporte de Tareas General</title>
	<style>
		ul{
			margin: 0px;
			padding: 0px;
			list-style: none;
		}
		.tarea.no_ok{
			background-color: red;
		}
		.tarea.ok{
			background-color: green;
		}
		[data-ctiplan=2]{
			margin-left: 20px
		}
		[data-ctiplan=3]{
			margin-left: 40px
		}
		[data-ctiplan=4]{
			margin-left: 60px
		}
		[data-ctiplan=5]{
			margin-left: 80px
		}
		[data-ctiplan=asignacion]{
			margin-left: 100px
		}
	</style>
</head>
<body>
		@foreach( $planes as $plan )
			<ul>
				<li>
					{{ str_repeat('', $plan->tiplan->nivel) }}
					<img src="{{ $plan->tiplan->icono }}" alt="" width="15px" heigth="15px">
					{{ $plan->nplan }}
				</li>
				@php
					$subplanes = $plan->subplanes;
				@endphp
				@while( $subplanes )
					@foreach( $subplanes as $subplan )
						<li data-ctiplan="{{ $subplan->ctiplan }}">
							@if($subplan->tiplan)
								{{ str_repeat('', $subplan->tiplan->nivel) }}
								<img src="{{ $subplan->tiplan->icono }}" alt="" width="15px" heigth="15px">
							@endif
							{{ $subplan->nplan }}

							@if ( $subplan->tareas )
								<ul>
									@foreach( $subplan->tareas as $tarea )
										<li data-ctiplan="5">
											<img src="vendor/jstree/img/task.png" alt="" width="15px" heigth="15px">
											{{ $tarea->ntarea }}
										</li>
										<ul>
											@foreach( $tarea->asignacion as $asignacion )
											@php
												$ok = false;
												$class = "tarea no_ok";
												$text = "&#10008;";
												if ( $asignacion->ifhecha == "1" ) {
													$ok = true;
													$class = "tarea ok";
													$text = "&#10003;";
												}
											@endphp
												<li data-ctiplan="asignacion"> 
													<span class="{{ $class }}" >( {{ $text }} )</span>
													{{ $asignacion->actividad->nactividad }}
												</li>
											@endforeach
										</ul>
									@endforeach
								</ul>
							@endif
						</li>
					@endforeach
					@php
						$subplanes = $subplan->subplanes;
					@endphp
				@endwhile
			</ul>
			<div style="page-break-before: always;"></div>
		@endforeach
</body>
</html>
