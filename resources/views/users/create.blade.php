@extends('layouts.app')

@section('styles')
@endsection


@section('content')
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Crear Usuario</h4>
                </div>
            </div>

			<form class="form-horizontal" id='form-errors'>
				
			</form>
			<form class="form-horizontal" id="crear_usuario" >

				<div class="form-group col-md-6">
					<label for="nombres" class="col-sm-2 control-label">Nombres</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" required id="nombres" name="nombres" placeholder="Nombre" value="@if($persona){{$persona->nombres}}@endif">
					</div>
				</div>

				<div class="form-group col-md-6">
					<label for="apellidos" class="col-sm-2 control-label">Apellidos</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" required id="apellidos" name="apellidos" placeholder="Apellidos" value="@if($persona){{$persona->apellidos}}@endif" >
					</div>
				</div>
				
				<div class="form-group col-md-6">
					<label for="identificacion" class="col-sm-2 control-label">identificacion</label>
					<div class="col-sm-10">
						<input type="number" class="form-control" required id="identificacion" name="identificacion" placeholder="xxxxxxxxxx" value="@if($persona){{$persona->identificacion}}@endif">
					</div>
				</div>

				<div class="form-group col-md-6">
					<label for="direccion" class="col-sm-2 control-label">Direccion</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" required id="direccion" name="direccion" placeholder="Direccion" value="@if($persona){{$persona->direccion}}@endif">
					</div>
				</div>

				<div class="form-group col-md-6">
					<label for="telefono" class="col-sm-2 control-label">Telefono</label>
					<div class="col-sm-10">
						<input type="number" class="form-control" required id="telefono" name="telefono" placeholder="xxxxxxxxxx" value="@if($persona){{$persona->telefono}}@endif">
					</div>
				</div>

				<div class="form-group col-md-6">
					<label for="celular" class="col-sm-2 control-label">Celular</label>
					<div class="col-sm-10">
						<input type="number" class="form-control" required id="celular" name="celular" placeholder="xxxxxxxxxx" value="@if($persona){{$persona->celular}}@endif">
					</div>
				</div>

				<div class="form-group col-md-6">
					<label for="ccargo" class="col-sm-2 control-label">Cargo</label>
					<div class="col-sm-10">
						<select name="ccargo" id="ccargo" class="form-control" required value="@if($persona){{$persona->ccargo}}@endif">
							@foreach($cargos as $cargo)
							<option value="{{$cargo->ccargo}}" @if($persona) @if($cargo->ccargo == $persona->ccargo) selected @endif @endif>{{$cargo->ncargo}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="form-group col-sm-6">
					<label for="ctiempleado" class="col-sm-2 control-label">Tipo de Empleado</label>
					<div class="col-sm-10">
						<select name="ctiempleado" id="ctiempleado" class="form-control" required value="@if($persona){{$persona->ctiempleado}}@endif">
							@foreach($tiempleados as $tiempleado)
								<option value="{{$tiempleado->ctiempleado}}" @if($persona) @if($tiempleado->ctiempleado == $persona->ctiempleado) selected @endif @endif>{{$tiempleado->ntiempleado}}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="form-group col-md-6 text-center">
					<label for="email" class="col-sm-2 control-label">Email</label>
					<div class="col-sm-10">
						<input type="email" class="form-control" required id="email" name="email" placeholder="example@example.com" value="@if($persona){{$persona->email}}@endif">
					</div>
				</div>


				<div class="form-group col-md-6">
					<label for="role_id" class="col-sm-2 control-label">Tipo de usuario</label>
					<div class="col-sm-10">
						<select name="role_id" id="role_id" class="form-control" required>
							@foreach($roles as $role)
								<option value="{{$role->id}}">{{$role->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group col-md-6 text-center">
					<label for="password" class="col-sm-2 control-label">Contraseña</label>
					<div class="col-sm-10">
						<input type="password" class="form-control" required id="password" name="password" placeholder="***********">
					</div>
				</div>
				<div class="form-group col-md-6 text-center">
					<label for="password" class="col-sm-2 control-label">Confirmar Contraseña</label>
					<div class="col-sm-10">
						<input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="***********">
					</div>
				</div>
				<div class="form-group col-md-12 text-center">
					<a type="button" class="btn btn-danger" href="{{ URL::route('list_user') }}" data-dismiss="modal">
						<i class="glyphicon glyphicon-remove"></i> Cancelar
					</a>
					<button type="submit" class="btn btn-success">
						<i class="glyphicon glyphicon-plus"></i>
						Crear
					</button>
				</div>

			</form>
        </div>

@endsection

@section('scripts')
<script>

	if ( CRUD_ACTION == "create" ){
		$(".asig_tareas").addClass("hide")
	}
	@if($persona)
	var route="/users/manage/edit/"+{{$usuario->id}}
	var message="Edicion Exitosa"
	@else
	var route="/users/manage/create"	
	var message="Creacion Exitosa"
	@endif
	$("#crear_usuario").submit(function(event){
		var that = this
		event.preventDefault()
		$.ajax({
			url:route,
			type:"POST",
			data: serializeForm(that),
			cache:false,
			contentType: false,
			processData: false,
			success : function(){
				sucessHtml = '<div class="alert alert-success"><strong>'+message+'</strong></div>'
				$( '#form-errors' ).html( sucessHtml );
				setTimeout(function(){
					window.location.reload(1);
				}, 1000);
			},
			error : function(response){
				var errors = response.responseJSON.errors_form
				console.log(errors)
				errorsHtml = '<div class="alert alert-danger">Errores <ul>';

				$.each( errors, function( key, value ) {
					errorsHtml += '<li>' + key + value[0] + '</li>'; //showing only the first error.
				});
				errorsHtml += '</ul></di>';

				$( '#form-errors' ).html( errorsHtml ); 
				}
		})
	})
</script>
@endsection
