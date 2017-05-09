@extends('layouts.independent')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('vendor/jstree/css/themes/default/style.min.css') }}" >
	<style>
		body{
			background: inherit;
		}
	</style>
@endsection


@section('content')
	<div class="row">

		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					Planes
				</div>

				<div class="panel-body">
					<ul class="nav nav-tabs">
						<li data-treeview="#treeview_1" class="active"><a data-toggle="tab" href="#home">Home</a></li>
						<li data-treeview="#treeview_2" ><a data-toggle="tab" href="#menu1">Menu 1</a></li>
						<li data-treeview="#treeview_3" ><a data-toggle="tab" href="#menu2">Menu 2</a></li>
					</ul>

					<input type="text" id="treeview_find" value="" placeholder="Buscar..." class="input" style="margin:0em auto 1em auto; display:block; padding:4px; border-radius:4px; border:1px solid silver;">
					<div class="tab-content">
						<div id="home" class="tab-pane fade in active" data-treeview="#treeview_1">
							<div id="treeview_1"></div>
						</div>
						<div id="menu1" class="tab-pane fade" data-treeview="#treeview_2">
							<div id="treeview_2"></div>
						</div>
						<div id="menu2" class="tab-pane fade" data-treeview="#treeview_3">
							<div id="treeview_3"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<!--<script src="{{ URL::asset('DataTables-1.10.14/media/js/dataTables.bootstrap.min.js') }}"></script>-->
	<script src="{{ URL::asset('vendor/jstree/js/jstree.min.js') }}"></script>


	<script>

	$(".nav.nav-tabs li").click(function(){
		var that = this
		TREEVIEW_SELECT = $(that).data("treeview")
		$('#treeview_find').val("")
	})

		function returnTask (evt, data){
			var treeview = $(this)
			console.log(treeview)
			var tarea = treeview.jstree('get_selected',true)[0]
			var rvalue = tarea.li_attr.cplan | tarea.li_attr.ctarea
			alertify.confirm("Desea escoger esta Tarea",function(){
				window.opener.$(window.INPUT_REFERENCE)
					.val(rvalue)
					.focus()
					.trigger("change")

				window.close()
			})
			//selected node object: data.inst.get_json()[0];
			//selected node text: data.inst.get_json()[0].data
		}
		$.jstree.defaults.plugins = [ "wholerow", "checkbox" ]
		$.jstree.defaults.checkbox.keep_selected_style = true
		$.jstree.defaults.core.multiple = false

		Models.Planes.treeview(function(response){

			console.log(response)
			for ( var action of response ){
				var select_treeview = "#"+action.li_attr.select_treeview
				var select_label_treeview = "li[data-treeview=#"+action.li_attr.select_treeview+"] a"
				console.log(action)
				$(select_label_treeview).html(action.text.truncate(15,"..."))
				$(select_label_treeview).attr("title",action.text)
				$(select_treeview).jstree({
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
					'core' : { 'data' : action },
				})
				if ( window.ASIES_IS_WIN_POPUOT ) $(select_treeview).on('changed.jstree', returnTask)
			}

		})

	</script>
	<script>
				var to = false;
		$('#treeview_find').keyup(function () {
			if(to) { clearTimeout(to); }
			to = setTimeout(function () {
				var v = $('#treeview_find').val();
				$(TREEVIEW_SELECT).jstree(true).search(v);
			}, 250);
		});
	</script>


@endsection
