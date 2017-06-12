@extends('layouts.app')

@section('content')
	<div class="row">
			<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							Dashboard <b>{{ Auth::user()->persona->nombreCompleto() }}</b>
							@permission('planes.calculate_points')
								<button class="btn btn-primary" onclick="Models.Planes.recalcular()">Recaulcular Puntos</button>
							@endpermission
						</div>
						<div class="panel-body" style="overflow: overlay">
							<div id="chart_div" ></div>
							<table class="table buttons">
								<tr></tr>
							</table>
						</div>
					</div>
			</div>
	</div>
@endsection

@section('scripts')

	<script type="text/javascript">
		waitingDialog.show("Cargando Estadisticas...")
	</script>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<script type="text/javascript">

		google.charts.load('current', {'packages':['gauge']});
		google.charts.setOnLoadCallback(drawChart);
		/*
		* Reducir Funete G Chart
		$("svg [text-anchor='middle']").css({fontSize:"20px"})
		*/
		function drawChart() {
			Models.Planes.all(function(planes){
				var data = [['Label', 'Porcentaje'],]
				planes.forEach(function(plan){
					plan.porcentaje = parseInt((100*plan.valor_plan)/plan.valor_total)
					plan.porcentaje = isNaN(plan.porcentaje) ? 0 : plan.porcentaje
					data.push(["",plan.porcentaje])
				})
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
				planes.forEach(function(plan){
					$("table.buttons").find("tr").append(
						$("<td>").append(
							$("<a>",{html:plan.nplan,href:"/planes/status/"+plan.cplan,class:"btn btn-success"})
						)
					)
				})
				var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
				chart.draw(data, options);
				waitingDialog.hide()
			})
		}
	</script>
@endsection
