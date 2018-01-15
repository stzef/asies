@extends('layouts.app')

@section('styles')
@endsection


@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1 contenteditable="true" id="check_name">Checklist Sin Nombre</h1>
		</div>
		<div class="col-md-6">	
			<label class="label-control" for="cactividad">Actividad: </label>
			<select name="cactividad" id="cactividad" class="form-control" required>
				<option value="">Seleccione...</option>
				@foreach($actividades as $actividad)
				<option value="{{$actividad->cactividad}}">{{$actividad->nactividad}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="row" id="questions">
		<div class="row" id="question1">
			<hr size="50">
			<div class="col-md-12 text-right">
				<button class="btn btn-danger" onclick="RemoveQuestion(question1)">X</button>
			</div>
			<div class="col-md-12">
				<div class="col-md-6">
					<div class="col-md-6">
						<h3 contenteditable="true" style="padding-top: 8px;" id="detalle1">Pregunta 1</h3> 
					</div>
					<div class="col-md-6 text-left" style="padding-top: 19px;">
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalQuestions"><span class="glyphicon glyphicon-search" aria-hidden="true"></button>
					</div>
				</div>
				<div class="col-md-6">
					<label class="label-control" for="cactividad">Tipo Pregunta: </label>
					<select name="ctipregunta1" id="ctipregunta1" class="form-control" required>
						@foreach($tipreguntas as $tipregunta)
						<option value="{{$tipregunta->ctipregunta}}">{{$tipregunta->detalle}}</option>
						@endforeach
					</select>	

				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<hr size="50">
		<div class="col-md-12 text-center">
			<button class="btn btn-info" onclick="AddQuestion()">+</button>
		</div>
		
	</div>
	<div class="row">
		<hr size="30">
		<div class="col-md-12 text-center">
			<button class="btn btn-success" onclick="save()">Guardar</button>		
		</div>
	</div>
</div>
<div id="modalQuestions" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Fechas de Aplicación</h4>
			</div>
			<div class="modal-body">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<table class="table table-bordered tabla-hover table-responsive">
								<thead>
									<tr>
										<th>Id</th>
										<th>Enunciado</th>
										<th>Seleccionar</th>
									</tr>
								</thead>
								<tbody>
									@foreach($preguntas as $pregunta)
									<tr>
										<td>{{$pregunta->cpregunta}}</td>
										<td>{{$pregunta->enunciado}}</td>
										<td>
											<div class="col-md-12 text-center">
												<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></button>	 
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	i = 2;
	preguntas = []
	data = []
    var table = $(".table").DataTable({
        "paging":   true,
        "ordering": true,
        "info":     true,
        "searching":true,
        "language": DTspanish,
    })
	function AddQuestion(){
		var structure ='<div class="row" id="question'+i+'""><hr size="50"><div class="col-md-12 text-right"><button class="btn btn-danger" onclick="RemoveQuestion(question'+i+')">X</button></div><div class="col-md-12"><div class="col-md-6"><div class="col-md-6"><h3 contenteditable="true" style="padding-top: 8px;" id="detalle1">Pregunta '+i+'</h3></div><div class="col-md-6 text-left" style="padding-top: 19px;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalQuestions"><span class="glyphicon glyphicon-search" aria-hidden="true"></button></div></div><div class="col-md-6"><label class="label-control" for="cactividad">Tipo Pregunta: </label><select name="ctipregunta'+i+'" id="ctipregunta'+i+'" class="form-control" required>						@foreach($tipreguntas as $tipregunta) <option value="{{$tipregunta->ctipregunta}}">{{$tipregunta->detalle}}</option> @endforeach </select></div></div></div>'
		$("#questions").append(structure);
		i++
	}
	function RemoveQuestion(question){
		$(question).remove();
		i--
	}
	function save(){
		for (var x = 1; x < i; x++) {
			preguntas.push({"enunciado" : $("#detalle"+x).text() , "ctipregunta" : $("#ctipregunta"+x).val()})
		}
		data.push({"checklist" : $("#check_name").text(),"cactividad" : $("#cactividad").val(), "preguntas" : preguntas})
		data = JSON.stringify(data)
		$.ajax({
			url:"/checklist/save/",
			type:"POST",
			data: data,
			cache:false,
			contentType: 'application/json',
			processData: false,
			success : function(){
			},	
			error : function(response){
			}
		})
	}
</script>
@endsection