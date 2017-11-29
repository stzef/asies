@extends('layouts.app')
@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('css/jqupload/blueimp-gallery.min.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload-ui.css') }}">
	<noscript><link rel="stylesheet" href="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload-noscript.css') }}"></noscript>
	<noscript><link rel="stylesheet" href="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload-ui-noscript.css') }}"></noscript>
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-7">
							<h4>
								Realizando Actividad {{ $actividad->cactividad }} : {{ $actividad->nactividad }}
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
										<p class="label label-danger"> Sin Acta </p>
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
								<a class="btn btn-primary" href="{{ URL::route('GET_resumen_actividad',['cactividad'=>$actividad->cactividad]) }}">Resumen</a>
								<a class="btn btn-danger" href="{{ URL::route('mis_actividades',['user'=>Auth::user()->name]) }}">Salir</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="main-tabs">
				<div>
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab_tareas">Tareas</a></li>
						<li><a data-toggle="tab" href="#tab_evidencias">Evidencias</a></li>
						@if ( $actividad->checklist )
							<li><a data-toggle="tab" href="#tab_checklist">Checklist</a></li>
						@endif
					</ul>
				</div>

				<div class="tab-content panel">
					<!-- Tareas -->
					<div id="tab_tareas" class="tab-pane fade in active">
						<div class="panel panel-default">
							<div class="panel panel-body p-0">
								<table class="table">
									<thead>
										<tr>
											<th>Tarea</th>
											<th>Realizada</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($tareas as $tarea)
											<tr>
												<td>
													{{ $tarea->ntarea }}
												</td>
												<td>
													<input
														type="checkbox"
														name="ctarea_{{ $tarea->ctarea }}"
														class="form-check-input toggle-do"
														onchange="Models.Tareas.cambiarEstado(this.dataset.cactividad,this.dataset.ctarea, validar)"
														data-ctarea="{{ $tarea->ctarea }}"
														data-cactividad="{{ $actividad->cactividad }}"
														@if ($tarea->ifhecha) checked @endif
													>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- Tareas -->

					<!-- Evidencias -->
					<div id="tab_evidencias" class="tab-pane fade in">
						<div class="panel panel-default">
							<div class="panel panel-heading">
								@if ( $actividad->acta )
									<div class="alert alert-warning">
										El acta de esta actividad ya se ha creado. Para ver el acta ir a Resumen.
									</div>
								@else
									@permission('actas.crud')
										<button type="button" class="btn btn-primary " id="btn_crear_acta" data-toggle="modal" data-target="#modalCrearActa">
											<i class="glyphicon glyphicon-plus"></i>
											Crear Acta
										</button>
									@endpermission
								@endif
							</div>
							<div class="panel panel-body p-0">
								<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
									<input type="hidden" name="cactividad" id="cactividad" value="{{ $actividad->cactividad }}">
									<!-- Redirect browsers with JavaScript disabled to the origin page -->
									<noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
									<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
									<div class="row fileupload-buttonbar">
										<div class="col-md-12">
											<!-- The fileinput-button span is used to style the file input field as button -->
											<div class="text-center">

												<div class="btn-group">
													<span class="btn btn-success fileinput-button">
														<i class="glyphicon glyphicon-plus"></i>
														<span>Agregar</span>
														<input type="file" name="files[]" multiple>
													</span>
													<button type="submit" class="btn btn-primary start">
														<i class="glyphicon glyphicon-upload"></i>
														<span>Subir</span>
													</button>
													<button type="reset" class="btn btn-warning cancel">
														<i class="glyphicon glyphicon-ban-circle"></i>
														<span>Carcelar</span>
													</button>
												</div>
											</div>

											<!-- The global file processing state -->
											<span class="fileupload-process"></span>
										</div>
										<!-- The global progress state -->
										<div class="col-lg-12 fileupload-progress fade">
											<!-- The global progress bar -->
											<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
												<div class="progress-bar progress-bar-success" style="width:0%;"></div>
											</div>
											<!-- The extended global progress state -->
											<div class="progress-extended">&nbsp;</div>
										</div>
									</div>
									<!-- The table listing the files available for upload/download -->
									<table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
								</form>
							</div>
						</div>

					</div>
					<!-- Evidencias -->

					<!-- Checklist -->
					@if( $actividad->checklist )
						<div id="tab_checklist" class="tab-pane fade in ">
							@if ( $actividad->checklist()->ifhecha )
								<div class="panel panel-default bg-success">
									<div class="panel-heading">
										<h4>Checklist Completado</h4>
									</div>
								</div>
							@else
								<div class="panel panel-default">
									<button type="submit" class="btn btn-primary" id="btn_guardar_checklist">
										<i class="glyphicon glyphicon-plus"></i> Guardar
									</button>
									<div class="panel-body p-0" id="checklist">
										<input type="hidden" value="{{ $actividad->checklist->cchecklist }}" id="cchecklist" name="cchecklist">
										<table class="table table-responsive" id="preguntas-checklist">
											<thead>
												<tr>
													<th>Pregunta</th>
													<th>Respuesta</th>
													<th>Anotaciones</th>
													<th>Evidencias</th>
												</tr>
											</thead>
											<tbody>
												@foreach( $actividad->checklist->preguntas as $i => $pregunta )
													@php $i++ @endphp
													<tr id="pregunta-checklist">
														<td>
															<input type="hidden" name="cpregunta" value="{{ $pregunta->cpregunta }}" data-text="{{ $pregunta->enunciado }}">
															{{$i}} - {{ $pregunta->enunciado }}
														</td>
														<td>
															@if ( $pregunta->isOpenQuestion() )
																<input type="hidden" name="isOpenQuestion" value="true">
																<textarea
																	style="resize:none"
																	class="form-control respuesta"
																	name="copcion"
																	data-text="Respuesta Abierta"
																	required
																>@if($pregunta->respuesta){{$pregunta->respuesta->respuesta}}@endif</textarea>
															@else
																<input type="hidden" name="isOpenQuestion" value="false">
																@foreach($pregunta->opciones as $opcion)
																	<div>
																		<label for="copcion_{{ $opcion->copcion }}_cpregunta_{{ $pregunta->cpregunta }}">
																			<input
																				type="radio"
																				name="copcion_cpregunta_{{ $pregunta->cpregunta }}"
																				id="copcion_{{ $opcion->copcion }}_cpregunta_{{ $pregunta->cpregunta }}"
																				data-text="{{ $opcion->detalle }}"
																				value="{{ $opcion->copcion }}"
																				class="respuesta"
																				required
																				@if($pregunta->respuesta)
																					@if($pregunta->respuesta->copcion == $opcion->copcion )
																						checked
																					@endif
																				@endif
																			/>
																			<span>{{ $opcion->detalle }}</span>
																		</label>
																	</div>
																@endforeach
															@endif
														</td>
														<td>
															<textarea style="resize:none" class="form-control" name="anotaciones" id="anotaciones">@if($pregunta->respuesta){{$pregunta->respuesta->anotaciones}}@endif</textarea>
														</td>
														<td>
															<input
																data-cactividad="{{$actividad->cactividad}}"
																data-cpregunta="{{$pregunta->cpregunta}}"
																type="file"
																name="evidencia_{{ $pregunta->cpregunta }}"
																id="evidencia_{{ $pregunta->cpregunta }}"
																multiple
																onchange="storeEvidenciaChecklist(event.target)"
																class="files_checklist"
															>
														</td>
													</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							@endif
						</div>
					@endif
					<!-- Checklist -->
				</div>
			</div>

		</div>
	</div>

	<div class="modal fade" id="modalCrearActa" tabindex="-1" role="dialog" aria-labelledby="modalCrearActaLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h2 class="modal-title" id="modalCrearActaLabel">Crear Acta</h2>
					</div>

				<div class="row modal-body">

					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#form_data_acta">Datos</a></li>
						<li><a data-toggle="tab" href="#tabla_responsables">Responsables</a></li>
						<li><a data-toggle="tab" href="#tabla_compromisos">Compromisos</a></li>
					</ul>
					<div class="tab-content">
						<div id="form_data_acta" class="tab-pane fade in active">
							<form id="form_crear_acta" class="form-horizontal">
									<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
									<div class="col-md-6">
										<div class="form-group row">
											<label for="number_acta" class="col-sm-2 col-form-label">Numero</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" id="number_acta" required name="acta[numeroacta]" value="{{$numacta}}" readonly required>
											</div>
										</div>

										<div class="form-group row">
											<label for="" class="col-sm-2 col-form-label">Objetivos</label>
											<div class="col-sm-10">
												<textarea class="form-control" id="" required name="acta[objetivos]" rows="15">
													@foreach ($tareas as $tarea)
														{{ $tarea->ntarea }}
													@endforeach
												</textarea>
											</div>
										</div>
									</div>
									<div class="col-md-6">
											<div class="form-group row">
													<label for="" class="col-sm-4 col-form-label">Hora Inicial</label>
													<div class='col-sm-8 input-group datetime'>
														<input type='text' class="form-control" required id="acta_fhini" name="acta[fhini]"/>
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-time"></span>
														</span>
													</div>
											</div>
											<div class="form-group row">
													<label for="" class="col-sm-4 col-form-label">Hora Final</label>
													<div class='col-sm-8 input-group datetime'>
														<input type='text' class="form-control" required id="acta_fhfin" name="acta[fhfin]"/>
														<span class="input-group-addon">
															<span class="glyphicon glyphicon-time"></span>
														</span>
													</div>
											</div>
											<div class="form-group row">
												<label for="plan_nombre" class="col-sm-2 col-form-label">Pie de firma</label>
												<div class="col-sm-10">
													<input type="text" class="form-control" id="plan_nombre" required name="acta[sefirma]" placeholder="Ciudad, DD/MM/AA">
												</div>
											</div>
											<div class="form-group row">
												<label for="" class="col-sm-2 col-form-label">Elaboró </label>
												<div class="col-sm-10">
													<select required name="acta[user_elaboro]" class="form-control">
														<option value="">Seleccione...</option>
															@foreach ($usuarios as $usuario)
																<option value = "{{$usuario->id}}">{{$usuario->persona->nombres}} {{$usuario->persona->apellidos}}</option>
															@endforeach
													</select>
												</div>
											</div>

											<div class="form-group row">
												<label for="" class="col-sm-2 col-form-label">Revisó </label>
												<div class="col-sm-10">
													<select required name="acta[user_reviso]" class="form-control">
														<option value="">Seleccione...</option>
															@foreach ($usuarios as $usuario)
																<option value = "{{$usuario->id}}">{{$usuario->persona->nombres}} {{$usuario->persona->apellidos}}</option>
															@endforeach
													</select>
												</div>
											</div>

											<div class="form-group row">
												<label for="" class="col-sm-2 col-form-label">Aprobó </label>
												<div class="col-sm-10">
													<select required name="acta[user_aprobo]" class="form-control">
														<option value="">Seleccione...</option>
															@foreach ($usuarios as $usuario)
																<option value = "{{$usuario->id}}">{{$usuario->persona->nombres}} {{$usuario->persona->apellidos}}</option>
															@endforeach
													</select>
												</div>
											</div>
									</div>
							</form>
						</div>
						<div id="tabla_responsables" class="tab-pane fade">
							<div class="col-md-12">
									<div class="table-responsive col-md-12">
										<form id="usuario_planes">
											<table class="table text-center">
												<tbody>
													<tr>
														<td width="50%">
															<div class="input-group">
																<div>
																	<select-task required="required" name="tareasusuarios[ctarea]" id="tarea" :productos_minimos="productos_minimos" @mounted="getTask" />
																</div>
																<span class="input-group-addon" data-find-task="true" data-find-treetask data-input-reference="#tarea"><i class="fa fa-search"></i></span>
															</div>
														</td>
													</tr>
													<tr>
														<td width="25%">
															<select name="tareasusuarios[user]" id="respo" required class="form-control">
																<option value="">Responsable</option>
																@foreach ($usuarios as $usuario)
																	<option value = "{{$usuario->id}}">{{$usuario->persona->nombres}} {{$usuario->persona->apellidos}}</option>
																@endforeach
															</select>
														</td>
													</tr>
													<tr>
														<td width="25%">
															<select name="tareasusuarios[ctirelacion]" id="tirespo" required class="form-control" >
																<option value="">Tipo de responsabilidad</option>
																@foreach ($relaciones as $relacion)
																	<option value = "{{$relacion->ctirelacion}}">{{$relacion->ntirelacion}}</option>
																@endforeach
															</select>
														</td>
													</tr>
													<tr>
														<td>
															<button id="agregar" type="submit" class="btn btn-info">
																<i class="glyphicon glyphicon-plus"></i>
															</button>
														</td>
													</tr>
												</tbody>
											</table>
										</form>
									  <div class="col-md-12">
											<table id="usuarios" width="100%" class="table table-bordered tabla-hover table-responsive" cellspacing="0">
												<thead>
													<tr>
														<th>ctarea</th>
														<th>Tarea</th>
														<th>cusu</th>
														<th>Responsable</th>
														<th>ctirelacion</th>
														<th>Responsabilidad</th>
														<th>Realizada</th>
														<th>Editar</th>
														<th>Borrar</th>
													</tr>
												</thead>
												<tbody>
													@foreach ($asignacion as $asignacion)
														<tr>
															<td>{{ $asignacion->ctarea }}</td>
															<td title="{{ $asignacion->tarea->ntarea }}">{{ str_limit($asignacion->tarea->ntarea, 30 ,$end="...") }}</td>
															<td>{{ $asignacion->user }}</td>
															<td>{{ $asignacion->usuario->persona->nombreCompleto() }}</td>
															<td>{{ $asignacion->ctirelacion }}</td>
															<td>{{ $asignacion->relacion->ntirelacion }}</td>
															<td> @if( $asignacion->ifhecha ) Si @else No @endif </td>
															<td></td>
															<td></td>
														</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
							</div>
						</div>
						<div id="tabla_compromisos" class="tab-pane fade">
							<div class="col-md-12">
									<div class="table-responsive col-md-12">
										@if ( Auth::check() && Auth::user()->can('task.crud') )

										@else
											<p>No Tiene Permisos Para Agregar Compromisos</p>
										@endif
										<form id="nuevas_tareas">
											<table class="table text-center" width="100%">
												<tbody>
													<tr>
														<td >
															<div class="form-group">
																<label for="tarea_cplan" class="col-sm-2 control-label">Nombre Tarea</label>
																<div class="col-sm-10">
																	<input required type="text" class="form-control" id="tarea_ntarea" name="tarea[ntarea]" placeholder="Nombre Tarea">
																</div>
															</div>
														</td>
													</tr>
													<tr>
														<td >
															<div class="form-group">
																<label for="tarea_cplan" class="col-sm-2 control-label">Prod. Min</label>
																<div class="col-sm-10">
																	<div class="input-group">
																		<input required type="text" class="form-control" id="tarea_cplan" name="tarea[cplan]" placeholder="Producto Minimo">
																		<span class="input-group-addon" data-find-plan data-type-plan="4" data-find-treetask data-input-reference="#tarea_cplan"><i class="fa fa-search"></i></span>
																	</div>
																</div>
															</div>
														</td>
													</tr>
													<tr>
														<td>
															@if ( Auth::check() && Auth::user()->can('task.crud') )
																<div class="form-group row">
																		<button id="agregar" type="submit" class="btn btn-info">
																			<i class="glyphicon glyphicon-plus"></i>
																		</button>
																</div>
															@endif
														</td>
													</tr>
												</tbody>
											</table>
											<div class="col-md-12">
												<table id="nuevas" width="100%" class="table table-bordered tabla-hover table-responsive" cellspacing="0">
													<thead>
														<tr>
															<th>Tarea</th>
															<th>cplan</th>
															<th>Producto Minimo</th>
															<th>Editar</th>
															<th>Borrar</th>
														</tr>
													</thead>

													<tbody>
													</tbody>
												</table>
											</div>
										</form>
									</div>
							</div>
						</div>
					</div>
				</div>
			<div class="modal-footer">
						<button type="submit" class="btn btn-primary" form="form_crear_acta" form="nuevas_tareas">
							<i class="glyphicon glyphicon-plus"></i> Guardar
						</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">
							<i class="glyphicon glyphicon-remove"></i> Cancelar
						</button>
					</div>
			</div>
		</div>
	</div>

	<!-- The template to display files available for upload -->
	<script id="template-upload" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
			<tr class="template-upload fade">
				<td>
					<span class="preview" width="100px"></span>
				</td>
				<td>
					<p class="name">{%=file.name%}</p>
					<strong class="error text-danger"></strong>
				</td>
				<td>
					<p class="size">Processing...</p>
					<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
				</td>
				<td>
					{% if (!i && !o.options.autoUpload) { %}
						<button class="btn btn-primary start" disabled>
							<i class="glyphicon glyphicon-upload"></i>
							<span>Subir</span>
						</button>
					{% } %}
					{% if (!i) { %}
						<button class="btn btn-warning cancel">
							<i class="glyphicon glyphicon-ban-circle"></i>
							<span>Cancelar</span>
						</button>
					{% } %}
				</td>
			</tr>
		{% } %}
	</script>
	<!-- The template to display files available for download -->
	<script id="template-download" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
			<tr class="template-download fade">
				<td width="100px">
					<span class="preview" >
						{% if (file.thumbnailUrl) { %}
							<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img width="100%" src="{%=file.thumbnailUrl%}"></a>
						{% } %}
					</span>
				</td>
				<td>
					<label for="">Nombre</label>
					<input class="form-control" placeholder="Nombre" type="text" name="nombre" value="{%=file.nombre%}" data-evidencia="{%=file.evidencia%}" onchange="setdataEvidencia(this.dataset.evidencia,this.name,this.value)">
				</td>
				<td>
					<label for="">Descripción</label>
					<textarea class="form-control" placeholder="Descripción" type="text" name="descripcion" data-evidencia="{%=file.evidencia%}" onchange="setdataEvidencia(this.dataset.evidencia,this.name,this.value)"></textarea>
				</td>
				<td>
					<p class="name">
						{% if (file.url) { %}
							<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
						{% } else { %}
							<span>{%=file.name%}</span>
						{% } %}
					</p>
					{% if (file.error) { %}
						<div><span class="label label-danger">Error</span> {%=file.error%}</div>
					{% } %}
				</td>

			</tr>
		{% } %}
	</script>

@endsection

@section('scripts')

	<script type="text/javascript">

		$(".files_checklist").fileinput({
			'language': 'es',
			'previewFileType':'any',
			'showPreview' : false,
			'showUpload' : false,
		})

		function storeEvidenciaChecklist(input){
			if ( input.files.length != 0 ){
				var data = new FormData();
				$.each(input.files, function(i, file) {
					data.append('files[]', file);
				});

				var url = "{{ URL::route('POST_store_evidence_answer',['cactividad' => 'cactividad', 'cpregunta' => 'cpregunta']) }}"

				$.ajax({
					url: url.set("cactividad",input.dataset.cactividad).set("cpregunta",input.dataset.cpregunta),
					data: data,
					cache: false,
					contentType: false,
					processData: false,
					type: 'POST',
					success: function(data){
						$(input).fileinput('clear');
						alertify.success("El archivo se subi exitosamente.");
					},
					error: function(data){
						alertify.success("Error al subir el archivo.");
					}
				});
			}else{
				alertify.error("No ha seleccionado ningun archivo.");
			}

		}

		function getChecklist(){
			selector = "#preguntas-checklist #pregunta-checklist"
			
			var data = []
			$(selector).toArray().forEach( div => {
				var obj = {}
				obj.cpregunta = $(div).find("[name=cpregunta]").val()
				obj.cpregunta_text = $(div).find("[name=cpregunta]").data("text")

				obj.isOpenQuestion = eval($(div).find("[name=isOpenQuestion]").val())

				obj.anotaciones = $(div).find("[name=anotaciones]").val()

				if ( obj.isOpenQuestion ){
					element = $(div).find("textarea")
					obj.respuesta = element.val()
					obj.respuesta_text = element.data("text")
					if ( typeof obj.respuesta != 'undefined' ) data.push(obj)
				}else{
					element = $(div).find("input[type=radio]:checked")
					obj.copcion = element.val()
					obj.copcion_text = element.data("text")
					if ( typeof obj.copcion != 'undefined' ) data.push(obj)
				}
			})
			return data
		}

		@if($actividad->checklist)
			function guardarChecklist(page){
				waitingDialog.show("Guardando...")
				$.ajax({
					type: "POST",
					url : "{{ URL::route('answer_checklist', ['cactividad' => $actividad->cactividad]) }}",
					data: JSON.stringify({
						answers : getChecklist(page),
						cchecklist : $("#cchecklist").val(),
					}),
					contentType: "application/json",
					dataType: "json",
					success: function(response){
						waitingDialog.hide()
						var msg = response.message
						alertify.success(msg)
					},
					error: function(response){
						waitingDialog.hide()
						alertify.error("Error al guardar el Checklist")
					},
				})
			}
			$("#btn_guardar_checklist").click(function(event){
				guardarChecklist()
				// $("a[href='#tab_tareas']").tab("show")
			})
		@endif

		function validar(response){
			if ( ! response.ok ){
				$("[data-ctarea=" + response.ctarea + "]").prop("checked",false)
			}
		}

		function setdataEvidencia(key,name,value){
			Models.Evidencias.set(key,JSON.stringify([[name,value]]),function(response){
				alertify.success("Evidencia Editada")
			})
		}

		$(function () {
			$('.datetime').datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss',
				defaultDate: moment().format("YYYY-MM-DD HH:mm:ss")
			});
		});

		$('#modalCrearActa').on('shown.bs.modal', function() {
			$("#acta_fhini").val(moment().subtract(1, 'hour').format("YYYY-MM-DD HH:mm:ss"))
			$("#acta_fhfin").val(moment().format("YYYY-MM-DD HH:mm:ss"))
		})

		var cols = {
			ctarea : 0,
			ntarea : 1,
			crespo : 2,
			nrespo : 3,
			ctirela: 4,
			ntirela: 5,
		}
		var colstask = {
			ntarea : 0,
			cplan : 1,
			nplan : 2,
			valor : 3,
		}

		var table= $("#usuarios").DataTable({
			"paging":   true,
			"ordering": false,
			"searching": true,
			"info":     false,
			"language": DTspanish,
			"columnDefs": [{
				"targets": [ cols.ctarea,cols.crespo,cols.ctirela ],
				"visible": false,
			},]
		})

		var tabletask= $("#nuevas").DataTable({
			"paging":   false,
			"ordering": false,
			"searching": false,
			"info":     false,
			"language": DTspanish,
			"columnDefs": [{
				"targets": [ colstask.cplan ],
				"visible": false,
			},]
		})
		$(table).on("ready",function(){ table.add.row() })

	</script>
	<script type="text/javascript">
		$("#nuevas_tareas").on("submit" , function(event){
			event.preventDefault()
			var that = this
			var cactividad = $("#cactividad").val();
			var data = serializeForm(that);
			data.append("actividad",cactividad)
			var cplan = $( "#tarea_cplan" ).val();
			var ntarea = $( "#tarea_ntarea" ).val();
			var nplan = $( "#tarea_cplan" ).val();
			tabletask
				.row.add([ntarea,cplan,nplan,
					"<button type='button' class='editar btn btn-primary' onclick='taskchange(event,this)'>"+
						"<i class='fa fa-pencil-square-o'></i>"+
					"</button>",
					"<button type='button' class='eliminar btn btn-danger' onclick='borrartask(event,this)''>"+
						"<i class='fa fa-trash-o'></i>"+
					"</button>"])
				.draw()
			$(that).trigger("reset")
		})



		$("#usuario_planes").submit(function(event){
			event.preventDefault()
			var that = $(this)
			var ctarea = $( "#tarea option:selected" ).val();
			var cactividad = $("#cactividad").val();

			var user = that.find("#respo").val();
			var ctirelacion = that.find("#tirespo").val();
			var data = {ctarea:ctarea,user:user,ctirelacion:ctirelacion};
			Models.Actividades.asignarTarea(cactividad,data,listar)

		});
		function editar(event,button){
			var data = table.row( $(button).parents("tr")).data();
			table.row( $(button).parents("tr")).remove().draw(false);
			var tarea = $("#tarea").val(data[cols.ctarea]).change();
			var responsable = $("#respo").val(data[cols.crespo]).change();
			var tiresponsable = $("#tirespo").val(data[cols.ctirela]).change();
		}
		function taskchange(event,button){
			var data = tabletask.row($(button).closest("tr")).data();
			tabletask.row( $(button).closest("tr")).remove().draw(false);
			$("#tarea_ntarea").val(data[colstask.ntarea]).change();
			$("#tarea_cplan").val(data[colstask.nplan]).change();
		}
		function borrartask(event,button){
			tabletask.row( $(button).parents("tr")).remove().draw(false);
		}
		function borrar(event,button){

			var ctarea = table.row($(button).closest("tr")).data()[cols.ctarea]

			var cactividad = $("input#cactividad").val();

			Models.Actividades.removerTarea(cactividad,ctarea,function(){
				table.row( $(button).parents("tr")).remove().draw(false);
			})
		}
		var listar = function(){
			var ctarea = $( "#tarea option:selected" ).val();
			var cresponsable = $( "#respo option:selected" ).val();
			var ctirespo = $( "#tirespo option:selected" ).val();
			var ntarea = $( "#tarea option:selected" ).text();
			var nresponsable = $( "#respo option:selected" ).text();
			var ntirespo = $( "#tirespo option:selected" ).text();
			table
				.row.add([ctarea,ntarea,cresponsable,nresponsable,ctirespo,ntirespo,"No",
					"<button type='button' class='editar btn btn-primary' onclick='editar(event,this)'>"+
						"<i class='fa fa-pencil-square-o'></i>"+
					"</button>",
					"<button type='button' class='eliminar btn btn-danger' onclick='borrar(event,this)''>"+
						"<i class='fa fa-trash-o'></i>"+
					"</button>"])
				.draw()
		}
		var base_url_print_acta = "{{ URL::route('GET_pdf_acta',['numeroacta'=>'__numeroacta__']) }}"
		$("#form_crear_acta").submit(function(event){
			event.preventDefault()
			var that = this

			var data = serializeForm(that)

			data.append("acta[cactividad]",$("#cactividad").val())

			table.data().toArray().forEach( function(element, index) {
				data.append("acta[asistentes][]",element[cols.crespo])
			});
			$.ajax({
				type : "POST",
				url : "{{ URL::action('ActasController@create') }}",
				data:data,
				cache:false,
				contentType: false,
				processData: false,
				success : function(response){
					alertify.success("El Acta se ha creado.")
					var data = tabletask.data().toArray();
					window.open(base_url_print_acta.set("__numeroacta__",response.obj.numeroacta))
					$("#modalCrearActa").modal("hide")
					$(that).find(":input").attr("disabled",true)

					$("#btn_crear_acta").replaceWith(`<div class="alert alert-warning">
															El acta de esta actividad ya se ha creado. Para ver el acta ir a Resumen.
														</div>`)

					data.forEach(function(item){

						var data_request = new FormData()
						data_request.append("tarea[cplan]",item[colstask.cplan])
						data_request.append("tarea[ntarea]",item[colstask.ntarea])

						$.ajax({
							type: "POST",
							url:  "{{ URL::action('TareasController@create') }}",
							data: data_request,
							cache:false,
							contentType: false,
							processData: false,
							success : function(){
								alertify.success("Compromisos agregados");
							},
							error : function(){
								alertify.error(Models.Planes.message.create.error);
							},
						})
					})
				},
				error : function(){
					alertify.error(Models.Planes.messages.create.error)
				},
			})
		})
	</script>
	<!--[if (gte IE 8)&(lt IE 10)]>
	<script src="js/cors/jquery.xdr-transport.js"></script>
	<![endif]-->
@endsection
