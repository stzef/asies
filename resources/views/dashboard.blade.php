@extends('layouts.app')

@section('content')
		<div class="row">
				<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">Dashboard <b>{{ Auth::user()->persona->nombreCompleto() }}</b></div>
							<div class="panel-body">
								<div id="chart_div" ></div>
							</div>
						</div>
				</div>
		</div>


@endsection

@section('scripts')

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		google.charts.load('current', {'packages':['gauge']});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			Models.Planes.all(function(planes){
				var data = [['Label', 'Porcentaje'],]
				planes.forEach(function(plan){
					plan.porcentaje = parseInt((100*plan.valor_plan)/plan.valor_total)
					data.push([plan.ncplan,plan.porcentaje])
				})
				console.log(data)
				var data = google.visualization.arrayToDataTable(data);
				var options = {
					width: 800, height: 240,
					redFrom: 0, redTo: 60,
					yellowFrom:61, yellowTo: 80,
					greenFrom:81, greenTo: 100,
					minorTicks: 5
				};
				var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
				chart.draw(data, options);
			})
		}
	</script>
@endsection
