@extends('layouts.app')

@section('styles')
@endsection
@section('content')

	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>
					Encuesta {{ $encuesta->nombre }}
				</h4>
			</div>
		</div>

		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalGenerarReporte">Generar Reporte</button>

		<!-- Modal -->
		<div id="modalGenerarReporte" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Fechas de Aplicación</h4>
					</div>
					<div class="modal-body">
						<table class="table">
							<thead>
								<tr>
									<th>Item</th>
									<th>Fecha</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach( $encuesta->fechas as $fecha )
									<tr>
										<td></td>
										<td>{{ $fecha }}</td>
										<td>
											<a class="btn btn-primary" href="{{ URL::route('GET_export_encuesta_excel',[ 'cencuesta' => $encuesta->cencuesta, 'fecha' => $fecha, 'format' => 'xlsx' ]) }}">
												Excel
											</a>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>

			</div>
		</div>

		<table class="encuestas table table-bordered tabla-hover " cellspacing="0">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Fecha</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($encuesta->history as $history)
					<tr>
						<td>{{$history->usercontesto->name}}</td>
						<td>{{$history->fecha}}</td>
						<td>
							@if( $history->ifhecha )
								<a class="btn btn-success" href="{{ URL::route('GET_mostrar_encuesta',['id' => $history->chencuesta ]) }}">
									Ver Respuestas
								</a>
							@else
								<span class="label label-info"> Sin Contestar </span>
							@endif
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection

@section('scripts')
	<script>
		var table= $(".encuestas").DataTable({
			"paging":   true,
			"ordering": true,
			"info":     true,
			"searching":true,
			"language": DTspanish,
			"bLengthChange":false,
			"responsive": true,
		})
	</script>
@endsection
