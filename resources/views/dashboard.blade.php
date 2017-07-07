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
	<div class="row">
			<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							Dashboard <b>{{ Auth::user()->persona->nombreCompleto() }}</b>
							@permission('planes.calculate_points')
								<button class="btn btn-primary" onclick="Models.Planes.recalcular()">Recalcular Puntos</button>
							@endpermission
						</div>
						<div class="panel-body" style="overflow: overlay">
							<div class="row">
								<div class="col-md-12">
									<h2>Actividades Proximas</h2>
									<div class="list-group text-center">
										@forelse( $actividades_proximas as $actividad )
											<div class="list-group-item col-md-4">
												<a class="btn btn-success btn-block" href="{{ URL::route('realizar_actividad',['cactividad'=>$actividad->cactividad]) }}">
													{{$actividad->nactividad}}
													<br>
													<span class="badge badge-default badge-pill">{{$actividad->fini}}</span>
												</a>
											</div>
										@empty
											<div class="list-group-item col-md-4">
												<h3>No tiene</h3>
											</div>
										@endforelse
									</div>
								</div>
								<div class="col-md-12">
									<div id="charts_div" class="row text-center" ></div>
								</div>
							</div>
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
				planes.forEach(function(plan){
					var data = [['Label', 'Porcentaje'],]

					plan.porcentaje = parseInt((100*plan.valor_plan)/plan.valor_total)
					plan.porcentaje = isNaN(plan.porcentaje) ? 0 : plan.porcentaje

					data.push(["",plan.porcentaje])

					console.log(data)
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
					var div = $("<div class='col-lg-4 col-md-4 col-sm-12 col-xs-12'></div>")[0]
					var chart = new google.visualization.Gauge(div);
					chart.draw(data, options);

					$(div).append($("<a>",{html:plan.nplan,href:"/planes/status/"+plan.cplan,class:"btn btn-success"}))
					$("#charts_div").append($(div))
				})
				waitingDialog.hide()

				/*planes.forEach(function(plan){
					$("table.buttons").find("tr").append(
						$("<td>").append(
							$("<a>",{html:plan.nplan,href:"/planes/status/"+plan.cplan,class:"btn btn-success"})
						)
					)
				})*/

			})
		}
	</script>
@endsection
