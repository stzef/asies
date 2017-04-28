@extends('layouts.independent')

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('jstree/css/themes/default/style.min.css') }}" >
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
					<div id="treeview" class="demo"></div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<!--<script src="{{ URL::asset('DataTables-1.10.14/media/js/dataTables.bootstrap.min.js') }}"></script>-->
	<script src="{{ URL::asset('jstree/js/jstree.min.js') }}"></script>


	<script>
		function returnTask (evt, data){
			console.log(data)
			var tarea = $('#treeview').jstree('get_selected',true)[0]
			console.log(tarea)
			alertify.confirm("Desea escoger esta Tarea",function(){
				window.opener.$(window.INPUT_REFERENCE)
					.val(tarea.li_attr.cplan)
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
			console.info(response)
			$('#treeview').jstree({
				'core' : { 'data' : response }
			})
		})

	</script>
	<script>
		if ( window.ASIES_IS_WIN_POPUOT ) {
			$('#treeview').on('changed.jstree', returnTask)
		}
	</script>


@endsection
