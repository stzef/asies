@extends('layouts.app')

@section('styles')
@endsection


@section('content')

	<div class="row">

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Tareas
				</div>

				<div class="panel-body">
					<form class="form-horizontal">

						<div class="form-group">
							<label for="tarea_ntarea" class="col-sm-2 control-label">Nombre</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="tarea_ntarea" name="tarea[ntarea]" placeholder="Nombre">
							</div>
						</div>


						<div class="form-group">
							<label for="tarea_cplan" class="col-sm-2 control-label">Prod. Min</label>
							<div class="col-sm-10">
								<div class="input-group">
									<input type="text" class="form-control" id="tarea_cplan" name="tarea[cplan]" placeholder="Producto Minimo">
									<span class="input-group-addon"><i class="fa fa-search" data-find-task data-input-reference="#tarea_cplan"></i></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label for="tarea_valor_tarea" class="col-sm-2 control-label">Valor Tarea</label>
									<div class="col-sm-10">
										<input type="text" class="form-control" id="tarea_valor_tarea" name="tarea[valor_tarea]" placeholder="Valor Tarea">
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10">
										<div class="checkbox">
											<label> <input type="checkbox" name="tarea[ifhecha]"> Hecha </label>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="form-group text-center">

							<a type="button" class="btn btn-danger" href="{{ URL::route('app_dashboard') }}" data-dismiss="modal">
								<i class="glyphicon glyphicon-remove"></i> Cancelar
							</a>
							<button type="submit" class="btn btn-success">
								<i class="glyphicon glyphicon-plus"></i>
								Crear
							</button>

						</div>

					</form>
				</div>
			</div>
		</div>
	</div>


@endsection

@section('scripts')
<script>
	$("form").submit(function(event){
		var that = this
		event.preventDefault()
		$.ajax({
			url:"/tareas/create",
			type:"POST",
			data: serializeForm(that),
			cache:false,
			contentType: false,
			processData: false,
			success:callbackSuccessAjax,
			error:callbackErrorAjax
		})
	})
</script>
@endsection
