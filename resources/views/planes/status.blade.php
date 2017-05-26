@extends('layouts.app')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('vendor/jstree/css/themes/default/style.min.css') }}" >

@endsection


@section('content')
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">
				{{ $plan->nplan }} <small>Vista General</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active">
					<i class="fa fa-dashboard"></i> Planes
				</li>

			</ol>
		</div>
	</div>
	<div class="row">

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Planes</div>

				<div class="panel-body">
					<div id="treeview"></div>
					<div id="chart_div"></div>

				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ URL::asset('vendor/DataTables-1.10.14/media/js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ URL::asset('vendor/DataTables-1.10.14/extensions/Buttons/js/buttons.bootstrap.min.js') }}"></script>
	<script src="{{ URL::asset('vendor/DataTables-1.10.14/extensions/Buttons/js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript">
</script>
	<script src="{{ URL::asset('vendor/jstree/js/jstree.min.js') }}"></script>


	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
		google.charts.load('current', {'packages':['gauge']});
		google.charts.setOnLoadCallback(drawChart);

		function drawChart() {
			Models.Planes.findOne("{{ $plan->cplan}}",function(plan){
				var data = [['Label', 'Porcentaje'],]
				plan.subplanes.forEach(function(plan){
					plan.porcentaje = parseInt((100*plan.valor_plan)/plan.valor_total)
					data.push([plan.ncplan,plan.porcentaje])
				})
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

	<script>
		var TREEVIEW_SELECT = "#treeview"
		Models.Planes.findOne("{{ $plan->cplan}}",function(response){
			var data = Models.Utils.dataToTreeview([response])
			$.jstree.defaults.contextmenu.items = {
				showDetail : {
					action : function(){
						var item = $(TREEVIEW_SELECT).jstree('get_selected',true)[0]
						if ( item.li_attr.cplan != undefined ){
							window.open("/planes/status/__cplan__".set("__cplan__",item.li_attr.cplan))
						}else{
							alertify.warning("El item escogido no es un plan")
						}
					},
					label : "Ver en Detalle"
				}
			}
			$(TREEVIEW_SELECT).jstree({
				"plugins" : [ "search" , "contextmenu", "types"],
				"types" : {
					"modulo" : {
						"icon" : "/vendor/jstree/img/module.png"
					},
					"tareas" : {
						"icon" : "/vendor/jstree/img/"
					},
					"componente" : {
						"icon" : "/vendor/jstree/img/component.png"
					},
					"elemento" : {
						"icon" : "/vendor/jstree/img/element.png"
					},
					"prod_minimo" : {
						"icon" : "/vendor/jstree/img/product.png"
					},
				},
				'core' : { 'data' : data },
			})

			var to = false;
			$('#treeview_find').keyup(function () {
				if(to) { clearTimeout(to); }
				to = setTimeout(function () {
					var v = $('#treeview_find').val();
					$(TREEVIEW_SELECT).jstree(true).search(v);
				}, 250);
			});

		})
	</script>

@endsection
