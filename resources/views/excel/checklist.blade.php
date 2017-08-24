<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Checklist </title>
	<link href="{{ URL::asset('css/excel.css') }}" rel="stylesheet">
</head>
<body>

	<table class="table">
		<tr>
			<th class="bordered" width="100"> Pregunta </th>
			<th class="bordered"> Respuesta </th>
			<th class="bordered"> Anotaciones </th>
			<th class="bordered"> Evidencia </th>
		</tr>
		@foreach( $actividad->checklist->preguntas as $pregunta )

			<tr>
				<td class="bordered" width="100">
					{{ $pregunta->enunciado }}
				</td>
				<td class="bordered">
					@if($pregunta->respuesta)
						@if ( $pregunta->isOpenQuestion() )
							<p>
								{{$pregunta->respuesta->respuesta}}
							</p>
						@else
							<p>
								@if( $pregunta->respuesta->opcion )
									{{ $pregunta->respuesta->opcion->detalle }}
								@endif
							</p>
						@endif
					@endif
				</td>
				<td class="bordered">
					<p>@if($pregunta->respuesta){{$pregunta->respuesta->anotaciones}}@endif</p>
				</td>
				<td class="bordered">
					{{ $pregunta->cantidad_evidencias }}
				</td>
			</tr>
		@endforeach
	</table>

</body>
</html>
