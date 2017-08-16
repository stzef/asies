@extends('layouts.app')
@section('styles')
	<!-- Bootstrap styles -->
	<!--<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">-->
	<!-- Generic page styles -->
	<link rel="stylesheet" href="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/css/style.css') }}">
	<!-- blueimp Gallery styles -->
	<link rel="stylesheet" href="https://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
	<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
	<link rel="stylesheet" href="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/css/jquery.fileupload-ui.css') }}">
	<!-- CSS adjustments for browsers with JavaScript disabled -->
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
						</div>
						<div class="col-md-5">
							<a class="btn btn-primary" href="{{ URL::route('GET_resumen_actividad',['cactividad'=>$actividad->cactividad]) }}">Resumen</a>
							<a class="btn btn-danger" href="{{ URL::route('mis_actividades',['user'=>Auth::user()->name]) }}">Salir</a>
						</div>
					</div>
					<div class="label label-info">
						{{ $actividad->fini }}
					</div>
				</div>

				<div class="panel-body">
					<div class="col-md-12">
						<form id="fileupload" action="//jquery-file-upload.appspot.com/" method="POST" enctype="multipart/form-data">
							<input type="hidden" name="cactividad" id="cactividad" value="{{ $actividad->cactividad }}">
							<!-- Redirect browsers with JavaScript disabled to the origin page -->
							<noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
							<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
							<div class="row fileupload-buttonbar">
								<div class="col-md-12">
									<!-- The fileinput-button span is used to style the file input field as button -->
									<span class="btn btn-success fileinput-button">
										<i class="glyphicon glyphicon-plus"></i>
										<span>Agregar Archivos...</span>
										<input type="file" name="files[]" multiple>
									</span>
									<button type="submit" class="btn btn-primary start">
										<i class="glyphicon glyphicon-upload"></i>
										<span>Subir Todos</span>
									</button>
									<button type="reset" class="btn btn-warning cancel">
										<i class="glyphicon glyphicon-ban-circle"></i>
										<span>Carcelar Subida</span>
									</button>
									<!--
									<button type="button" class="btn btn-danger delete">
										<i class="glyphicon glyphicon-trash"></i>
										<span>Delete</span>
									</button>
									<input type="checkbox" class="toggle">
									-->

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
					<div class="col-md-12">
						<div class="row">
							@if ( $actividad->acta )
								<div class="alert alert-warning">
									El acta de esta actividad ya se ha creado. Para ver el acta ir a Resumen.
								</div>
							@else
								@permission('actas.crud')
									<div class="well">
										<button type="button" class="btn btn-primary " id="btn_crear_acta" data-toggle="modal" data-target="#modalCrearActa">
											<i class="glyphicon glyphicon-plus"></i>
											Crear Acta
										</button>
									</div>
								@endpermission

								@if ( $actividad->checklist )
									<div class="well">
										<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modalChecklist">
											<i class="glyphicon glyphicon-plus"></i>
											Checklist
										</button>
									</div>
								@endif

							@endif
							<div class="alert alert-info">
								{{ $actividad->getEvidencias(true) }} Evidencias
							</div>
						</div>

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
									<!--<div class="form-group row">
										<div class="col-sm-12">
											<div class="form-check">
												<label class="form-check-label">
													<input class="form-check-input" onclick="Models.Tareas.cambiarEstado(this.dataset.ctarea,this.checked)" type="checkbox" data-ctarea="{{ $tarea->ctarea }}" name="ctarea_{{ $tarea->ctarea }}" @if ($tarea->ifhecha) checked @endif> {{ $tarea->ntarea }}
												</label>
											</div>
										</div>
									</div>-->
								@endforeach
							</tbody>
						</table>
					</div>

				</div>
			</div>
		</div>
	</div>

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
						<input type="hidden" value="{{ $actividad->checklist->cchecklist }}" id="cchecklist" name="cchecklist">
						<table class="table" id="checklist">
							<thead>
								<tr>
									<th>Pregunta</th>
									<th>Respuesta</th>
									<th>Anotaciones</th>
									<th>Evidencia</th>
								</tr>
							</thead>
							<tbody>
								@foreach( $actividad->checklist->preguntas as $pregunta )
									<tr>
										<td>
											<input type="hidden" name="cpregunta" value="{{ $pregunta->cpregunta }}" data-text="{{ $pregunta->enunciado }}">
											{{ $pregunta->enunciado }}
										</td>
										<td>
											@if ( $pregunta->isOpenQuestion() )
												<input type="hidden" name="isOpenQuestion" value="true">
												<textarea style="resize:none" class="form-control" name="copcion" data-text="Respuesta Abierta">@if($pregunta->respuesta){{$pregunta->respuesta->respuesta}}@endif</textarea>
											@else
												<input type="hidden" name="isOpenQuestion" value="false">
												@foreach($pregunta->opciones as $opcion)
													<div>
														<label for="copcion_{{ $opcion->copcion }}">
															<input
																type="radio"
																name="copcion"
																data-text="{{ $opcion->detalle }}"
																id="copcion_{{ $opcion->copcion }}"
																value="{{ $opcion->copcion }}"
																@if($pregunta->respuesta)
																	@if($pregunta->respuesta->copcion == $opcion->copcion )
																		checked
																	@endif
																@endif
															>
															</input>
															<span>{{ $opcion->detalle }}</span>
														</label>
													</div>
												@endforeach
												<!--
												<select class="form-control" name="copcion">
													@foreach($pregunta->opciones as $opcion)
														<option value="{{ $opcion->id }}"> {{ $opcion->detalle }} </option>
													@endforeach
												</select>
												-->
											@endif
										</td>
										<td>
											<textarea style="resize:none" class="form-control" name="anotaciones" id="anotaciones">@if($pregunta->respuesta){{$pregunta->respuesta->anotaciones}}@endif</textarea>
										</td>
										<td>
											<input type="file" name="evidencia_{{ $pregunta->cpregunta }}" multiple>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					@endif

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="btn_guardar_checklist">
						<i class="glyphicon glyphicon-plus"></i> Guardar
					</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">
						<i class="glyphicon glyphicon-remove"></i> Cancelar
					</button>
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

																<!--<select name="tareasusuarios[ctarea]" id="tarea" required class="form-control">
																	<option value="">Tareas</option>}
																	@foreach ($tareas as $tarea)
																		<option value="{{$tarea->ctarea}}" title="{{$tarea->ntarea}}">{{ str_limit($tarea->ntarea, $limit = 45, $end = '...') }}</option>
																	@endforeach
																</select>-->
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
						<!--<button type="button" class="btn btn-primary">
							<i class="glyphicon glyphicon-print"></i> Imprimir
						</button>-->
						<!--<button type="button" class="btn btn-primary">
							<i class="glyphicon glyphicon-send"></i> Enviar
						</button>-->
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
				<!--<td>
					<input class="form-control" placeholder="Nombre" type="text" name="nombres[]">
				</td>
				<td>
					<input class="form-control" placeholder="Descripcion" type="text" name="descripciones[]">
				</td>-->
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
				<td>
					<span class="size">{%=o.formatFileSize(file.size)%}</span>
				</td>
				<td>
					{% if (file.deleteUrl) { %}
						<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
							<i class="glyphicon glyphicon-trash"></i>
							<span>Delete</span>
						</button>
						<input type="checkbox" name="delete" value="1" class="toggle">
					{% } else { %}
						<button class="btn btn-warning cancel">
							<i class="glyphicon glyphicon-ban-circle"></i>
							<span>Cancel</span>
						</button>
					{% } %}
				</td>
			</tr>
		{% } %}
	</script>

@endsection

@section('scripts')
	<script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/dataTables.bootstrap.min.js') }}"></script>

	<script type="text/javascript">

		function getChecklist(){
			var data = $("#checklist tbody tr").toArray().map( tr => {
				var obj = {}
				obj.cpregunta = $(tr).find("[name=cpregunta]").val()
				obj.cpregunta_text = $(tr).find("[name=cpregunta]").data("text")

				obj.isOpenQuestion = eval($(tr).find("[name=isOpenQuestion]").val())

				obj.anotaciones = $(tr).find("[name=anotaciones]").val()
				obj.files = $(tr).find("input[type=file]")[0].files

				if ( obj.isOpenQuestion ){
					element = $(tr).find("[name=copcion]")
					obj.respuesta = element.val()
					obj.respuesta_text = element.data("text")
				}else{
					element = $(tr).find("[name=copcion]:checked")
					obj.copcion = element.val()
					obj.copcion_text = element.data("text")
				}
				return obj
			})
			return data
		}

		@if($actividad->checklist)
			$("#btn_guardar_checklist").click(function(event){

				$.ajax({
					// cache: false,
					// contentType: 'multipart/form-data',
					// processData: false,


					type: "POST",
					url : "{{ URL::route('answer_checklist', ['cchecklist' => $actividad->checklist->cchecklist]) }}",
					data: JSON.stringify({
						answers : getChecklist(),
						cchecklist : $("#cchecklist").val(),
					}),
					contentType: "application/json",
					dataType: "json",
					success: function(response){
						alertify.success("El Checklist se guardo.")
					},
					error: function(response){
						alertify.error("Error al guardar el Checklist")
					},
				})
			})
		@endif

		function validar(response){
			console.info(response)
			if ( ! response.ok ){
				$("[data-ctarea=" + response.ctarea + "]").prop("checked",false)
			}
		}

		function setdataEvidencia(key,name,value){
			Models.Evidencias.set(key,JSON.stringify([[name,value]]),function(response){
				console.log(response)
				alertify.success("Evidencia Editada")
			})
		}

		$(function () {
			$('.datetime').datetimepicker({
				format: 'YYYY-MM-DD HH:mm:ss',
				defaultDate: moment().format("YYYY-MM-DD HH:mm:ss")
			});

			$('.pregunta_evidencia').fileupload({
				dataType: 'json',
				add: function (e, data) {
					data.context = $('<button/>').text('Upload')
					.appendTo(document.body)
					.click(function () {
					data.context = $('<p/>').text('Uploading...').replaceAll($(this));
					data.submit();
					});
				},
				done: function (e, data) {
					data.context.text('Upload finished.');
				}
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
			console.log(data)
			Models.Actividades.asignarTarea(cactividad,data,listar)

			/*
			var data = serializeForm(that)
			data.append("tareasusuarios[cactividad]",cactividad)
			{{-- var base_url_add_user_tarea = "{{ URL::route('POST_users_task' , ['cactivida' => '__cactividad__','ctarea' => '__ctarea__'])}}" --}}
			$.ajax({
				"url":base_url_add_user_tarea.set("__ctarea__",ctarea).set("__cactividad__",cactividad),
				"type":"POST",
				data: data,
				cache:false,
				contentType: false,
				processData: false,
				success: function(response){
					alertify.success(response.data.message)
					listar();
				},
				error: function(response){
					alertify.error("Algo ha salido mal.")
				}
			})
			*/
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

		/*
		var data = new FormData()
		data.append("tareasusuarios[cactividad]",cactividad)
		data.append("tareasusuarios[ctarea]",ctarea)
		data.append("tareasusuarios[ctirelacion]",ctirelacion)
		data.append("tareasusuarios[user]",cresponsable)

		{{-- var base_url_remove_user_tarea = "{{ URL::route('DELETE_users_task' , ['cactivida' => '__cactividad__','ctarea' => '__ctarea__'])}}" --}}
		$.ajax({
			"url":base_url_remove_user_tarea.set("__ctarea__",ctarea).set("__cactividad__",cactividad),
			"type":"POST",
			data: data,
			cache:false,
			contentType: false,
			processData: false,
			success: function(response){
				table.row( $(button).parents("tr")).remove().draw(false);
				alertify.success(response.data.message)
				//listar();
			},
			error: function(response){
				alertify.error("Algo ha salido mal.")
			}
		})
		*/
	}
	var listar = function(){
		var ctarea = $( "#tarea option:selected" ).val();
		var cresponsable = $( "#respo option:selected" ).val();
		var ctirespo = $( "#tirespo option:selected" ).val();
		var ntarea = $( "#tarea option:selected" ).text();
		var nresponsable = $( "#respo option:selected" ).text();
		var ntirespo = $( "#tirespo option:selected" ).text();
		//$("#tarea").val()
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
						console.log(response)
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
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
	<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
	<script src="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/js/vendor/jquery.ui.widget.js') }}"></script>
	<!-- The Templates plugin is included to render the upload/download listings -->
	<script src="https://blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
	<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
	<script src="https://blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
	<!-- The Canvas to Blob plugin is included for image resizing functionality -->
	<script src="https://blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
	<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
	<!--<script src="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->
	<!-- blueimp Gallery script -->
	<script src="https://blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
	<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
	<script src="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/js/jquery.iframe-transport.js') }}"></script>
	<!-- The basic File Upload plugin -->
	<script src="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload.js') }}"></script>
	<!-- The File Upload processing plugin -->
	<script src="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload-process.js') }}"></script>
	<!-- The File Upload image preview & resize plugin -->
	<script src="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload-image.js') }}"></script>
	<!-- The File Upload audio preview plugin -->
	<script src="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload-audio.js') }}"></script>
	<!-- The File Upload video preview plugin -->
	<script src="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload-video.js') }}"></script>
	<!-- The File Upload validation plugin -->
	<script src="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload-validate.js') }}"></script>
	<!-- The File Upload user interface plugin -->
	<script src="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/js/jquery.fileupload-ui.js') }}"></script>
	<!-- The main application script -->
	<script src="{{ URL::asset('vendor/jQuery-File-Upload-9.18.0/js/main.js') }}"></script>
	<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
	<!--[if (gte IE 8)&(lt IE 10)]>
	<script src="js/cors/jquery.xdr-transport.js"></script>
	<![endif]-->
@endsection
