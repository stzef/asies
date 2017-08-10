@extends('layouts.app')

@section('styles')
@endsection

@section('content')
	<div class="row">

		<div class="modal fade" id="modalActa" tabindex="-1" role="dialog" aria-labelledby="modalActaLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h2 class="modal-title" id="modalActaLabel">Acta {{ $actividad->nactividad }}</h2>
						</div>

						<div class="row modal-body">
							@if ( $actividad->acta )
								<div class="col-md-5">
									<div class="form-group row">
										<label for="plan_nombre" class="col-sm-4 col-form-label">Numero</label>
										<div class="col-sm-8">
											<p> {{ $actividad->acta->numeroacta }} </p>
										</div>
									</div>

									<div class="form-group row">
										<label for="" class="col-sm-4 col-form-label">Objetivos</label>
										<div class="col-sm-8">
											<p> {{ $actividad->acta->objetivos }} </p>
										</div>
									</div>
									<div class="form-group row">
										<label for="plan_nombre" class="col-sm-4 col-form-label">Pie de firma</label>
										<div class="col-sm-8">
											<p> {{ $actividad->acta->sefirma }} </p>
										</div>
									</div>
									<div class="form-group row">
										<label for="" class="col-sm-4 col-form-label">Elaboró </label>
										<div class="col-sm-8">
											<p> {{ $actividad->acta->elaboro->persona->nombreCompleto()}} </p>

										</div>
									</div>

									<div class="form-group row">
										<label for="" class="col-sm-4 col-form-label">Revisó </label>
										<div class="col-sm-8">
											<p> {{ $actividad->acta->reviso->persona->nombreCompleto()}} </p>
										</div>
									</div>

									<div class="form-group row">
										<label for="" class="col-sm-4 col-form-label">Aprobó </label>
										<div class="col-sm-8">
											<p> {{ $actividad->acta->aprobo->persona->nombreCompleto()}} </p>
										</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="col-md-12">
										<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Hora Inicial</label>
												<div class='col-sm-8 input-group date'>
													<p> {{ $actividad->acta->fhini }} </p>
												</div>
										</div>
										<div class="form-group row">
												<label for="" class="col-sm-4 col-form-label">Hora Final</label>
												<div class='col-sm-8 input-group date'>
													<p> {{ $actividad->acta->fhfin }} </p>
												</div>
										</div>
										<table class="table table-bordered tabla-hover table-responsive" cellspacing="0">
											<thead>
												<tr>
													<th>Tarea</th>
													<th>Responsable</th>
													<th>Responsabilidad</th>
													<th>Realizada</th>
												</tr>
											</thead>
											<tbody>
												@foreach($asignaciones as $asignacion)
													<tr>
														<td title="{{$asignacion->tarea->ntarea}}">{{ str_limit($asignacion->tarea->ntarea, 30 ,$end="...") }}</td>
														<td>{{$asignacion->usuario->persona->nombreCompleto()}}</td>
														<td>{{$asignacion->relacion->ntirelacion}}</td>
														<td> @if( $asignacion->ifhecha ) Si @else No @endif </td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							@else
								<h2> No se Registro Acta </h2>
							@endif
						</div>

						<div class="modal-footer">
							@if ( $actividad->acta )

								<a href="{{ URL::route('GET_pdf_acta',['numeroacta'=>$actividad->acta->numeroacta]) }}" target="blank" type="button" class="btn btn-primary">
									<i class="glyphicon glyphicon-print"></i> Imprimir
								</a>

								<a href="{{URL::route('GET_send_acta',['numeroacta'=>$actividad->acta->numeroacta])}}"><button type="button" class="btn btn-primary">
									<i class="glyphicon glyphicon-send"></i> Enviar
								</button></a>
							@endif
							<button type="button" class="btn btn-danger" data-dismiss="modal">
								<i class="glyphicon glyphicon-remove"></i> Salir
							</button>
						</div>
				</div>
			</div>
		</div>


		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-7">
							<h4>
								Resumen Actividad : {{ $actividad->nactividad }}
								@if ( $actividad->ifhecha )
									<div class="label label-info">
										Actividad Completada
									</div>
								@endif
							</h4>
						</div>
						<div class="col-md-5">
							@if ( ! $actividad->ifhecha )
								<a class="btn btn-success" href="{{ URL::route('realizar_actividad',['cactividad'=>$actividad->cactividad]) }}">Realizar</a>
							@endif
							<a class="btn btn-danger" href="{{ URL::route('mis_actividades',['user'=>Auth::user()->name]) }}">Salir</a>
						</div>
					</div>
					<div class="label label-info">
						{{ $actividad->fini }}
					</div>
				</div>

				<div class="panel-body">
					<div class="col-md-6">
						<h2>Evidencias</h2>
						<table class="table table-hover">
							<tr>
								<td>
									@permission('actas.see')
										<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modalActa">
											<i class="glyphicon glyphicon-plus"></i>
											Ver Acta
										</button>
									@endpermission
								</td>
							</tr>
							@foreach ($evidencias as $evidencia)
								<tr>
									<td>
										<div class="col-md-5">
											<a href="{{ $evidencia->path }}">
												<img class="img-thumbnail img-responsive " width="100px" src="{{ $evidencia->previewimg }}" alt="">
											</a>
										</div>
										<div class="col-md-7">
											<label for="">Nombre</label>
											<input class="form-control" type="text" value="{{ $evidencia->nombre }}" name="nombre" placeholder="Nombre" data-evidencia="{{$evidencia->cevidencia}}" onchange="setdataEvidencia(this.dataset.evidencia,this.name,this.value)">
											<label for="">Descripción</label>
											<textarea class="form-control" type="text" name="descripcion" placeholder="Descripción" data-evidencia="{{$evidencia->cevidencia}}" onchange="setdataEvidencia(this.dataset.evidencia,this.name,this.value)">{{ $evidencia->descripcion }}</textarea>
										</div>
									</td>
								</tr>
							@endforeach
						</table>
					</div>

					<div class="col-md-6">
						<h2>Tareas</h2>
						<table class="table">
							<tr>
								<th>Tarea</th>
								<th>Realizada</th>
							</tr>
							@foreach ($tareas as $tarea)
								<tr>
									<td>
										<p>{{ $tarea->ntarea }}</p>
									</td>
									<td>
										<input
											class="form-check-input toggle-do"
											disabled
											type="checkbox"
											data-ctarea="{{ $tarea->ctarea }}"
											name="ctarea_{{ $tarea->ctarea }}"
											@if ($tarea->ifhecha) checked @endif
										>
									</td>
								</tr>
							@endforeach
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>

@endsection

@section('scripts')
<script>
			function setdataEvidencia(key,name,value){
			Models.Evidencias.set(key,JSON.stringify([[name,value]]),function(response){
				console.log(response)
				alertify.success("Evidencia Editada")
			})
		}
</script>
@endsection
