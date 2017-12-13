<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Estadisticas </title>
	<!-- <link href="{{ URL::asset('css/excel.css') }}" rel="stylesheet"> -->
</head>
<body>

		@foreach( $encuesta->history->estadisticas as $item )
			<table class="table">
				<tr>
					<th colspan="2" class="bordered">{{ $item["tipregunta"]->detalle }}</th>
				</tr>
				<tr>
					<th colspan="{{ (count($item['opciones']) - 1) or 1 }}" class="bordered"> Respuesta </th>
					<th class="bordered"> Cantidad </th>
				</tr>
				@foreach( $item["opciones"] as $opcion )
					<tr>
						<td class="bordered"> {{ $opcion["opcion"]->detalle }} </td>
						<td class="bordered"> {{ $opcion["cantidad"] }} </td>
					</tr>
				@endforeach
				<tr>
					<th class="bordered"> Total </th>
					<td class="bordered">{{ $item["total"] }}</td>
				</tr>
			</table>
		@endforeach

</body>
</html>
