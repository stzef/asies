@extends('layouts.app')

@section('styles')
@endsection

@section('content')
	<div class="row">
		<div class="modal fade" id="modalChecklist" tabindex="-1" role="dialog" aria-labelledby="modalChecklistLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h2 class="modal-title" id="modalChecklistLabel">Checklist</h2>
					</div>

					<div class="modal-body">
						@if( $actividad->checklist )
							<div class="btn-gruop mb-2">
								<a class="btn btn-primary" href="{{ URL::route('GET_export_checklist_excel',[ 'cactividad' => $actividad->cactividad, 'format' => 'xlsx' ]) }}"> Excel </a>
							</div>
							<input type="hidden" value="{{ $actividad->checklist->cchecklist }}" id="cchecklist" name="cchecklist">

							@foreach( $actividad->checklist->preguntas as $i => $pregunta )
								@php $i++ @endphp
								<div class="panel panel-default hide checklistdeta_page" id="checklistdeta_page_{{$i}}" data-page="{{$i}}">
									<div class="panel-heading">
										<div>
											<input type="hidden" name="cpregunta" value="{{ $pregunta->cpregunta }}" data-text="{{ $pregunta->enunciado }}">
											#{{$i}} - {{ $pregunta->enunciado }}
										</div>
									</div>

									<div class="panel-body">
										<div>
											<label> Respuesta: </label>
											@if($pregunta->respuesta)
												@if ( $pregunta->isOpenQuestion() )
													<p>
														{{$pregunta->respuesta->respuesta}}
													</p>
												@else
													<p>
														@if ( $pregunta->respuesta->opcion )
															{{ $pregunta->respuesta->opcion->detalle }}
														@endif
													</p>
												@endif
											@endif
										</div>
										<div class="row">

											<div class="mb-3 col-xs-12 col-sm-12 col-md-12 col-md-12">
												<label> Anotaciones: </label>
												<p>@if($pregunta->respuesta){{$pregunta->respuesta->anotaciones}}@endif</p>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-12 col-md-12">
												<label> Evidencias: </label>
												<ul>
													@foreach( $pregunta->evidencias as $evidencia)
														<li>
															<a href="{{ URL::asset( $evidencia->path ) }}" download="" > {{ $evidencia->nombre }} </a>
														</li>
													@endforeach
												</ul>
											</div>
										</div>
									</div>

								</div>
							@endforeach
						@endif
						<div id="checklistdeta_pagination"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">
							<i class="glyphicon glyphicon-remove"></i> Salir
						</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modalActa" tabindex="-1" role="dialog" aria-labelledby="modalActaLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="modalActaLabel">Acta {{ $actividad->nactividad }}</h4>
						</div>

						<div class="modal-body p-0">
							@if ( $actividad->acta )
								<div class="col-md-5">
									<div class="form-group">
										<label for="plan_nombre" class="col-sm-4 col-form-label">Numero</label>
										<div class="col-sm-8">
											<p> {{ $actividad->acta->numeroacta }} </p>
										</div>
									</div>

									<div class="form-group">
										<label for="" class="col-sm-4 col-form-label">Objetivos</label>
										<div class="col-sm-8">
											<p> {{ $actividad->acta->objetivos }} </p>
										</div>
									</div>
									<div class="form-group">
										<label for="plan_nombre" class="col-sm-4 col-form-label">Pie de firma</label>
										<div class="col-sm-8">
											<p> {{ $actividad->acta->sefirma }} </p>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-4 col-form-label">Elaboró </label>
										<div class="col-sm-8">
											<p> {{ $actividad->acta->elaboro->persona->nombreCompleto()}} </p>

										</div>
									</div>

									<div class="form-group">
										<label for="" class="col-sm-4 col-form-label">Revisó </label>
										<div class="col-sm-8">
											<p> {{ $actividad->acta->reviso->persona->nombreCompleto()}} </p>
										</div>
									</div>

									<div class="form-group">
										<label for="" class="col-sm-4 col-form-label">Aprobó </label>
										<div class="col-sm-8">
											<p> {{ $actividad->acta->aprobo->persona->nombreCompleto()}} </p>
										</div>
									</div>
								</div>
								<div class="col-md-7">
									<div class="form-group">
										<label for="" class="col-sm-4 col-form-label">Hora Inicial</label>
										<div class='col-sm-8'>
											<p> {{ $actividad->acta->fhini }} </p>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-4 col-form-label">Hora Final</label>
										<div class='col-sm-8'>
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
							@else
								<h4 class="text-info"> No se Registro Acta </h4>
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
							</h4>
							<h4 class="text-center">
								@if ( $actividad->ifhecha )
									<div class="label label-info">
										Actividad Completada
									</div>
								@endif
								@php
									$local_state = $actividad->getStateTareas()
								@endphp
								<div class="label label-info">
									{{ $local_state["ok"] }} de {{ $local_state["total"] }} Tareas
								</div>
								<p class="label label-info">
									{{ $actividad->fini }}
								</p>
								@if ( $actividad->checklist() )
									@if ( $actividad->checklist()->ifhecha )
										<p class="label label-success"> Checklist </p>
									@else
										<p class="label label-danger"> Checklist </p>
									@endif
								@endif
								@if ( $actividad->ifacta )
									@if ( $actividad->cacta )
										<p class="label label-success"> Acta Generada </p>
									@else
										<p class="label label-danger"> Acta Generada </p>
									@endif
								@endif
								@if ( $actividad->getEvidencias(true) > 0 )
									<p class="label label-success"> {{ $actividad->getEvidencias(true) }} Evidencia(s) </p>
								@else
									<p class="label label-danger"> Sin Evidencias </p>
								@endif
							</h4>
						</div>
						<div class="col-md-5 text-center">
							<div class="btn-group">
								@if ( ! $actividad->ifhecha )
									<a class="btn btn-success" href="{{ URL::route('realizar_actividad',['cactividad'=>$actividad->cactividad]) }}">Realizar</a>
								@endif
								<a class="btn btn-danger" href="{{ URL::route('mis_actividades',['user'=>Auth::user()->name]) }}">Salir</a>
							</div>
						</div>
					</div>
				</div>

			</div>
			<div>
				<div>
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab_tareas">Tareas</a></li>
						<li><a data-toggle="tab" href="#tab_evidencias">Evidencias</a></li>
					</ul>
				</div>
				<div class="tab-content panel">
					<!-- Tareas -->
					<div id="tab_tareas" class="tab-pane fade in active">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h2>Tareas</h2>
							</div>
							<div class="panel panel-body p-0">
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
					<!-- Tareas -->

					<!-- Evidencias -->
					<div id="tab_evidencias" class="tab-pane">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h2>Evidencias</h2>
							</div>
							<div class="panel panel-body p-0">
								<table class="table table-hover">
									<tr>
										<td>
											@permission('actas.see')
												<button type="button" class="btn-block btn btn-primary " data-toggle="modal" data-target="#modalActa">
													<i class="fa fa-eye"></i>
													Acta
												</button>
											@endpermission
										</td>
									</tr>
									<tr>
										<td>
											@if ( $actividad->checklist )
												<button type="button" class="btn-block btn btn-primary " data-toggle="modal" data-target="#modalChecklist">
													<i class="fa fa-eye"></i>
													Checklist
												</button>
											@endif
										</td>
									</tr>
									@foreach ($evidencias as $evidencia)
										<tr>
											<td>
												<div class="p-0 col-lg-5 col-md-5 col-sm-5 col-xs-5 text-center">
													<a href="{{ $evidencia->path }}">
														<img class="img-thumbnail img-responsive " width="100px" src="{{ $evidencia->previewimg }}" alt="">
													</a>
												</div>
												<div class="p-0 col-lg-7 col-md-7 col-sm-7 col-xs-7">
													<div>
														<label class="hidden-xs" for="">Nombre</label>
														<input class="form-control" type="text" value="{{ $evidencia->nombre }}" name="nombre" placeholder="Nombre" data-evidencia="{{$evidencia->cevidencia}}" onchange="setdataEvidencia(this.dataset.evidencia,this.name,this.value)">
													</div>
													<div>
														<label class="hidden-xs" for="">Descripción</label>
														<textarea class="form-control" type="text" name="descripcion" placeholder="Descripción" data-evidencia="{{$evidencia->cevidencia}}" onchange="setdataEvidencia(this.dataset.evidencia,this.name,this.value)">{{ $evidencia->descripcion }}</textarea>
													</div>
												</div>
											</td>
										</tr>
									@endforeach
								</table>
							</div>
						</div>
					</div>
					<!-- Evidencias -->
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
	@if ( $actividad->checklist )
		$(function() {
			$("#checklistdeta_pagination").pagination({
				items: {{$actividad->checklist->cantidad_preguntas}},
				itemsOnPage: 1,
				displayedPages: 3,
				cssStyle: 'light-theme',
				prevText: "<",
				nextText: ">",
				selectOnClick: true,
				onPageClick: function(lastPageIndex,pageNumber, event){
					$(".checklistdeta_page").addClass("hide")
					$("#checklistdeta_page_"+pageNumber).removeClass("hide")
				},
				onInit: function(){
					var pageNumber = $("#checklistdeta_pagination").pagination('getCurrentPage');
					$("#checklistdeta_page_"+pageNumber).removeClass("hide")
				}
			});
		});
	@endif
</script>
@endsection
