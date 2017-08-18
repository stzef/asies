<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title> Estadisticas </title>
	<style>
		td.bordered{
			border: 1px solid #000000;
		}
	</style>
</head>
<body>
		@foreach( $actividad->checklist->estadisticas as $item )
			<table class="table">
				<tr>
					<th colspan="{{ count($item['opciones']) - 1 }}" class="bordered"> {{ $item["tipregunta"]->detalle }} </th>
					<th class="bordered"> Cantidad </th>
				</tr>
				@foreach( $item["opciones"] as $opcion )
					<tr>
						<td> {{ $opcion["opcion"]->detalle }} </td>
						<td> {{ $opcion["cantidad"] }} </td>
					</tr>
				@endforeach
			</table>
		@endforeach
</body>
</html>
