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
				<form id="form_crear_actividad" >
					<div class="row modal-body">

						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

						<div class="col-md-6">
							<div class="form-group row">
								<label for="plan_nombre" class="col-sm-2 col-form-label">Nombre</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="plan_nombre" name="plan[nplan]" placeholder="Nombre">
								</div>
							</div>

							<div class="form-group row">
								<label for="" class="col-sm-2 col-form-label">Objetivos</label>
								<div class="col-sm-10">
									<textarea class="form-control" id="" name="plan[]"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group row">
								<label for="" class="col-sm-4 col-form-label">Tipo Actividad</label>
								<div class="col-sm-8">
									<select name="" id="">
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
											<input type='text' class="form-control" />
											<span class="input-group-addon">
												<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>
									</div>

									<div class="form-group row">
										<label for="" class="col-sm-4 col-form-label">Fecha Final</label>
										<div class='col-sm-8 input-group date'>
											<input type='text' class="form-control" />
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
													<input class="form-check-input" type="checkbox" name="plan[ifarchivos]"> Archivos
												</label>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-sm-2"></label>
										<div class="col-sm-10">
											<div class="form-check">
											<label class="form-check-label">
												<input class="form-check-input" type="checkbox" name="plan[ifacta]"> Acta
											</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<div class="row">
					<div class="col-md-12">
						<div class="table-responsive col-md-12">
							<table>
								<tbody>
									<tr>
										<td>
											<select name="" id="tarea">
												<option value="">Tareas</option>}
												@foreach ($tareas as $tarea)
	    											<option value="{{$tarea->cplan}}">{{$tarea->ntarea}}</option>
												@endforeach

											</select>
										</td>
										<td>
											<select name="" id="respo" >
												<option value="">Responsable</option>
												@foreach ($responsables as $responsable)
													<option value = "{{$responsable->cpersona}}">{{$responsable->nombres}} {{$responsable->apellidos}}</option>
												@endforeach
											</select>
										</td>
										<td>
											<select name="" id="tirespo" >
												<option value="">Tipo de responsabilidad</option>
												@foreach ($relaciones as $relacion)
													<option value = "{{$relacion->ctirelacion}}">{{$relacion->ntirelacion}}</option>
												@endforeach
											</select>
										</td>
										<td>
											<button id="agregar" type="button" class="btn btn-info">
												<i class="glyphicon glyphicon-plus"></i>
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="container-fluid">
						
						<div class="col-md-12">
							<div class="table-responsive col-md-12">
								<table id="usuarios" class="table table-bordered tabla-hover" cellspacing="0">
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

					</div>
						


					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">
							<i class="glyphicon glyphicon-remove"></i> Cancelar
						</button>
						<button type="submit" class="btn btn-success">
							<i class="glyphicon glyphicon-plus"></i> Crear
						</button>
					</div>
				</form>
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
		var table= $("#usuarios").DataTable({
			"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
            },
            {
                "targets": [ 2 ],
                "visible": false
            },
            {
                "targets": [ 4 ],
                "visible": false
            }
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

			// Array
			var plan = $('#treeview').jstree('get_selected',true)[0]

			if ( plan ) {
				/*
				if( plan.li_attr.nivel == Niveles.productoMinimo ){

				}else{
					return alertify.error(Models.Planes.messages.validation.notSelectCorrectParent)
				}
				*/
			}else{
				return alertify.error(Models.Planes.messages.validation.notSelection)
			}

			var formData = new FormData(that);
			$('input[type=file]').each(function(i, file) {
				$.each(file.files, function(n, file) {
					formData.append('file-'+i, file);
				})
			})

			$.ajax({
				type : "POST",
				url : "{{ action('PlanesController@create') }}",
				data:formData,
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
					$("#modalCrearActividad").modal("hide")
					alertify.error(Models.Planes.messages.create.error)
				},
			})
		})

		Models.Planes.treeview(function(response){
			console.info(response)
			$('#treeview').jstree({
				'core' : { 'data' : response }
			})
		})

	</script>


<script type="text/javascript">
$("#agregar").on("click" , function(){
	listar();
});

var listar = function(){
var ctarea = $( "#tarea option:selected" ).val();
var cresponsable = $( "#respo option:selected" ).val();
var ctirespo = $( "#tirespo option:selected" ).val();
var ntarea = $( "#tarea option:selected" ).text();
var nresponsable = $( "#respo option:selected" ).text();
var ntirespo = $( "#tirespo option:selected" ).text();


//$("#tarea").val()
table
	.row.add([ctarea,ntarea,cresponsable,nresponsable,ctirespo,ntirespo,"<button type='button' class='editar btn btn-primary'><i class='fa fa-pencil-square-o'></i></button>","<button type='button' class='eliminar btn btn-danger' data-toggle='modal' data-target='#modalEliminar' ><i class='fa fa-trash-o'></i></button>"])
	.draw()
}
</script>
@endsection
