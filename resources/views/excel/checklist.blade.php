<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		td.bordered{
			border: 1px solid #000000;
		}
	</style>
</head>
<body>

	<table class="table">

		<tr>
			<th class="bordered"> Pregunta </th>
			<th class="bordered"> Respuesta </th>
			<th class="bordered"> Anotaciones </th>
			<th class="bordered"> Evidencia </th>
		</tr>
		@foreach( $actividad->checklist->preguntas as $pregunta )

			<tr>
				<td class="bordered">
					{{ $pregunta->enunciado }}
				</td>
				<td class="bordered">
					@if ( $pregunta->isOpenQuestion() )
						<p>
							@if($pregunta->respuesta){{$pregunta->respuesta->respuesta}}@endif
						</p>
					@else
						<p>
							@if($pregunta->respuesta)
								{{ $pregunta->respuesta->opcion->detalle }}
							@endif
						</p>
					@endif
				</td>
				<td class="bordered">
					<p>@if($pregunta->respuesta){{$pregunta->respuesta->anotaciones}}@endif</p>
				</td>
				<td class="bordered">
					<ul>
						@foreach( $pregunta->evidencias as $evidencia)
							<li>
								<a href="{{ URL::asset( $evidencia->path ) }}" download="" > {{ $evidencia->nombre }} </a>
							</li>
						@endforeach
					</ul>
				</td>
			</tr>
		@endforeach
	</table>

</body>
</html>
