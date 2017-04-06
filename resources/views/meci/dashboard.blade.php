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
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h2 class="modal-title" id="modalCrearActividadLabel">Crear Actividad</h2>
				</div>
				<form id="form_crear_actividad" >
					<div class="modal-body">

						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
						<div class="form-group row">
							<label for="plan_nombre" class="col-sm-2 col-form-label">Nombre</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="plan_nombre" name="plan[nplan]" placeholder="Nombre">
							</div>
						</div>
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
						<div class="form-group row">
							<label class="col-sm-2"></label>
							<div class="col-sm-10">
								<div class="form-check">
									<label class="form-check-label">
										<input class="form-check-input" type="checkbox" name="plan[desc]"> Descripcion
									</label>
								</div>
								<textarea type="text" class="form-control" id="" placeholder="Descripcion" disabled></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2"></label>
							<div class="col-sm-5">
								<div class="form-check">
									<label class="form-check-label">
										<input class="form-check-input" type="checkbox" name="plan[iffechaini]"> Fecha Inicial
									</label>
								</div>
							</div>
							<div class="col-sm-5">
								<input type="text" class="form-control" id="inputEmail3" placeholder="Fecha Inicial" disabled name="plan[fechaini]">
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-2"></label>
							<div class="col-sm-5">
								<div class="form-check">
									<label class="form-check-label">
										<input class="form-check-input" type="checkbox" name="plan[iffechafin]"> Fecha Final
									</label>
								</div>
							</div>
							<div class="col-sm-5">
								<input type="text" class="form-control" id="inputEmail3" placeholder="Fecha Final" disabled name="plan[fechafin]" >
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
	<script src="{{ URL::asset('jstree/js/jstree.min.js') }}"></script>

	<script>


		function crearActividad(){
			$("#modalCrearActividad").modal("show")
		}

		$("#form_crear_actividad").submit(function(event){
			event.preventDefault()

			var that = this

			// Array
			var plan = $('#treeview').jstree('get_selected',true)

			if( !plan.isEmpty() ) {
				if ( plan.lengthIs(1) ) {
					plan = plan[0]
					console.log(plan)
					/*
					if( plan.li_attr.nivel == Niveles.productoMinimo ){

					}else{
						return alertify.error(Models.Planes.messages.validation.notSelectCorrectParent)
					}
					*/
				}else{
					return alertify.error(Models.Planes.messages.validation.multipleSelection)
				}
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
			$('#treeview').jstree({ 'core' : {'data' : response } })
		})

	</script>
@endsection
