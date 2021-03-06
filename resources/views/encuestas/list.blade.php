@extends('layouts.app')

@section('styles')
@endsection
@section('content')

	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>
					Encuestas
				</h4>
			</div>
		</div>
		<table class="encuestas table table-bordered tabla-hover " cellspacing="0">
			<thead>
				<tr>
					<th>Nombre</th>
					<th>Descripción</th>
					<th>Fecha</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($encuestas as $encuesta)
					<tr>
						<td>
							<a href="{{ URL::route('GET_encuesta',['cencuesta'=>$encuesta->cencuesta]) }}">
								{{$encuesta->nombre}}
							</a>
						</td>
						<td>{{$encuesta->descripcion}}</td>
						<td>{{$encuesta->fecha}}</td>
						<td>
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
