@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('jstree/css/themes/default/style.min.css') }}" >

@endsection


@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				Planes <small>Vista General</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active">
					<i class="fa fa-dashboard"></i> Planes
				</li>

			</ol>
		</div>
	</div>

	<div class="modal fade" id="modalCrearActividad" tabindex="-1" role="dialog" aria-labelledby="modalCrearActividadLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h2 class="modal-title" id="modalCrearActividadLabel">Crear Actividad</h2>
				</div>
				<div class="row modal-body">
					<form id="form_crear_actividad" class="form-horizontal">

						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

						<div class="col-md-6">
							<div class="form-group row">
								<label for="plan_nombre" class="col-sm-2 col-form-label">Nombre</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="plan_nombre" name="actividad[nactividad]" placeholder="Nombre">
								</div>
							</div>

							<div class="form-group row">
								<label for="" class="col-sm-2 col-form-label">Objetivos</label>
								<div class="col-sm-10">
									<textarea class="form-control" id="" name="actividad[descripcion]"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="" class="col-sm-4 col-form-label">Tipo Actividad</label>
								<div class="col-sm-8">
									<select name="actividad[ctiactividad]" id="" class="form-control">
										<option value="">Seleccione el tipo de actividad</option>
										@foreach ($tiactividades as $tiactividad)
											<option value="{{$tiactividad->ctiactividad}}">{{$tiactividad->ntiactividad}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div>
								<div class="col-md-8">

									<div class="form-group row">
										<label for="" class="col-sm-4 col-form-label">Fecha Final</label>
										<div class='col-sm-8 input-group date'>
											<input type='text' class="form-control" name="actividad[fini]"/>
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>

									<div class="form-group row">
										<label for="" class="col-sm-4 col-form-label">Fecha Final</label>
										<div class='col-sm-8 input-group date'>
											<input type='text' class="form-control" name="actividad[ffin]"/>
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
													<input class="form-check-input" type="checkbox" name="actividad[ifarchivos]"> Archivos
												</label>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-2"></label>
										<div class="col-sm-10">
											<div class="form-check">
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" name="actividad[ifacta]"> Acta
											</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive col-md-12">
							<form id="usuario_planes">
								<table class="table">
									<tbody>
										<tr>
											<td width="50%">
												<div class="input-group">
													<select name="tareasusuarios[ctarea]" id="tarea" required class="form-control">
														<option value="">Tareas</option>}
														@foreach ($tareas as $tarea)
															<option value="{{$tarea->cplan}}">{{$tarea->ntarea}}</option>
														@endforeach
													</select>
													<span class="input-group-addon" data-find-task data-input-reference="#tarea"><i class="fa fa-search"></i></span>
												</div>
											</td>
											<td width="25%">
												<select name="tareasusuarios[user]" id="respo" required class="form-control">
													<option value="">Responsable</option>
													@foreach ($usuarios as $usuario)
														<option value = "{{$usuario->id}}">{{$usuario->persona->nombres}} {{$usuario->persona->apellidos}} ( {{$usuario->name}} )</option>
													@endforeach
												</select>
											</td>
											<td width="25%">
												<select name="tareasusuarios[ctirelacion]" id="tirespo" required class="form-control" >
													<option value="">Tipo de responsabilidad</option>
													@foreach ($relaciones as $relacion)
														<option value = "{{$relacion->ctirelacion}}">{{$relacion->ntirelacion}}</option>
													@endforeach
												</select>
											</td>
											<td>
												<button id="agregar" type="submit" class="btn btn-info">
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
							</table>
						</div>

					</div>



					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">
							<i class="glyphicon glyphicon-remove"></i> Cancelar
						</button>
						<button type="submit" class="btn btn-success" form="form_crear_actividad">
							<i class="glyphicon glyphicon-plus"></i> Crear
						</button>
					</div>
			</div>
		</div>
	</div>

	<div class="row">

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Planes
					<div class="pull-right">
						<button type="button" class="btn btn-primary " data-toggle="modal" data-target="#modalCrearActividad">
							<i class="glyphicon glyphicon-plus"></i>
							Nueva Actividad
						</button>
					</div>
				</div>

				<div class="panel-body">
					<div id="treeview" class="demo"></div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ URL::asset('DataTables-1.10.14/media/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::asset('DataTables-1.10.14/media/js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ URL::asset('DataTables-1.10.14/extensions/Buttons/js/buttons.bootstrap.min.js') }}"></script>
	<script src="{{ URL::asset('DataTables-1.10.14/extensions/Buttons/js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript">
	$(function () {
		$('.date').datetimepicker({
			format: 'YYYY/MM/DD',
			defaultDate: moment().format("YYYY/MM/DD")
		});
	});
</script>
	<script src="{{ URL::asset('jstree/js/jstree.min.js') }}"></script>

	<script>
		$.jstree.defaults.plugins = [ "wholerow", "checkbox" ]
		$.jstree.defaults.checkbox.keep_selected_style = true
		$.jstree.defaults.core.multiple = false
		var idioma_espanol = {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "Último",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
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
			"paging":   false,
			"ordering": false,
			"info":     false,
			"language": idioma_espanol,
			"columnDefs": [
				{
					"targets": [ cols.ctarea,cols.crespo,cols.ctirela ],
					"visible": false,
				},
			]

			//editar("#usuarios tbody");
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
				type : "POST",
				url : "{{ action('ActividadesController@create') }}",
				data:serializeForm(that),
				cache:false,
				contentType: false,
				processData: false,
				success : function(){
					$("#modalCrearActividad").modal("hide")
					alertify.success(Models.Planes.messages.create.success)
					$('#treeview').jstree("destroy")
					Models.Planes.treeview(function(response){
						$('#treeview').jstree({ 'core' : {'data' : response } })
					})
				},
				error : function(){
					//$("#modalCrearActividad").modal("hide")
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
	var that = this
	event.preventDefault()
	var base_url_add_user_tarea = "{{ URL::route('POST_users_task' , ['ctarea' => '__ctarea__'])}}"
	$.ajax({
		"url":base_url_add_user_tarea.set("__ctarea__",1),
		"type":"POST",
		data: serializeForm(that),
		cache:false,
		contentType: false,
		processData: false,
		success: function(){
			listar();
		}
	})
});
function editar(event,button){
	var data = table.row( $(button).parents("tr")).data();
	table.row( $(button).parents("tr")).remove().draw(false);
	var tarea = $("#tarea").val(data[cols.ctarea]).change();
	var responsable = $("#respo").val(data[cols.crespo]).change();
	var tiresponsable = $("#tirespo").val(data[cols.ctirela]).change();
	console.log(tarea)
	console.log(data)
}
function borrar(event,button){
	table.row( $(button).parents("tr")).remove().draw(false);
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
