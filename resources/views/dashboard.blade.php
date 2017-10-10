@extends('layouts.app')

@section('styles')
	<style>
		#charts_div table{
			width: auto;
			margin: 0 auto !important;
		}
	</style>
@endsection('styles')

@section('content')
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>
					Dashboard <b>{{ Auth::user()->persona->nombreCompleto() }}</b>
				</h4>
				@permission('planes.calculate_points')
					<button class="btn btn-primary" onclick="local_recalcular_puntos()">Recalcular Puntos</button>
				@endpermission
			</div>
		</div>

		<div class="col-md-6">
			<div id="char_estado_tareas" class="row text-center" ></div>
		
			<h4 class="text-center">Actividades Proximas</h4>
			<div class="list-group text-center row">
				@forelse( $actividades_proximas as $actividad )
					<div class="list-group-item col-md-6">
						<a class="btn btn-success btn-block" href="{{ URL::route('realizar_actividad',['cactividad'=>$actividad->cactividad]) }}">
							{{$actividad->nactividad}}
							<br>
							<span class="badge badge-default badge-pill">{{$actividad->fini}}</span>
						</a>
					</div>
				@empty
					<div class="list-group-item">
						<h3>No tiene</h3>
					</div>
				@endforelse
			</div>
		</div>
		<div class="col-md-6">
			<div id="charts_div" class="row text-center" ></div>
		</div>
	</div>

@endsection

@section('scripts')

	<script type="text/javascript">
		var asignaciones = {!! json_encode($asignaciones) !!}
		waitingDialog.show("Cargando Estadisticas...")
	</script>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">

		function local_recalcular_puntos(){
			Models.Planes.recalcular(function(){
				$("#charts_div").empty()
				drawChart()
			})
		}

		google.charts.load('current', {'packages':['gauge','corechart']});
		google.charts.setOnLoadCallback(drawChart);
		/*
		* Reducir Funete G Chart
		$("svg [text-anchor='middle']").css({fontSize:"20px"})
		*/
		function drawChart() {


			var data = google.visualization.arrayToDataTable([
				['Estado', 'Cantidad'],
				['Realizadas',     asignaciones.ok],
				['No Realizadas', asignaciones.no_ok]
			]);

			var options = {
			title: `Tareas Asignadas ( totales ${asignaciones.totales} )`
			};

			var chart = new google.visualization.PieChart(document.getElementById('char_estado_tareas'));

			chart.draw(data, options);
			


			Models.Planes.all(function(planes){
				planes.forEach(function(plan){
					var data = [['Label', 'Porcentaje'],]

					plan.porcentaje = parseInt((100*plan.valor_plan)/plan.valor_total)
					plan.porcentaje = isNaN(plan.porcentaje) ? 0 : plan.porcentaje

					data.push(["",plan.porcentaje])

					var data = google.visualization.arrayToDataTable(data);
					var options = {
						width: 800, height: 240,
						redFrom: 0, redTo: 60,
						yellowFrom:61, yellowTo: 80,
						greenFrom:81, greenTo: 100,
						minorTicks: 5,
						legend:{textStyle:{fontSize:'9'}},
						tooltip: {textStyle:  {fontSize: 9,bold: false}},
					};
					var div = $("<div class='col-md-12'></div>")[0]
					var chart = new google.visualization.Gauge(div);
					chart.draw(data, options);

					$(div).append($("<a>",{html:plan.nplan,href:"/planes/status/"+plan.cplan,class:"btn btn-success"}))
					$("#charts_div").append($(div))
				})
				waitingDialog.hide()

			})
		}
	</script>
@endsection
