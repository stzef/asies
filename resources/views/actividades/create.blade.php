@extends('layouts.app')

@section('styles')

@endsection


@section('content')

	<div class="row">

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Actividad</h4>
				</div>
			</div>

			<div>
				<form id="form_crear_actividad" class="form-horizontal">

					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					<input type="hidden" name="actividad[cactividad]" value="@if( $actividad){{ $actividad->cactividad }}@endif" id="actividad_cactividad">

					<div class="col-md-6">
						<div class="form-group row">
							<label for="plan_nombre" class="col-sm-2 col-form-label">Nombre</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="plan_nombre" name="actividad[nactividad]" value="@if( $actividad){{ $actividad->nactividad }}@endif" required placeholder="Nombre">
							</div>
						</div>

						<div class="form-group row">
							<label for="" class="col-sm-2 col-form-label">Objetivos</label>
							<div class="col-sm-10">
								<textarea class="form-control" id="" name="actividad[descripcion]" required>@if( $actividad){{ $actividad->descripcion }}@endif</textarea>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group row">
							<label for="" class="col-sm-4 col-form-label">Tipo Actividad</label>
							<div class="col-sm-8">
								<select name="actividad[ctiactividad]" id="" required class="form-control">
									<option value="">Seleccione el tipo de actividad</option>
									@foreach ($tiactividades as $tiactividad)
										<option value="{{$tiactividad->ctiactividad}}" @if( $actividad) @if($actividad->ctiactividad == $tiactividad->ctiactividad) selected @endif @endif >{{$tiactividad->ntiactividad}}</option>
									@endforeach
								</select>
							</div>
						</div>

						<div>
							<div class="col-md-8">

								<div class="form-group row">
									<label for="" class="col-sm-4 col-form-label" >Fecha Inicial</label>
									<div class='col-sm-8 input-group date'>
										<input type='text' class="form-control" name="actividad[fini]" value="@if( $actividad){{ $actividad->fini }}@endif" required />
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-4 col-form-label">Fecha Final</label>
									<div class='col-sm-8 input-group date'>
										<input type='text' class="form-control" name="actividad[ffin]" value="@if( $actividad){{ $actividad->ffin }}@endif" required />
										<span class="input-group-addon">
											<span class="glyphicon glyphicon-calendar"></span>
										</span>
									</div>
								</div>

							</div>

							<div class="col-md-4">
								<div class="form-group row">
									<label class="col-sm-2"></label>
									<div class="col-sm-10">
										<div class="form-check">
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" name="actividad[ifarchivos]" id="actividad_ifarchivos" @if( $actividad) @if( $actividad->ifarchivos ) checked @endif @endif> Archivos
											</label>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-2"></label>
									<div class="col-sm-10">
										<div class="form-check">
										<label class="form-check-label">
											<input class="form-check-input" type="checkbox" name="actividad[ifacta]" id="actividad_ifacta" @if( $actividad) @if( $actividad->ifacta ) checked @endif @endif> Acta
										</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
				<div class="section_asignacion_tareas ">
					<div class="col-md-12">
						<div class="table-responsive col-md-12">
							<form id="usuario_planes">
								<table class="table text-center">
									<tbody>
										<tr>
											<td >
												<div class="input-group">
													<div>
														<select-task required="required" name="tareasusuarios[ctarea]" id="tarea" :productos_minimos="productos_minimos" @mounted="getTask" />
													</div>
													<span class="input-group-addon" data-find-task="true" data-find-treetask data-input-reference="#tarea"><i class="fa fa-search"></i></span>
												</div>
											</td>
										</tr>
										<tr>
											<td >
												<div>
													<select  name="tareasusuarios[user]" id="respo" required class="form-control selectFind">
														<option value="">Responsable</option>
														@foreach ($usuarios as $usuario)
															<option value = "{{$usuario->id}}">{{$usuario->persona->nombres}} {{$usuario->persona->apellidos}}</option>
														@endforeach
													</select>
												</div>
											</td>
										</tr>
										<tr>
											<td >
												<select  name="tareasusuarios[ctirelacion]" id="tirespo" required class="form-control" >
													<option value="">Tipo de responsabilidad</option>
													@foreach ($relaciones as $relacion)
														<option value = "{{$relacion->ctirelacion}}">{{$relacion->ntirelacion}}</option>
													@endforeach
												</select>
											</td>
										</tr>
										<tr>

											<td>
												<button  id="agregar" type="submit" class="btn btn-info">
													<i class="glyphicon glyphicon-plus"></i>
												</button>
											</td>
										</tr>
									</tbody>
								</table>
							</form>
						</div>
					</div>
					<div class="col-md-12">
						<table id="usuarios" class="table table-bordered tabla-hover table-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>ctarea</th>
									<th>Tarea</th>
									<th>cusu</th>
									<th>Responsable</th>
									<th>ctirelacion</th>
									<th>Responsabilidad</th>
									<th> </th>
									<th> </th>
								</tr>
							</thead>
							<tbody>
								@if ( $actividad )
									@foreach ( $actividad->getAsignacion() as $asignacion )
										<tr>
											<td> {{ $asignacion->tarea->ctarea }} </td>
											<td> {{ $asignacion->tarea->ntarea }} </td>
											<td> {{ $asignacion->usuario->id }} </td>
											<td> {{ $asignacion->usuario->persona->nombreCompleto() }} </td>
											<td> {{ $asignacion->relacion->ctirelacion }} </td>
											<td> {{ $asignacion->relacion->ntirelacion }} </td>
											<td>
												<button type='button' class='editar btn btn-primary' onclick='editar(event,this)'>
													<i class='fa fa-pencil-square-o'></i>
												</button>
											</td>
											<td>
												<button type='button' class='eliminar btn btn-danger' onclick='borrar(event,this)'>
													<i class='fa fa-trash-o'></i>
												</button>
											</td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div>

				</div>


				<div class="text-center">

					<a type="button" class="btn btn-danger" href="{{ URL::route('app_dashboard') }}" data-dismiss="modal">
						<i class="glyphicon glyphicon-remove"></i> Cancelar
					</a>
					@if ( $action == "create" )
						<button type="submit" class="btn btn-success" form="form_crear_actividad">
							<i class="glyphicon glyphicon-plus"></i>
							Crear
						</button>
					@else
						<button type="submit" class="btn btn-success" form="form_crear_actividad">
							<i class="glyphicon glyphicon-pencil"></i>
							Editar
						</button>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		$(function () {
			$('.date').datetimepicker({
				format: 'YYYY-MM-DD hh:mm:ss',
				defaultDate: moment().format("YYYY-MM-DD hh:mm:ss")
			});
		});
	</script>

	<script>
		$.jstree.defaults.plugins = [ "wholerow", "checkbox" ]
		$.jstree.defaults.checkbox.keep_selected_style = true
		$.jstree.defaults.core.multiple = false

		if ( CRUD_ACTION == "create" ){
			$("#usuario_planes").find(":input").prop("disabled",true)
			$("#actividad_ifarchivos").attr("checked",true)
			$("#actividad_ifacta").attr("checked",true)

			$(".section_asignacion_tareas").addClass("hide")
		}

		var cols = {
			ctarea : 0,
			ntarea : 1,
			crespo : 2,
			nrespo : 3,
			ctirela: 4,
			ntirela: 5,
		}
		var table= $("#usuarios").DataTable({
			"paging":   true,
			"ordering": true,
			"info":     false,
			"searching":false,
			"language": DTspanish,
			"columnDefs": [
				{
					"targets": [ cols.ctarea,cols.crespo,cols.ctirela ],
					"visible": false,
				},
			]
		})
		function getPlanSelect(){
			var plan = $('#treeview').jstree('get_selected',true)
		}
		function crearActividad(){
			$("#modalCrearActividad").modal("show")
		}
		$("#form_crear_actividad").submit(function(event){
			event.preventDefault()
			var that = this

			$.ajax({
				url : "{{ $ajax['url'] }}",
				type : "{{ $ajax['method'] }}",
				data : serializeForm(that),
				cache : false,
				contentType : false,
				processData : false,
				success : function(response){

					if ( CRUD_ACTION == "create" ){
						$("#form_crear_actividad").find(":input").prop("disabled",true)
						$("input#actividad_cactividad").val(response.obj.cactividad)
						$("[type=submit]").attr("disabled",true)
					}

					$("#usuario_planes").find("[disabled]").prop("disabled",false)
					$(".section_asignacion_tareas").removeClass("hide")

					alertify.success(Models.Planes.messages.create.success)

				},
				error : function(){
					alertify.error(Models.Planes.messages.create.error)
				},
			})
		})
		Models.Planes.treeview(function(response){
			$('#treeview').jstree({
				'core' : { 'data' : response }
			})
		})
	</script>


<script type="text/javascript">
	$("#usuario_planes").on("submit" , function(event){
		event.preventDefault()
		var that = this
		var ctarea = $( "#tarea option:selected" ).val();
		var cactividad = $("input#actividad_cactividad").val();


		var user = $(that).find("#respo").val()
		var ctirelacion = $(that).find("#tirespo").val()
		Models.Actividades.asignarTarea(cactividad,{ ctarea: ctarea, user: user, ctirelacion: ctirelacion },function(){
			listar()
		})
	});
	function editar(event,button){
		var data = table.row( $(button).parents("tr")).data();
		table.row( $(button).parents("tr")).remove().draw(false);
		var tarea = $("#tarea").val(data[cols.ctarea]).change();
		var responsable = $("#respo").val(data[cols.crespo]).change();
		var tiresponsable = $("#tirespo").val(data[cols.ctirela]).change();
	}
	function borrar(event,button){

		var ctarea = table.row($(button).closest("tr")).data()[cols.ctarea]
		var cactividad = $("input#actividad_cactividad").val();

		Models.Actividades.removerTarea(cactividad,{ ctarea: ctarea },function(){
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
		//$("#tarea").val()
		table
			.row.add([ctarea,ntarea,cresponsable,nresponsable,ctirespo,ntirespo,
				"<button type='button' class='editar btn btn-primary' onclick='editar(event,this)'>"+
					"<i class='fa fa-pencil-square-o'></i>"+
				"</button>",
				"<button type='button' class='eliminar btn btn-danger' onclick='borrar(event,this)''>"+
					"<i class='fa fa-trash-o'></i>"+
				"</button>"])
			.draw()
	}
</script>
@endsection
