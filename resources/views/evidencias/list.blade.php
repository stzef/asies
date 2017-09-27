@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.3/css/select.dataTables.min.css">
<style>
	.item-email-list{
		display: block;
		text-align: left;
		padding: 5px;
		font-size: 14px !important;
	}
</style>
@endsection
@section('content')
	<div id="modalEnviar" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Enviar Evidencia</h4>
		  </div>
		  <div class="modal-body">
			<div>
				<div class="well">
					<div class="row">
						<div class="col-md-10">
							<input type="email" id="candidate" class="form-control" />
						</div>
						<div class="col-md-2">
							<button class="btn btn-success" onclick="addItem()">Agregar</button>
						</div>
					</div>
					<h4>Para : </h4>
					<ul id="email-list"></ul>
				</div>

				<div class="well">
					<h4>Asunto : </h4>
					<div class="row">
						<div class="col-md-12">
							<input type="text" id="asunto" required class="form-control" placeholder="Asunto" />
						</div>
					</div>
				</div>

				<div class="well">
					<textarea id="mensaje" class="form-control" placeholder="Mensaje" /></textarea>
					<h4>Archivos : </h4>
					<ul id="files-list"></ul>
				</div>


				<!--
				<div>
					<input type="checkbox" id="all">
					<label for="all"> Enviar a todos los relacionados</label>
				</div>
				-->
				<!-- <button onclick="removeItem()">Remover</button> -->
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
			<button type="button" onclick="sendEmails()" class="btn btn-success" data-dismiss="modal">Enviar</button>
		  </div>
		</div>

	  </div>
	</div>
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>
					Evidencias
					@if ( $actividad )
						de la Actividad {{ $actividad->nactividad }}
					@endif
				</h4>
			</div>
		</div>
		<table class="evidencias table table-bordered tabla-hover table-responsive" cellspacing="0">
			<thead>
				<tr>
					<th></th>
					<th></th>

					<th></th>
					<th></th>
					<th>Nombre</th>
					<th>Descripción</th>
					@if ( !$actividad )
						<th>Actividad</th>
					@endif
					<th>Fecha</th>
					<th></th>
					<th>
						<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalEnviar">Enviar</button>
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($actas as $acta)
					<tr>
						<td>ACTA</td>
						<td> {{ $acta->idacta }} </td>

						<td></td>
						<td><img width="30px" src="{{ $acta->previewimg }}" alt=""></td>
						<td>{{$acta->numeroacta}}</td>
						<td>  </td>
						@if ( !$actividad )
							<td>
								<a href="{{ route('GET_lista_evidencias',['cactividad'=>$acta->actividad->cactividad]) }}">
									{{ $acta->actividad->cactividad }} - {{ $acta->actividad->nactividad }}
								</a>
							</td>
						@endif
						<td>{{$acta->fhini}}</td>
						<td>
							<!-- <a class="btn btn-primary" href="{{$acta->path}}" download="">Descargar</a> -->
						</td>
						<td>
							<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalEnviar">Enviar</button> -->
						</td>
					</tr>
				@endforeach

				@foreach ($checklists as $checklist)
					<tr>
						<td> CHECKLIST </td>
						<td> {{ $checklist->cchecklist }} </td>

						<td></td>
						<td><img width="30px" src="{{ $checklist->previewimg }}" alt=""></td>
						<td>{{$checklist->nombre}}</td>
						<td>  </td>
						@if ( !$actividad )
							<td>
								<a href="{{ route('GET_lista_evidencias',['cactividad'=>$checklist->actividad->cactividad]) }}">
									{{ $checklist->actividad->cactividad }} - {{ $checklist->actividad->nactividad }}
								</a>
							</td>
						@endif
						<td>{{$checklist->fecha}}</td>
						<td>
							<!-- <a class="btn btn-primary" href="{{$checklist->path}}" download="">Descargar</a> -->
						</td>
						<td>
							<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalEnviar">Enviar</button> -->
						</td>
					</tr>
				@endforeach

				@foreach ($evidencias as $evidencia)
					<tr>
						<td> EVIDENCIA </td>
						<td> {{ $evidencia->cevidencia }} </td>

						<td></td>
						<td><img width="30px" src="{{ $evidencia->previewimg }}" alt=""></td>
						<td>{{$evidencia->nombre}}</td>
						<td>{{$evidencia->descripcion}}</td>
						@if ( !$actividad )
							<td>
								<a href="{{ route('GET_lista_evidencias',['cactividad'=>$evidencia->actividad->cactividad]) }}">
									{{ $evidencia->actividad->cactividad }} - {{ $evidencia->actividad->nactividad }}
								</a>
							</td>
						@endif
						<td>{{$evidencia->fregistro}}</td>
						<td>
							<a class="btn btn-primary" href="{{$evidencia->path}}" download="">Descargar</a>
						</td>
						<td>
						<!-- Trigger the modal with a button -->
							<!-- <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalEnviar">Enviar</button> -->
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@endsection

@section('scripts')
	<script src="https://cdn.datatables.net/select/1.2.3/js/dataTables.select.min.js"></script>
	<script>
		var table= $(".evidencias").DataTable({
			columnDefs: [ {
				orderable: false,
				className: 'select-checkbox',
				targets:   2
			} , {
				visible: false,
				targets:   [0,1]
			} ,],
			"paging":   true,
			"ordering": true,
			"info":     true,
			"searching":true,
			"language": DTspanish,
			"bLengthChange":false,
			"responsive": true,
			select: {
				style:    'os',
				selector: 'td:first-child',
				style: 'multi',
			},
		})

		$("#modalEnviar").on('show.bs.modal',function(){
			var files = getFiles()
			if ( files ){
				var ul = $("#files-list")
				ul.empty()

				files.forEach(function(file){
					console.log(ul)
					console.log(file)
					ul.append(
						$("<li>").html(file.name)
					)
				})
			}
		})


		function removeItem(){
			var button = this
			var item = $(button).closest("li")[0]
			var ul = document.getElementById("email-list");
			ul.removeChild(item);
		}

		function sendEmails(){
			var emails = getEmails()
			var files = getFiles()

			var asunto = $("#asunto").val() || "Archivos ASIES"
			var mensaje = $("#mensaje").val() || "..."

			if ( emails && files ){
				Models.Actividades.sendMails(asunto,mensaje, emails, files)
			}else{
				alertify.error("Revise los Emails y Archivos.")
			}
			table.rows().deselect()
			$("#email-list").empty()


		}
		function getFiles(){
			var data = {
				evidencias: [],
				actas: [],
				checklits: [],
			}
			var evidencias = table.rows( { selected: true } ).data().toArray().map(item => ({
				type: item[0],
				id: item[1],
				name: item[4],
			}));

			// console.log(table.rows( { selected: true } ).data().toArray())

			return evidencias.length ? evidencias : null
		}
		function getEmails(){
			var emails = $("#email-list li span.email").toArray().map(span => span.innerHTML)
			if ( $("#all").prop("checked") ) emails.push("__ALL__")
			emails = $.unique(emails)

			return emails.length != 0 ? emails : null
		}

		function addItem(){
			var ul = $("#email-list");
		  var candidate = document.getElementById("candidate");
		  var li = $("<li>");
		  var email = candidate.value
		if ( candidate.validity.valid && email != '' ){
			var text = $("<span class='email'></span>").html(email)
			li.attr("id",email).addClass("item-email-list label label-primary").append(text)
			// li.setAttribute('id',email);
			// li.classList.add("label");
			// li.appendChild(text);

			var button = $("<label></label>").addClass("label label-danger pull-right").html("x").on("click",removeItem)[0];

			li.append(button);
			ul.append(li);
		  }
		}

	</script>
@endsection
