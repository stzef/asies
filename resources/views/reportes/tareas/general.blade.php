<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reporte de Tareas General</title>
</head>
<body>
		@foreach( $planes as $plan )
			<ul>
				<li>
					{{ str_repeat(' - ', $plan->tiplan->nivel) }}
					{{ $plan->nplan }}
				</li>
				@php
					$subplanes = $plan->subplanes;
				@endphp
				@while( $subplanes )
					@foreach( $subplanes as $subplan )
						<li>
							@if($subplan->tiplan)
								{{ str_repeat(' - ', $subplan->tiplan->nivel) }}
							@endif
							{{ $subplan->nplan }}

							@if ( $subplan->tareas )
								<ul>
									@foreach( $subplan->tareas as $tarea )
										<li> {{ $tarea->ntarea }} (  )</li>
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
