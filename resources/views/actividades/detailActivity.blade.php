@extends('layouts.app')

@section('styles')
<style>
.tareas .tarea.hecha{
	background-color: #5cb85c;
}
.tareas .tarea.nohecha{
	background-color: #c9302c;
	color: white;
	font-weight: bold;
}
</style>
@endsection

@section('content')
	<div class="row">

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Detalle Actividad : {{ $actividad->nactividad }}
				</div>

				<div class="panel-body">
					<div class="col-md-12">
						<table class="table tareas detalle_actividad">
							<thead>
								<tr>
									<th>Tarea</th>
									<th>Responsabilidad</th>
									<th>Responsable</th>
									<th>Realizada</th>
									<th>Telefono</th>
									<th>Celular</th>
									<th>Email</th>
								</tr>
							</thead>
							<tbody>
								@foreach($actividad->asignaciones as $asignacion)
									<tr class="tarea @if( $asignacion->ifhecha == 1 ) hecha @else nohecha @endif ">
										<td>{{ $asignacion->tarea->ntarea }}</td>
										<td>{{ $asignacion->relacion->ntirelacion }}</td>
										<td>{{ $asignacion->usuario->persona->nombreCompleto() }}</td>
										<td> @if( $asignacion->ifhecha == 1 ) Si @else No @endif </td>
										<td>{{ $asignacion->usuario->persona->telefono }}</td>
										<td>{{ $asignacion->usuario->persona->celular }}</td>
										<td>{{ $asignacion->usuario->email }}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>

					<div class="col-md-6">
					</div>

				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
	<script type="text/javascript">
		$(".detalle_actividad").DataTable({
			"paging":    true,
			"ordering":  true,
			"searching": true,
			"info":      true,
			"language":  DTspanish,
		})
	</script>
@endsection
