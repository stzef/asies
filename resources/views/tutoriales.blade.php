@extends('layouts.app')

@section('content')

		<div>
			<div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Tutoriales</h4>
                </div>
            </div>

			<div class="row">
			  <div class="col-md-4">
			    <div class="list-group" id="myList" role="tablist">
			      <a class="list-group-item list-group-item-action active" data-toggle="list" href="#list-crearactividad" role="tab">Video  Crear una Actividad</a>
			      <a class="list-group-item list-group-item-action " data-toggle="list" href="#list-agregarTareas" role="tab">Video  Agregar nuevas Tareas</a>
			      <a class="list-group-item list-group-item-action " data-toggle="list" href="#list-realizarTareas" role="tab">Video  Realizar Tareas</a>
			      <a class="list-group-item list-group-item-action " data-toggle="list" href="#list-crearActas" role="tab">Video  Crear Actas</a>
			      <a class="list-group-item list-group-item-action " data-toggle="list" href="#list-agregarEvidencias" role="tab">Video  Agregar Evidencias</a>

			    </div>
			  </div>
			  <div class="col-md-8">
			    <div class="tab-content" id="nav-tabContent">
			      <div class="tab-pane fade" id="list-crearactividad" role="tabpanel" ><iframe width="70%" height="315px" src="https://www.youtube.com/embed/tQR4zwzZ8Wk" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe></div>
			      <div class="tab-pane fade" id="list-agregarTareas" role="tabpanel"><iframe width="70%" height="315px" src="https://www.youtube.com/embed/JZBs5QBnl0I" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe></div>
			      <div class="tab-pane fade" id="list-realizarTareas" role="tabpanel"><iframe width="70%" height="315px"  src="https://www.youtube.com/embed/QSxVucHacUA" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe></div>
			      <div class="tab-pane fade" id="list-crearActas" role="tabpanel"><iframe width="70%" height="315" src="https://www.youtube.com/embed/SI4x0SofH0c" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe></iframe></div>
			      <div class="tab-pane fade" id="list-agregarEvidencias" role="tabpanel"><iframe width="70%" height="315px" src="https://www.youtube.com/embed/9POJ_0uNHRQ" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe></div>
			    </div>
			  </div>
			</div>



		</div>

@endsection

@section('scripts')
	
	<script>


		$('#myList a:first').tab('show')

		$('#myList a').on('click', function (e) {
		  	e.preventDefault()
		  	$('a.active').removeClass('active')
			$(this).addClass('active')
		  	$(this).tab('show')
		})

	</script>

@endsection